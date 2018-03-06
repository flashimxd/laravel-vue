<?php
namespace CodeFin\Events;

class BillStoredEvent
{
    private $model;
    private $modelOld;

    /**
     * Create a new event instance.
     *
     * @param model
     * @param modelOld
     * @return void
     */
    public function __construct($model, $modelOld = null)
    {
        $this->model = $model;
        $this->modelOld = $modelOld;
    }

    /**
     * @return Model
     */
    public function getModel(){
        return $this->model;
    }

    /**
     * @return ModelOld
     */
    public function getModelOld(){
        return $this->modelOld;
    }
}
