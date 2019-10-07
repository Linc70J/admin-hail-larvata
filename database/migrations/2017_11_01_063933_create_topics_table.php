<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTopicsTable extends Migration
{
    public function up()
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('bu_id')->unsigned()->default(0)->index();
            $table->string('title')->nullable()->default('')->index();
            $table->text('body')->nullable();
            $table->bigInteger('user_id')->unsigned()->default(0)->index();
            $table->integer('topic_category_id')->unsigned()->default(0)->index();
            $table->integer('reply_count')->unsigned()->default(0);
            $table->integer('view_count')->unsigned()->default(0);
            $table->integer('last_reply_user_id')->unsigned()->default(0);
            $table->text('excerpt')->nullable();
            $table->string('slug')->nullable();
            $table->boolean('draft')->default(0);
            $table->boolean('display')->default(0);
            $table->boolean('top')->default(0);
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->integer('order')->unsigned()->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('topics');
    }
}
