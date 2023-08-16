<?php

namespace App\Modules\AdminPanel\Http\Controllers\Other;

use Illuminate\Support\Facades\DB;

trait Position 
{
    /**
        * For structure entities, after saving.
        * @param $entity
    */
    // protected function after($entity)
    // {
    //     $this->autoPosition($entity);
    // }

    /**
     * Simple position change,
     * this method works correctly if records are sorted in descending order.
     * @param $id
     * @param $direction - value: up, down
     */
    public function position($id, $direction)
    {
        $entity = $this->getModel()->findOrFail($id);

        if($direction == 'up')                                                              //if user clicked "up"
        {
            return $entity->update(['position' => ++$entity->position]);
        }
        elseif($direction == 'down')                                                        //if user clicked "down"
        {
            return $entity->update(['position' => --$entity->position]);
        }
        else {
            return redirect()->back();
        }
    }
    
    /**
        *Change positions for structural data where there are parent and child elements, 
        * this method works correctly if records are sorted in ascending order.
        * @param $id
        * @param $direction - value: up, down
    */
    public function positionStructure($id, $direction)
    {
        $entity = $this->getModel()->findOrFail($id);
        $currentPosition = $entity->position;
        
        if(!isset($currentPosition)) return redirect()->back()->with('message', trans('AdminPanel::adminpanel.messages.no_position_field', ['field' => 'position']));

        $previousEntity = $this->getPreviousEntity($entity);                                //get previous entity
        $nextEntity = $this->getNextEntity($entity);                                        //get next entity

        if($direction == 'up')                                                              //if user clicked "up"
        {
            if(!isset($previousEntity))                                                     //checking is there previous entity
            {
                return redirect()->back()->with('success', trans('AdminPanel::adminpanel.messages.position_max_top'));
            }

            $newPosition = $previousEntity->position;                                       //new entity position
            
            $childrensCount = 1;                                                            //entity children count
            $previousChildrensCount = 1;                                                    //previous entity children count
            $childrensId = [];                                                              //array children id of the entity

            if(count($previousEntity->children))
            {
                $previousChildrens = $this->getDescendants($previousEntity)->collect();     //get all Descendants of the previous entity

                $previousChildrensCount = count($previousChildrens) + 1;
            }

            if(count($entity->children))
            {
                $childrens = $this->getDescendants($entity)->collect();                     //get all Descendants of the entity

                $childrensCount = count($childrens) + 1;
                $firstChildren = $childrens->first();
                $lastChildren = $childrens->last();
                $childrensId = $childrens->pluck('id');

                $this->getModel()
                        ->whereBetween('position', [$firstChildren->position, $lastChildren->position])
                        ->update(['position' => DB::raw('`position` - ' . $previousChildrensCount)]);   //update entity children - decrease by the number of children of the previous entity
            }

            $this->getModel()
                    ->whereBetween('position', [$newPosition, $currentPosition])
                    ->whereNotIn('id', $childrensId)
                    ->update(['position' => DB::raw('`position` + ' . $childrensCount)]);   //update previous entity, her children and this entity positions
        } 
        elseif($direction == 'down')                                                        //if user clicked "down"
        {
            if(!isset($nextEntity))                                                         //checking is there next entity
            {
                return redirect()->back()->with('success', trans('AdminPanel::adminpanel.messages.position_max_bottom'));
            }
            
            $childrensCount = 1;                                                            //entity children count
            $nextChildrensCount = 1;                                                        //next entity children count
            $childrensId = [];                                                              //array children id of the entity
            
            $newPosition = $currentPosition + $nextChildrensCount;                          //new entity position
            
            $startPosition = $nextEntity->position;
            $finishPosition = $nextEntity->position;

            if(count($nextEntity->children))
            {
                $nextChildrens = $this->getDescendants($nextEntity)->collect();             //get all Descendants of the next entity

                $nextChildrensCount = count($nextChildrens) + 1;
                $nextLastChildren = $nextChildrens->last();
                
                $newPosition = $currentPosition + $nextChildrensCount;
                $finishPosition = $nextLastChildren->position;                              //if next entity has children, change $finishPosition to the position of the last child
            }

            if(count($entity->children))
            {
                $childrens = $this->getDescendants($entity)->collect();                     //get all Descendants of the entity

                $childrensCount = count($childrens) + 1;
                $firstChildren = $childrens->first();
                $lastChildren = $childrens->last();
                $childrensId = $childrens->pluck('id');

                $this->getModel()
                        ->whereBetween('position', [$firstChildren->position, $lastChildren->position])
                        ->update(['position' => DB::raw('`position` + ' .  $nextChildrensCount)]);      //update entity children - ncrease by the number of children of the next entity
            }

            $this->getModel()
                    ->whereBetween('position', [$startPosition, $finishPosition])
                    ->whereNotIn('id',  $childrensId)
                    ->update(['position' => DB::raw('`position` - ' . $childrensCount)]);   //update next entity, previous entity and her children positions
        }
        else {
            return redirect()->back();
        }

        $entity->update(['position' => $newPosition]);                                      //update this entity positions

        return redirect()->back();
    }

    /**
     * Find next entity with the same parent andsame depth and where 'position' > $entity->position.
     * @param $entity
     */
    public function getNextEntity($entity)
    {
        $nextEntity = $this->getModel()
                            ->where('position', '>', $entity->position)
                            ->where('parent_id', $entity->parent_id)
                            ->where('depth', $entity->depth)
                            ->orderBy('position', 'asc')
                            ->first();

        return $nextEntity;
    }

    /**
     * Find all previous entity with the same parent andsame depth and where 'position' < $entity->position.
     * @param $entity
     */
    public function getPreviousEntity($entity)
    {
        $previousEntity = $this->getModel()
                                ->where('position', '<', $entity->position)
                                ->where('parent_id', $entity->parent_id)                                
                                ->where('depth', $entity->depth)
                                ->orderBy('position', 'desc')
                                ->first();

        return $previousEntity;
    }

    /**
     * Find all children of one parent.
     * @param $entity
     */
    public function getDescendants($entity) {
        $entity->load('children');                                              // the load('children') method preloads all children for the parent
        $allDescendants = $entity->children->flatMap(function ($child) {        // the flatMap() method is used to recursively get all the children and merge them into one collection
            return $child->getAllDescendants()->prepend($child);                // The prepend() method adds the current child before his descendants in the collection.
        });

        return $allDescendants;
    }

    /**
     * In the After method, this method is called to automatically change positions, 
     * when creating, updating or deleting this entity.
     * @param $entity
     */
    public function autoPosition($entity)
    {
        $parent = $this->getModel()->findOrFail($entity->parent_id);
        
        /*
            Getting value from session whether the parent has been changed.
            You have to add this code in the Update medthod after updating.
            For example:
                $originalParentId = $entity->parent_id;             //save old position
                $newParentId = $request->all()['parent_id'];        //save new position
                $entity->update($request->all());                   //updating
                $originalParentId != $newParentId ? session(['changedParentId' => true]); : session(['changedParentId' => false]);
        */
        $changedParentId = session('changedParentId');
        session()->forget('changedParentId');

        $lastDescendants = $this->getDescendants($parent)                                   //get last Descendants
                                ->whereNotIn('id', [$entity->id])
                                ->sortBy('position')
                                ->last();

        if (getMethod() == 'store' || getMethod() == 'update' && $changedParentId == true) {
            if(count($parent->children) == 1)                                               //if parent has 1 children (this entity is parent's child)
            {
                $newPosition = ++$parent->position;                                         //increase by 1 parent position
            }
            else {
                $newPosition = ++$lastDescendants->position;                                //increase by 1 last descendant position
            }

            if($entity->position != NULL && $entity->position > $newPosition)
            {
                $this->getModel()
                        ->whereBetween('position', [$newPosition, $entity->position])
                        ->whereNotIn('id', [$entity->id])
                        ->update(['position' => DB::raw('`position` + 1')]);
            }

            if($entity->position != NULL && $entity->position < $newPosition)
            {
                $this->getModel()
                        ->whereBetween('position', [$entity->position, --$newPosition])
                        ->whereNotIn('id', [$entity->id])
                        ->update(['position' => DB::raw('`position` - 1')]);
            }

            if($entity->position == NULL)
            {
                $this->getModel()
                    ->where('position', '>=', $newPosition)
                    ->whereNotIn('id', [$entity->id])
                    ->update(['position' => DB::raw('`position` + 1')]);
            }

            $entity->position = $newPosition;
            
            $entity->save();
        }

        if(getMethod() == 'destroy') {
            $this->getModel()
                    ->where('position', '>', $entity->position)
                    ->update(['position' => DB::raw('`position` - 1')]);
        }
    }
}