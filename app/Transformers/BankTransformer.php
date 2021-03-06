<?php

namespace CodeFin\Transformers;

use Illuminate\Http\Request;
use League\Fractal\TransformerAbstract;
use CodeFin\Models\Bank;

/**
 * Class BankTransformer
 * @package namespace CodeFin\Transformers;
 */
class BankTransformer extends TransformerAbstract
{

    /**
     * Transform the \Bank entity
     * @param \Bank $model
     *
     * @return array
     */
    public function transform(Bank $model)
    {
        return [
            'id'         => (int) $model->id,
            'name'       => $model->name,
            'logo'       => $this->getLogoPath($model),
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }

    public function getLogoPath($model)
    {
        $url = url('/');
        $folder = Bank::logosDir();
        return "$url/storage/$folder/{$model->logo}";
    }
}
