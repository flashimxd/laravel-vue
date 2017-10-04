<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBanksData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $repository = app(\CodeFin\Repositories\BankRepository::class);
        foreach ($this->getData() as $bankData){
            $repository->create($bankData);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }

    public function getData(){
        return [
            ['name' => 'Caixa', 'logo' => new \Illuminate\Http\UploadedFile(storage_path('app/files/banks/logos/caixa.png'), 'caixa.png')],
            ['name' => 'Banco do Brasil', 'logo' => new \Illuminate\Http\UploadedFile(storage_path('app/files/banks/logos/bb.jpg'), 'bb.jpg')],
            ['name' => 'Bradesco', 'logo' => new \Illuminate\Http\UploadedFile(storage_path('app/files/banks/logos/bradesco.png'), 'bradesco.png')],
            ['name' => 'Itaú', 'logo' => new \Illuminate\Http\UploadedFile(storage_path('app/files/banks/logos/itau.png'), 'itau.png')],
            ['name' => 'Santander', 'logo' => new \Illuminate\Http\UploadedFile(storage_path('app/files/banks/logos/santander.gif'), 'santander.gif')],
        ];
    }
}
