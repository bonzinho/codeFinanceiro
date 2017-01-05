<?php

namespace codeFin\Http\Controllers\Api;

use Illuminate\Http\Request;
use codeFin\Http\Controllers\Controller;
use codeFin\Repositories\BankRepository;
use codeFin\Http\Requests;

class BanksController extends Controller
{
    /**
     * @var BankRepository
     */
    private $repository;

    /**
     * BanksController constructor.
     * @param BankRepository $repository
     */
    public function __construct(BankRepository $repository){
        $this->repository = $repository;
    }

    public function index(){
        return $this->repository->all();
    }
}
