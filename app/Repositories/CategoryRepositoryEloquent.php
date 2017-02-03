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
        Category::$enableTenant = false; // desablita o multitanacy para criar categorias pai com profundidade 0
        if (isset($attributes['parent_id'])){
            // incluir uam categora filha (criar)
            $skipPresenter  = $this->skipPresenter;
            $this->skipPresenter('true');
            $parent = $this->find($attributes['parent_id']); // pega ainstancia do eloquent
            $this->skipPresenter = $skipPresenter;
            $child = $parent->children()->create($attributes);
            $result =  $this->parserResult($child);
        }else{
            //incluir uma categoria pai
            $result =  parent::create($attributes);
        }
        Category::$enableTenant = true; // volta a ativar o multitanacy depois de criar a categoria pai com a profundidade 0
        return $result;
    }

    /**
     * @param array $attributes
     * @param $id
     * @return mixed
     */
    public function update(array $attributes, $id)
    {
        Category::$enableTenant = false; // volta a ativar o multitanacy depois de criar a categoria pai com a profundidade 0
        if (isset($attributes['parent_id'])){  // se o parent id existir
            // incluir uam categora filha (criar)
            $skipPresenter  = $this->skipPresenter;
            $this->skipPresenter('true');
            $child = $this->find($id); // pega ainstancia do eloquent
            $child->parent_id = $attributes['parent_id'];
            $child->fill($attributes);
            $child->save();
            $this->skipPresenter = $skipPresenter;
            $result =  $this->parserResult($child);
        }else{
            //incluir uma categoria pai
            $result =  parent::update($attributes, $id);
            $result->makeRoot()->save();
        }
        Category::$enableTenant = true; // volta a ativar o multitanacy depois de criar a categoria pai com a profundidade 0
        return $result;
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
