<?php

namespace CodeFin\Http\Controllers\Api;

use CodeFin\Repositories\CategoryExpenseRepository;
use CodeFin\Criteria\WithDepthCategoriesCriteria;
use CodeFin\Http\Controllers\Controller;

class CategoryExpensesController extends Controller
{
    use CategoriesControllerTrait;

    protected $repository;

    public function __construct(CategoryExpenseRepository $repository)
    {
        $this->repository = $repository;
        $this->repository->pushCriteria(new WithDepthCategoriesCriteria());
    }
}
