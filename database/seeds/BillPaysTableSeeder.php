<?php

use Illuminate\Database\Seeder;
use CodeFin\Repositories\BillPayRepository;

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
        $repository = app(BillPayRepository::class);

        factory(\CodeFin\Models\BillPay::class, 200)
            ->make()
            ->each(function($billpay) use($clients, $repository){
                $client = $clients->random();
                \Landlord::addTenant($client);
                $bankAccount = $client->bankAccounts->random();
                $category = $client->categoryExpenses->random();
                $billpay->client_id = $client->id;
                $billpay->bank_account_id = $bankAccount->id;
                $billpay->category_id = $category->id;
                $data = $billpay->toArray();
                $repository->create($data);
            });
    }
}
