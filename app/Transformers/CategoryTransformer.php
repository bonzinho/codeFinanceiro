<?php

namespace codeFin\Transformers;

use League\Fractal\TransformerAbstract;
use codeFin\Models\Category;

/**
 * Class CategoryTransformer
 * @package namespace codeFin\Transformers;
 */
class CategoryTransformer extends TransformerAbstract
{

    protected $defaultIncludes = ['children'];

    /**
     * Transform the \Category entity
     * @param \Category $model
     *
     * @return array
     */
    public function transform(Category $model)
    {
        return [
            'id'            => (int)$model->id,
            'name'          =>      $model->name,
            'parent_id'     =>      $model->parent_id,
            'depth'         =>      $model->depth,
            'created_at'    =>      $model->created_at,
            'updated_at'    =>      $model->updated_at
        ];
    }

    public function includeChildren(Category $model){
        //if ($model->children->count()){ // se quisermos os fillho usamos este if
        $children = $model->children()->withDepth()->get();
            return $this->collection($children, new CategoryTransformer());
        //}
    }
}
