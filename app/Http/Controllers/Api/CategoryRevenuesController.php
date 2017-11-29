<?php

namespace CodeFin\Http\Controllers\Api;

use CodeFin\Criteria\WithDepthCategoriesCriteria;
use CodeFin\Repositories\CategoryRevenueRepository;
use CodeFin\Http\Controllers\Controller;

class CategoryRevenuesController extends Controller
{
    use CategoriesControllerTrait;
    protected $repository;

    public function __construct(CategoryRevenueRepository $repository)
    {
        $this->repository = $repository;
        $this->repository->pushCriteria(new WithDepthCategoriesCriteria());
    }
}
