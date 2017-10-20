<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Storage;

class CreateBankDefaultLogo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $destFile = \CodeFin\Models\Bank::logosDir();
        $name = env('BANK_LOGO_DEFAULT');
        $logo = new \Illuminate\Http\UploadedFile(storage_path('app/files/banks/logos/no_thumb.jpg'), 'no_thumb.jpg');

        Storage::disk('public')->putFileAs($destFile, $logo, $name);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $name = env('BANK_LOGO_DEFAULT');
        $path = \CodeFin\Models\Bank::logosDir().'/'.$name;
        Storage::disk('public')->delete($path);
    }
}
