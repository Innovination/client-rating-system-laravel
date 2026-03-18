<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleAndStatusToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('agency')->after('user_type');
                $table->index('role', 'users_role_idx');
            }

            if (!Schema::hasColumn('users', 'status')) {
                $table->string('status')->default('active')->after('role');
                $table->index('status', 'users_status_idx');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'status')) {
                $table->dropIndex('users_status_idx');
                $table->dropColumn('status');
            }

            if (Schema::hasColumn('users', 'role')) {
                $table->dropIndex('users_role_idx');
                $table->dropColumn('role');
            }
        });
    }
}
