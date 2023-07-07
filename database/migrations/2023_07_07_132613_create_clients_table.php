<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 40)->nullable();
            $table->string('email', 50)->nullable()->unique();
            $table->date('date_birth')->nullable();
            $table->string('address', 100)->nullable();
            $table->string('complement', 100)->null();
            $table->string('neighborhood', 40)->nullable();
            $table->string('cep', 10)->null();
            $table->date('date_entry')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
