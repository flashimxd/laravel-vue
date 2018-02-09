<?php

namespace CodeFin\Http\Controllers\Api;

use CodeFin\Http\Controllers\Controller;
use CodeFin\Repositories\BillPayRepository;
use Illuminate\Http\Request;

use CodeFin\Http\Requests;
use CodeFin\Http\Requests\BillPayRequest;
use CodeFin\Criteria\FindBetweenDateBrCriteria;
use CodeFin\Criteria\FindByValueBrCriteria;

class BillPaysController extends Controller
{
    /**
     * @var BillPayRepository
     */
    protected $repository;


    public function __construct(BillPayRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchParam = config('repository.criteria.params.search');
        $search = $request->get($searchParam);
        $this->repository->pushCriteria(new FindBetweenDateBrCriteria($search))->pushCriteria(new FindByValueBrCriteria($search));
        return $this->repository->paginate(3);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BillPayRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(BillPayRequest $request)
    {
        $billPay = $this->repository->create($request->all());
        return response()->json($billPay, 201);
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
        $billPay = $this->repository->find($id);
        return response()->json($billPay);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  $billPay $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(BillPayRequest $request, $id)
    {
        $billPay = $this->repository->update($request->all(), $id);
        return response()->json($billPay);
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
        return response()->json([], 204);
    }
}
