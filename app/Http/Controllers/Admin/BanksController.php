<?php

namespace codeFin\Http\Controllers\Admin;

use codeFin\Http\Controllers\Controller;
use codeFin\Http\Controllers\Response;
use Illuminate\Http\Request;
use codeFin\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use codeFin\Http\Requests\BankCreateRequest;
use codeFin\Http\Requests\BankUpdateRequest;
use codeFin\Repositories\BankRepository;
use codeFin\Events\BankCreatedEvent;
use codeFin\Models\Bank;

class BanksController extends Controller {

    /**
     * @var BankRepository
     */
    protected $repository;

    public function __construct(BankRepository $repository) { // remoer sempre , BankValidator $validator
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $banks = $this->repository->paginate(5); // paginação parecido com o all()

        return view('admin.banks.index', compact('banks'));
    }

    // metodo apenas para mostrar o formulario
    public function create() {
        return view('admin.banks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BankCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(BankCreateRequest $request) {
        $data = $request->all();
        $this->repository->create($data);
        return redirect()->route('admin.banks.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $bank = $this->repository->find($id);
        return view('admin.banks.edit', compact('bank'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  BankUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(BankUpdateRequest $request, $id) {
        $this->repository->update($request->all(), $id);
        return redirect()->route('admin.banks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $this->repository->delete($id);
        return redirect()->route('admin.banks.index');
    }

}
