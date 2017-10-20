<?php

namespace CodeFin\Transformers;

use League\Fractal\TransformerAbstract;
use CodeFin\Models\BankAccount;

/**
 * Class BankAccountTransformer
 * @package namespace CodeFin\Transformers;
 */
class BankAccountTransformer extends TransformerAbstract
{

    /**
     * Transform the \BankAccount entity
     * @param \BankAccount $model
     *
     * @return array
     */
    public function transform(BankAccount $model)
    {
        return [
            'id'         => (int) $model->id,
            'name'       => $model->name,
            'agency'     => $model->agency,
            'account'    => $model->account,
            'bank_id'    => (int)$model->bank_id,
            'default'    => (bool)$model->default,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
