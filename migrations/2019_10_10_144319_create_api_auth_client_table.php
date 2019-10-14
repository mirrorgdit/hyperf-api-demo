<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;
use Hyperf\DbConnection\Db;

class CreateApiAuthClientTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('api_auth_client', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('app_id', 20)->nullable()->default('')->comment('帐号');
            $table->string('app_secret', 150)->nullable()->default('')->comment('密码');
            $table->tinyInteger('status')->nullable()->default('1')->comment('状态[-1:删除;0:禁用;1启用]');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE tb_api_auth_client COMMENT='api-授权表'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_auth_client');
    }
}
