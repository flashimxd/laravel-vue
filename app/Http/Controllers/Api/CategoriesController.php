<?php

namespace CodeFin\Http\Controllers\Api;

use CodeFin\Criteria\FindRootCategoriesCriteria;
use CodeFin\Http\Controllers\Controller;
use CodeFin\Http\Controllers\Response;
use CodeFin\Repositories\CategoryRepository;
use CodeFin\Http\Requests\CategoryRequest;


class CategoriesController extends Controller
{

    /**
     * @var CategoryRepository
     */
    protected $repository;


    public function __construct(CategoryRepository $repository)
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
        $this->repository->pushCriteria(new FindRootCategoriesCriteria());
        $categories = $this->repository->all();
        return  $categories;
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
        $categories = $this->repository->create($request->all());
        return response()->json($categories, 201);
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
        $categories = $this->repository->find($id);
        return response()->json($categories);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  CategoryRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(CategoryRequest $request, $id)
    {
        $categories = $this->repository->update($request->all(), $id);
        return response()->json($categories);
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
