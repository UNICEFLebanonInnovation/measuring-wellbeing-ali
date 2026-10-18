<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('users')) {
            //
            Schema::create('users', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('firstname')->nullable();
                $table->string('lastname')->nullable();
                $table->string('email')->unique()->nullable();
                $table->string('phone')->nullable();
                $table->string('zone')->nullable();
                $table->text('address')->nullable();
                $table->string('fax')->nullable();
                $table->enum('is_active', [0,1])->nullable();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password')->nullable();
                $table->rememberToken();
                $table->timestamps();
            });
        }else{
            Schema::table('users', function($table){
                 $table->string('api_token', 80)->after('password')
                        ->unique()
                        ->nullable()
                        ->default(null);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
