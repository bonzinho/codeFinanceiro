<?php

namespace codeFin\Transformers;

use League\Fractal\TransformerAbstract;
use codeFin\Models\Bank;

/**
 * Class BankTransformer
 * @package namespace codeFin\Transformers;
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
            'logo'       => $this->makeLogoPath($model),
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }

    // serve para motar o link de acesso ao imagem para esta ser retornada
    public function makeLogoPath(Bank $model){
        $url = url('/'); //localhost:3000
        $folder = Bank::logosDir();
        return "$url/storage/$folder/{$model->logo}";
    }
}
