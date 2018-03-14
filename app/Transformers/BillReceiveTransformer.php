<?php

namespace CodeFin\Transformers;

use League\Fractal\TransformerAbstract;
use CodeFin\Models\BillReceive;

/**
 * Class BillPayTransformer
 * @package namespace CodeFin\Transformers;
 */
class BillReceiveTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['category', 'bankAccount'];

    /**
     * Transform the \BillReceivePresenter entity
     * @param \BillReceivePresenter $model
     *
     * @return array
     */
    public function transform(BillReceive $model)
    {
        return [
            'id'         => (int) $model->id,
            'date_due'   => $model->date_due,
            'name'       => $model->name,
            'value'      => $model->value,
            'done'       => $model->done,
            'client_id'  => $model->client_id,
            'category_id'=> (int)$model->category_id,
            'bank_account_id'=> (int)$model->bank_account_id,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }

    public function includeCategory(BillReceive $model)
    {
        if(!$model->category){
            return null;
        }
        //var_dump($model->category); exit;
        $transform = new CategoryTransformer();
        $transform->setDefaultIncludes([]);
        return $this->item($model->category, $transform);
    }

    public function includeBankAccount(BillReceive $model)
    {
        return $this->item($model->bankAccount, new BankAccountTransformer());
    }
}
