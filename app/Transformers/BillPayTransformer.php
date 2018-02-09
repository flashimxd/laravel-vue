<?php

namespace CodeFin\Transformers;

use League\Fractal\TransformerAbstract;
use CodeFin\Models\BillPay;

/**
 * Class BillPayTransformer
 * @package namespace CodeFin\Transformers;
 */
class BillPayTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['category', 'bankAccount'];

    /**
     * Transform the \BillPayPresenter entity
     * @param \BillPayPresenter $model
     *
     * @return array
     */
    public function transform(BillPay $model)
    {
        return [
            'id'         => (int) $model->id,
            'date_due'   => $model->date_due,
            'name'       => $model->name,
            'value'      => (float)$model->value,
            'done'       => (boolean)$model->done,
            'client_id'  => $model->client_id,
            'category_id'=> (int)$model->category_id,
            'bank_account_id'=> (int)$model->bank_account_id,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }

    public function includeCategory(BillPay $model)
    {
        $transform = new CategoryTransformer();
        $transform->setDefaultIncludes([]);
        return $this->item($model->category, $transform);
    }

    public function includeBankAccount(BillPay $model)
    {
        return $this->item($model->bankAccount, new BankAccountTransformer());
    }
}
