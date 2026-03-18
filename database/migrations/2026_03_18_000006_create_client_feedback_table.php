<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientFeedbackTable extends Migration
{
    public function up()
    {
        Schema::create('client_feedback', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('agency_user_id')->nullable();
            $table->tinyInteger('rating');
            $table->text('feedback_text')->nullable();
            $table->string('status')->default('visible');
            $table->unsignedBigInteger('moderated_by')->nullable();
            $table->timestamp('moderated_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('client_id', 'client_feedback_client_fk')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('agency_user_id', 'client_feedback_agency_user_fk')->references('id')->on('users')->nullOnDelete();
            $table->foreign('moderated_by', 'client_feedback_moderated_by_fk')->references('id')->on('users')->nullOnDelete();

            $table->index(['client_id', 'status', 'created_at'], 'client_feedback_client_status_created_idx');
            $table->unique(['client_id', 'agency_user_id'], 'client_feedback_client_agency_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('client_feedback');
    }
}
