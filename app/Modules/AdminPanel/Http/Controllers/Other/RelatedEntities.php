<?php

namespace App\Modules\AdminPanel\Http\Controllers\Other;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait RelatedEntities
{
    public function after($entity)
    {
        if (getMethod() == 'store' || getMethod() == 'update') {
            //RelatedEntities
            $this->editRelatedEntities($entity->id, session('requestArray'));
        }
        if(getMethod() == 'destroy') {
            //RelatedEntities
            $this->deleteRelated($entity->id);
        }
    }

    /**
     * To display hints of related entities, ajax.
     * @param Request $request - null|string
     * @return array - array of all table entities matching the query
     */
    public function related(Request $request) : array
    {
        $q = isset($request->q) ? htmlspecialchars(trim($request->q)) : '';
        $data['items'] = [];
        
        $items = DB::table(getTableName())
                    ->select('id', 'title')
                    ->where('title', 'LIKE', ["%{$q}%"])
                    ->limit(10)
                    ->get();
        
        if ($items) {
            $i = 0;
            foreach ($items as $title) {
                $data['items'][$i]['id'] = $title->id;
                $data['items'][$i]['text'] = $title->title;
                $i++;
            }
        }
        echo json_encode($data);
        die;
    }

    /**
     * Gets an array of records of related entities of this entity.
     * @param Request $id - $entity->id
     */
    public function getEntityRelated($id)
    {
        return $this->getModel()
                    ->join($this->relatedTable['table'], $this->relatedTable['main_table'] . '.id', '=', $this->relatedTable['table'] . '.related_id')
                    ->select($this->relatedTable['main_table'] . '.title', $this->relatedTable['table'] . '.related_id')
                    ->where($this->relatedTable['table'] . '.news_id', $id)
                    ->get();
    }

    /**
     * Edit related entities.
     * @param $id - $entity->id
     * @return void
     */
    public function editRelatedEntities($id, $requestArray) : void
    {
        session()->forget('requestArray');
        $entity = $this->getModel()->findOrFail($id);   
        $related_entities = $entity->relatedNews->pluck('related_id')->toArray();

        /** If removed related products */
        if (empty($requestArray['related']) && !empty($related_entities)) {
            $this->deleteRelated($id);
        }

        /** If added related products */
        if (empty($related_entities) && !empty($requestArray['related'])) {
            $this->updateRelated($requestArray['related'], $id);
        }

        /** If changed related products */
        if (!empty($requestArray['related'])) {
            $result = array_diff($related_entities, $requestArray['related']);
            if (!(empty($result)) || count($related_entities) != count($requestArray['related'])) {
                $this->deleteRelated($id);
                $this->updateRelated($requestArray['related'], $id);
            }
        }
    }

    /**
     * Save related entities.
     * @param $relatedArray - records of related entities of this entity
     * @param $id - $entity->id
     * @return void
     */
    public function updateRelated($relatedArray, $id) : void
    {
        $newArray = [];
        foreach ($relatedArray as $item) {
            $newArray[] = [
                $this->relatedTable['entity_id'] => $id,
                'related_id' => (int)$item,
            ];
        }
        DB::table($this->relatedTable['table'])->insert($newArray);
    }

    /**
     * Delete related entities.
     * @param $id - $entity->id
     * @return void
     */
    public function deleteRelated($id) : void
    {
        DB::table($this->relatedTable['table'])
            ->where($this->relatedTable['entity_id'], $id)
            ->delete();
    }
}