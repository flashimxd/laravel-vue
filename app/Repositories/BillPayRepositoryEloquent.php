<?php

namespace CodeFin\Repositories;

use CodeFin\Presenters\BillPayPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeFin\Repositories\BillPayRepository;
use CodeFin\Models\BillPay;

/**
 * Class BillPayRepositoryEloquent
 * @package namespace CodeFin\Repositories;
 */
class BillPayRepositoryEloquent extends BaseRepository implements BillPayRepository
{
    use BillRepositoryTrait;

    protected $fieldSearchable = ['name' => 'like'];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return BillPay::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function presenter()
    {
        return BillPayPresenter::class;
    }
}
