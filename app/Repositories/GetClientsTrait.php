<?php

namespace CodeFin\Repositories;

trait GetClientsTrait{
    private function getClients(){
        $repository = app(\CodeFin\Repositories\ClientRepository::class);
        $repository->skipPresenter();
        return $repository->all();
    }
}