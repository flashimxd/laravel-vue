<?php

namespace CodeFin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeFin\Repositories\BillReceiveRepository;
use CodeFin\Models\BillReceive;
use CodeFin\Presenters\BillReceivePresenter;

/**
 * Class BillReceiveRepositoryEloquent
 * @package namespace CodeFin\Repositories;
 */
class BillReceiveRepositoryEloquent extends BaseRepository implements BillReceiveRepository
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
        return BillReceive::class;
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
        return BillReceivePresenter::class;
    }
}
