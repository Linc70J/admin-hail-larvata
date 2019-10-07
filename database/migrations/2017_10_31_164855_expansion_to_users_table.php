<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ExpansionToUsersTable extends Migration
{
    /**
     * 执行迁移
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('enabled')->default(1);
            $table->boolean('email_notification')->default(0);
            $table->string('introduction')->nullable();
            $table->string('contact_phone')->nullable();
        });
    }

    /**
     * 回滚迁移
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('enabled');
            $table->dropColumn('email_notification');
            $table->dropColumn('introduction');
            $table->dropColumn('contact_phone');
        });
    }
}
