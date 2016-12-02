<?php

use codeFin\Models\Bank;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankLogoDefault extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        $logo = new \Illuminate\Http\UploadedFile(storage_path('app/files/banks/logos/default.jpg'), 'default.jpg');
        $name = env('BANK_LOGO_DEFAULT');
        $destFile = Bank::logosDir();
        \Storage::disk('public')->putFileAs($destFile, $logo, $name);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
    }

}
