<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_logs', function (Blueprint $table) {
            $table->increments('id');

            $table->string('username', 190)->default('')->comment('用户名(NetId)');
            $table->string('permission', 50)->default('')->comment('权限名');
            $table->string('method')->comment('HTTP方法');
            $table->string('path')->comment('路径');
            $table->string('ip', 15)->comment('IP');
            $table->text('query')->comment('Query string');
            $table->text('body')->comment('POST body');
            $table->text('response')->comment('返回的json');
            $table->timestamps();

            $table->index('username');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('api_logs');
    }
}
