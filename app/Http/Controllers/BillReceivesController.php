<?php

namespace CodeFin\Http\Controllers;

use Illuminate\Http\Request;

use CodeFin\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use CodeFin\Http\Requests\BillReceiveCreateRequest;
use CodeFin\Http\Requests\BillReceiveUpdateRequest;
use CodeFin\Repositories\BillReceiveRepository;
use CodeFin\Validators\BillReceiveValidator;


class BillReceivesController extends Controller
{

    /**
     * @var BillReceiveRepository
     */
    protected $repository;

    /**
     * @var BillReceiveValidator
     */
    protected $validator;

    public function __construct(BillReceiveRepository $repository, BillReceiveValidator $validator)
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
        $billReceives = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $billReceives,
            ]);
        }

        return view('billReceives.index', compact('billReceives'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BillReceiveCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(BillReceiveCreateRequest $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $billReceive = $this->repository->create($request->all());

            $response = [
                'message' => 'BillReceive created.',
                'data'    => $billReceive->toArray(),
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
        $billReceive = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $billReceive,
            ]);
        }

        return view('billReceives.show', compact('billReceive'));
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

        $billReceive = $this->repository->find($id);

        return view('billReceives.edit', compact('billReceive'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  BillReceiveUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(BillReceiveUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $billReceive = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'BillReceive updated.',
                'data'    => $billReceive->toArray(),
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
                'message' => 'BillReceive deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'BillReceive deleted.');
    }
}
