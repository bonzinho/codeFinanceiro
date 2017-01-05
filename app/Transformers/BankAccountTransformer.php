<?php

namespace codeFin\Transformers;

use League\Fractal\TransformerAbstract;
use codeFin\Models\BankAccount;

/**
 * Class BankAccountTransformer
 * @package namespace codeFin\Transformers;
 */
class BankAccountTransformer extends TransformerAbstract
{
    //protected $defaultIncludes = ['bank'];  // é bank que vem do sufixo da função includeBank (BANK) //COM ESTE O BANK E SEMPRE INCLUIDO NA REQUESIÇÃO
    protected $availableIncludes = ['bank']; // com este apenas é deveovida a pesquisa principal para adicionar os includes é necessario adicionar ?include=bank,outroinclude,ououtroinclude
    /**
     * Transform the \BankAccount entity
     * @param \BankAccount $model
     *
     * @return array
     */
    public function transform(BankAccount $model)
    {
        return [
            'id'        => (int) $model->id,
            'name'      => $model->name,
            'agency'    => $model->agency,
            'account'   => $model->account,
            'default'   => (bool)$model->default,
            'bank_id'   => (int)$model->bank_id,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }

    public function includeBank(BankAccount $model){
        return $this->item($model->bank, new BankTransformer());
    }
}
