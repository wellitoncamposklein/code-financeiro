<?php

namespace CodeFin\Repositories;

use CodeFin\Models\BillPay;
use CodeFin\Presenters\BillPayPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class BankRepositoryEloquent.
 *
 * @package namespace CodeFin\Repositories;
 */
class BillPayRepositoryEloquent extends BaseRepository implements BillPayRepository
{
    use BillRepositoryTrait;

    protected $fieldSearchable = [
        'name' => 'like'
    ];

    public function create(array $attributes)
    {
        $model = parent::create($attributes);
        $this->repeatBill($attributes);
        return $model;
    }
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
