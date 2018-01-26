<?php

use Illuminate\Database\Seeder;

class BillPaysTableSeeder extends Seeder
{
    use \CodeFin\Repositories\GetClientsTrait;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clients = $this->getClients();

        factory(\CodeFin\Models\BillPay::class, 200)
            ->make()
            ->each(function($billpay) use($clients){
                $client = $clients->random();
                $bankAccount = $client->bankAccounts->random();
                $category = $client->categoryExpenses->random();
                $billpay->client_id = $client->id;
                $billpay->bank_account_id = $bankAccount->id;
                $billpay->category_id = $category->id;
                $billpay->save();
            });
    }
}
