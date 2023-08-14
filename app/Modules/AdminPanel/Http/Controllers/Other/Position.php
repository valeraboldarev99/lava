<?php

namespace App\Modules\AdminPanel\Http\Controllers\Other;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

trait Position 
{
    /**
        * for structure entities, after saving 
        * @param $entity
    */
    // protected function after($entity)
    // {
    //     $this->autoPosition($entity);
    // }

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
        * Positions for structural data where there are parent and child elements
        * @param $id
        * @param $direction - value: up, down
    */
    public function positionStructure($id, $direction)
    {
        // $this->position($id, $direction);
        // return redirect()->back();

        $entity = $this->getModel()->findOrFail($id);
        $currentPosition = $entity->position;
        $parent = $entity->parent;
        
        if(!isset($currentPosition)) return redirect()->back()->with('message', trans('AdminPanel::adminpanel.messages.no_position_field', ['field' => 'position']));
        if($parent == NULL) return redirect()->back()->with('message', trans('AdminPanel::adminpanel.messages.you_cant_change_main_position'));

        $previousEntity = $this->getPreviousEntity($entity);                                //get previous entity
        $nextEntity = $this->getNextEntity($entity);                                        //get next entity

        if($direction == 'up')                                                              //if user clicked "up"
        {
            if(!isset($previousEntity))
            {
                return redirect()->back()->with('success', trans('AdminPanel::adminpanel.messages.position_max_top'));
            }

            $newPosition = $previousEntity->position;                                       //new entity position
            
            $childrensCount = 1;
            $previousChildrensCount = 1;
            $childrensId = [];

            if(count($previousEntity->children))
            {
                $previousChildrens = $this->getDescendants($previousEntity);
                $previousChildrensCount = count($previousChildrens) + 1;
            }

            if(count($entity->children))
            {
                $childrens = $this->getDescendants($entity);

                $childrensCount = count($childrens) + 1;
                $firstChildren = $childrens->first();
                $lastChildren = $childrens->last();
                $childrensId = $childrens->pluck('id');

                $this->getModel()
                        ->whereBetween('position', [$firstChildren->position, $lastChildren->position])
                        ->update(['position' => DB::raw('`position` - ' . $previousChildrensCount)]);
            }

            $this->getModel()
                ->whereBetween('position', [$newPosition, $currentPosition])
                ->whereNotIn('id', $childrensId)
                ->update(['position' => DB::raw('`position` + ' . $childrensCount)]);                    //update other entities positions
        } 
        elseif($direction == 'down')                                                        //if user clicked "down"
        {
            if(!isset($nextEntity))
            {
                return redirect()->back()->with('success', trans('AdminPanel::adminpanel.messages.position_max_bottom'));
            }
            
            $childrensCount = 1;
            $nextChildrensCount = 1;
            $childrensId = [];
            
            $newPosition = $currentPosition + $nextChildrensCount;                                           //new entity position
            
            $startPosition = $nextEntity->position;
            $finishPosition = $nextEntity->position;

            if(count($nextEntity->children))
            {
                $nextChildrens = $this->getDescendants($nextEntity);

                $nextChildrensCount = count($nextChildrens) + 1;
                $nextLastChildren = $nextChildrens->last();
                
                $newPosition = $currentPosition + $nextChildrensCount;
                $finishPosition = $nextLastChildren->position;
            }

            if(count($entity->children))
            {
                $childrens = $this->getDescendants($entity);
                
                $childrensCount = count($childrens) + 1;
                $firstChildren = $childrens->first();
                $lastChildren = $childrens->last();
                $childrensId = $childrens->pluck('id');

                $this->getModel()
                        ->whereBetween('position', [$firstChildren->position, $lastChildren->position])
                        ->update(['position' => DB::raw('`position` + ' .  $nextChildrensCount)]);
            }
            
            $this->getModel()
                ->whereBetween('position', [$startPosition, $finishPosition])
                ->whereNotIn('id',  $childrensId)
                ->update(['position' => DB::raw('`position` - ' . $childrensCount)]);                    //update other entities positions
        }
        else {
            return redirect()->back();
        }

        $entity->update(['position' => $newPosition]);

        return redirect()->back();
    }

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

    public function autoPosition($entity)
    {
        $parent = $this->getModel()
                        ->where('id', $entity->parent_id)                                
                        ->orderBy('position', 'desc')
                        ->first();

        $lastChildren = $this->getModel()           //???
                                ->where('parent_id', $entity->parent_id)                                
                                ->orderBy('position', 'desc')
                                ->first();
                                
        if (getMethod() == 'store') {
            // if(getMethod() == 'update')
            // {
                
            // }
            if(count($parent->children) == 1)
            {
                $newPosition = $parent->position + 1;
            }
            else {
                $newPosition = $lastChildren->position + 1;
            }

            $this->getModel()
                    ->where('position', '>=', $newPosition)
                    ->update(['position' => DB::raw('`position` + 1')]);

            $entity->position = $newPosition;
            
            $entity->save();
        }

        if(getMethod() == 'destroy') {
            $this->getModel()
                    ->where('position', '>', $entity->position)
                    ->update(['position' => DB::raw('`position` - 1')]);
        }
    }

    /**
     * returns all children of one parent
     * @param $entity
     * @return $allDescendants
     */
    public function getDescendants($entity) {
        $entity->load('children');                                              // the load('children') method preloads all children for the parent
        $allDescendants = $entity->children->flatMap(function ($child) {        // the flatMap() method is used to recursively get all the children and merge them into one collection
            return $child->getAllDescendants()->prepend($child);                // The prepend() method adds the current child before his descendants in the collection.
        });

        return $allDescendants;
    }
}