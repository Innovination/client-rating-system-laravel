<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisputesTable extends Migration
{
    public function up()
    {
        Schema::create('disputes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('agency_user_id')->nullable();
            $table->unsignedBigInteger('dispute_category_id')->nullable();
            $table->string('project_type');
            $table->string('dispute_type');
            $table->text('issue_description');
            $table->text('supporting_notes')->nullable();
            $table->string('status')->default('visible');
            $table->unsignedBigInteger('moderated_by')->nullable();
            $table->timestamp('moderated_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('client_id', 'disputes_client_fk')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('agency_user_id', 'disputes_agency_user_fk')->references('id')->on('users')->nullOnDelete();
            $table->foreign('dispute_category_id', 'disputes_category_fk')->references('id')->on('dispute_categories')->nullOnDelete();
            $table->foreign('moderated_by', 'disputes_moderated_by_fk')->references('id')->on('users')->nullOnDelete();

            $table->index(['client_id', 'status', 'created_at'], 'disputes_client_status_created_idx');
        });
    }

    public function down()
    {
        Schema::dropIfExists('disputes');
    }
}
