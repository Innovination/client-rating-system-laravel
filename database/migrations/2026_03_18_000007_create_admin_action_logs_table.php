<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminActionLogsTable extends Migration
{
    public function up()
    {
        Schema::create('admin_action_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('admin_user_id')->nullable();
            $table->string('action_type');
            $table->string('target_type')->nullable();
            $table->unsignedBigInteger('target_id')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->foreign('admin_user_id', 'admin_action_logs_admin_user_fk')->references('id')->on('users')->nullOnDelete();
            $table->index(['target_type', 'target_id'], 'admin_action_logs_target_idx');
        });
    }

    public function down()
    {
        Schema::dropIfExists('admin_action_logs');
    }
}
