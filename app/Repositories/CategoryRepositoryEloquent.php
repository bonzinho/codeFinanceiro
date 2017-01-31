<?php

namespace codeFin\Repositories;

use codeFin\Presenters\CategoryPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use codeFin\Repositories\CategoryRepository;
use codeFin\Models\Category;
use codeFin\Validators\CategoryValidator;

/**
 * Class CategoryRepositoryEloquent
 * @package namespace codeFin\Repositories;
 */
class CategoryRepositoryEloquent extends BaseRepository implements CategoryRepository
{

    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        if (isset($attributes['parent_id'])){
            // incluir uam categora filha (criar)
            $skipPresenter  = $this->skipPresenter;
            $this->skipPresenter('true');
            $parent = $this->find($attributes['parent_id']); // pega ainstancia do eloquent
            $this->skipPresenter = $skipPresenter;
            $child = $parent->children()->create($attributes);
            return $this->parserResult($child);
        }else{
            //incluir uma categoria pai
            return parent::create($attributes);
        }
    }

    /**
     * @param array $attributes
     * @param $id
     * @return mixed
     */
    public function update(array $attributes, $id)
    {
        if (isset($attributes['parent_id'])){  // se o parent id existir
            // incluir uam categora filha (criar)
            $skipPresenter  = $this->skipPresenter;
            $this->skipPresenter('true');
            $child = $this->find($id); // pega ainstancia do eloquent
            $child->parent_id = $attributes['parent_id'];
            $child->save();
            $this->skipPresenter = $skipPresenter;
            return $this->parserResult($child);
        }else{
            //incluir uma categoria pai
            return parent::update($attributes);
        }
    }


    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Category::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function presenter(){
        return CategoryPresenter::class;
    }
}
