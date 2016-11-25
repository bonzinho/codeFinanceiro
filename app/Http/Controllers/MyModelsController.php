<?php

namespace codeFin\Http\Controllers;

use Illuminate\Http\Request;

use codeFin\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use codeFin\Http\Requests\MyModelCreateRequest;
use codeFin\Http\Requests\MyModelUpdateRequest;
use codeFin\Repositories\MyModelRepository;
use codeFin\Validators\MyModelValidator;


class MyModelsController extends Controller
{

    /**
     * @var MyModelRepository
     */
    protected $repository;

    /**
     * @var MyModelValidator
     */
    protected $validator;

    public function __construct(MyModelRepository $repository, MyModelValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $myModels = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $myModels,
            ]);
        }

        return view('myModels.index', compact('myModels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MyModelCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(MyModelCreateRequest $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $myModel = $this->repository->create($request->all());

            $response = [
                'message' => 'MyModel created.',
                'data'    => $myModel->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
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
        $myModel = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $myModel,
            ]);
        }

        return view('myModels.show', compact('myModel'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $myModel = $this->repository->find($id);

        return view('myModels.edit', compact('myModel'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  MyModelUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(MyModelUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $myModel = $this->repository->update($id, $request->all());

            $response = [
                'message' => 'MyModel updated.',
                'data'    => $myModel->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
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
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'MyModel deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'MyModel deleted.');
    }
}
