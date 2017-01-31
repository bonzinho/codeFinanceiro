<?php
namespace codeFin\Repositories;

trait GetClientsTrait{

    private function getClients(){
        /** @var \codeFin\Repositories\ClientRepository $repository */
        $repository = app(\codeFin\Repositories\ClientRepository::class);
        $repository->skipPresenter(true);
        return $repository->all();
    }

}