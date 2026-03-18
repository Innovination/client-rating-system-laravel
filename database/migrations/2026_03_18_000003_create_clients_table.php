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
            $table->string('name');
            $table->string('website')->nullable();
            $table->string('location')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by', 'clients_created_by_fk')->references('id')->on('users')->nullOnDelete();
            $table->index('name', 'clients_name_idx');
        });
    }

    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
