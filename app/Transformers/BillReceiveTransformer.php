<?php

namespace CodeFin\Transformers;

use League\Fractal\TransformerAbstract;
use CodeFin\Models\BillReceive;

/**
 * Class BillReceiveTransformer
 * @package namespace CodeFin\Transformers;
 */
class BillReceiveTransformer extends TransformerAbstract
{

    /**
     * Transform the \BillReceive entity
     * @param \BillReceive $model
     *
     * @return array
     */
    public function transform(BillReceive $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
