<?php

namespace codeFin\Listeners;

use codeFin\Repositories\BankAccountRepository;
use Prettus\Repository\Events\RepositoryEventBase;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class BankAccountSetDefaultListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(BankAccountRepository $repository)
    {
        $this->repository = $repository;
        $this->repository->skipPresenter(true);
    }

    /**
     * Handle the event.
     *
     * @param  RepositoryEventBase  $event
     * @return void
     */
    public function handle(RepositoryEventBase $event)
    {

        $model = $event->getModel();
        if(!$model->default){ // se não for default retorna valor vazio
            return;
        }

        $collection = $this->repository
            ->findByField('default', true) // retorna a colação de default = true
            ->filter(function($value, $key) use($model){  // este filtro faz uma sub coleção da coleção pedida com o findByField
            return $model->id != $value->id; // aqui só pega a conta bancaria que nao esta
        });

        $bankAccountDefault = $collection->first();
        if($bankAccountDefault){
            $this->repository->update(['default' => false], $bankAccountDefault->id);
        }
    }
}
