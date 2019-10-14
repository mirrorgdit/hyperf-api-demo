<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;
use Hyperf\DbConnection\Db;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            // 指定表存储引擎
            $table->engine = 'InnoDB';
            // 指定数据表的默认字符集
            $table->charset = 'utf8';
            // 指定数据表默认的排序规则
            $table->collation = 'utf8_unicode_ci';

            $table->bigIncrements('id')->comment('主键ID');
            $table->uuid('uuid')->default('')->comment('uuid');
            $table->string('username', 20)->nullable()->default('')->comment('帐号');
            $table->string('password_hash', 150)->nullable()->default('')->comment('密码');
            $table->string('nickname', 50)->nullable()->default('')->comment('昵称');
            $table->string('realname', 50)->nullable()->default('')->comment('真实姓名');
            $table->string('head_portrait', 150)->nullable()->default('')->comment('头像');
            $table->unsignedTinyInteger('gender')->nullable()->default('0')->comment('性别[0:未知;1:男;2:女]');
            $table->string('qq', 20)->nullable()->default('')->comment('qq');
            $table->string('email', 60)->nullable()->default('')->comment('邮箱');
            $table->date('birthday')->nullable()->default(NULL)->comment('生日');
            $table->string('mobile', 20)->nullable()->default('')->comment('邮箱');
            $table->integer('last_time')->nullable()->default('0')->comment('最后一次登录时间');
            $table->ipAddress('last_ip')->nullable()->default('')->comment('最后一次登录ip');
            $table->integer('province_id')->nullable()->default('0')->comment('省');
            $table->integer('city_id')->nullable()->default('0')->comment('城市');
            $table->integer('area_id')->nullable()->default('0')->comment('地区');
            $table->tinyInteger('status')->nullable()->default('1')->comment('状态[-1:删除;0:禁用;1启用]');
            $table->unsignedInteger('created_at')->nullable()->default('0')->comment('创建时间');
            $table->unsignedInteger('updated_at')->nullable()->default('0')->comment('修改时间');
            //索引
            $table->index('username');
            $table->index('mobile');
            $table->index('uuid');
        });
        DB::statement("ALTER TABLE tb_users COMMENT='用户表'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
}
