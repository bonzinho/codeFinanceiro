<?php

namespace codeFin\Http\Controllers\Api;

use codeFin\Http\Controllers\Controller;
use codeFin\Http\Controllers\Response;
use codeFin\Http\Requests\BankAccountCreateRequest;
use codeFin\Http\Requests\BankAccountUpdateRequest;
use codeFin\Repositories\BankAccountRepository;


class BankAccountsController extends Controller
{

    /**
     * @var BankAccountRepository
     */
    protected $repository;



    public function __construct(BankAccountRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bankAccounts = $this->repository->all();

        return $bankAccounts;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BankAccountCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(BankAccountCreateRequest $request)
    {
        $bankAccount = $this->repository->create($request->all());
        return response()->json($bankAccount->toArray(), 201); // retorna o array e o estatus code 201 que significa que foi criado

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
        $bankAccount = $this->repository->find($id);
        return response()->json($bankAccount->toArray(), 200); // status code 200 OK

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  BankAccountUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(BankAccountUpdateRequest $request, $id){

            $bankAccount = $this->repository->update($request->all(), $id);
            return  response()->json($bankAccount->toArray(), 200); // status code ok


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
