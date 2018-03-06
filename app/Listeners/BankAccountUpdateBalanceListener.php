<?php

namespace CodeFin\Listeners;

use CodeFin\Repositories\BankAccountRepository;
use CodeFin\Repositories\StatementRepository;
use CodeFin\Events\BillStoredEvent;
use CodeFin\Models\BillPay;
use Prettus\Repository\Events\RepositoryEventBase;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class BankAccountUpdateBalanceListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    private $bankAccountRepository;

    private $statementRepository;

    public function __construct(BankAccountRepository $bankAccountRepository, StatementRepository $statementRepository)
    {
        $this->bankAccountRepository = $bankAccountRepository;
        $this->bankAccountRepository->skipPresenter(true);
        $this->statementRepository = $statementRepository;
    }

    /**
     * Handle the event.
     *
     * @param  RepositoryEventBase  $event
     * @return void
     */
    public function handle(BillStoredEvent $event)
    {
        $model = $event->getModel();
        $bankAccountId = $model->bank_account_id;
        $value = $this->getValue($event);
        //dd($value);
        if($value){
            $bankAccount = $this->bankAccountRepository->addBalance($bankAccountId, $value);
            $this->statementRepository->create([
                'statementable' => $model,
                'value' => $value,
                'balance' => $bankAccount->balance,
                'bank_account_id' => $bankAccount->id
            ]);
        }

    }

    protected function getValue(BillStoredEvent $event)
    {
        $model = $event->getModel();
        $modelOld = $event->getModelOld();
        $value = $model->value;
        $valueOld = $modelOld ? $modelOld->value: $model->value;
        $doneOld  = $modelOld ? $modelOld->done: false;

        //account value changed
        if($value != $valueOld){
            //the account still payed
            if($model->done == $modelOld->done && $model->done){
                return $model instanceof BillPay ? $valueOld - $value : $value - $valueOld;
            }
        }
        
        if($model->done != $doneOld){
            if($model->done){
                return $model instanceof BillPay ? -$value : $value;
            }else{
                return $model instanceof BillPay ? $valueOld : -$valueOld;
            }
        }

        return 0;
    }
}