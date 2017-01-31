<?php

namespace codeFin\Http\Controllers\Api;

use codeFin\Criteria\FindByLikeAgencyCriteria;
use codeFin\Criteria\FindByNameCriteria;
use codeFin\Criteria\FindRootCategoriesCriteria;
use codeFin\Criteria\WithDepthCategoriesCriteria;
use codeFin\Http\Controllers\Controller;
use codeFin\Http\Controllers\Response;
use codeFin\Http\Requests\CategoryRequest;
use codeFin\Repositories\CategoryRepository;


class CategoriesController extends Controller
{

    /**
     * @var CategoryRepository
     */
    protected $repository;



    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
        $this->repository->pushCriteria(new WithDepthCategoriesCriteria());
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(new FindRootCategoriesCriteria()); // usar o criteria

        $categories = $this->repository->all();
        return $categories;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CategoryRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $category = $this->repository->skipPresenter()->create($request->all());
        $this->repository->skipPresenter(false);
        $category = $this->repository->find($category->id);
        return response()->json($category, 201); // retorna o array e o estatus code 201 que significa que foi criado
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = $this->repository->find($id);
        return response()->json($category); // status code 200 OK
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CategoryRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(CategoryRequest $request, $id){

            $category = $this->repository->update($request->all(), $id);
            return  response()->json($category, 200); // status code ok


    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->repository->delete($id);
        return response()->json([], 204); // p ststus ode 2014 não deixa enviar informação se quisermos enviar informação no array temos de mudar para status code 200

    }
}
