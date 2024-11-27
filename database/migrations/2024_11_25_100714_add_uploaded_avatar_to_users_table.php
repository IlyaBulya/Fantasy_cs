<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUploadedAvatarToUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
        {
            Schema::table('users', function (Blueprint $table) {
                $table->string('uploaded_avatar')->nullable()->after('avatar');
            });
        }

        public function down()
        {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('uploaded_avatar');
            });
        }

}