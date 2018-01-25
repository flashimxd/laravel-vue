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
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
