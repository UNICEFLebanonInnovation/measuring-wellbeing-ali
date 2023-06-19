<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('application')) {
            Schema::create('application', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('code',50)->nullable();
                $table->timestamp('pre_test_date')->nullable();
                $table->timestamp('post_test_date')->nullable();
                $table->bigInteger('partner_id')->nullable();
                $table->bigInteger('collector_id')->nullable();
                $table->string('language',50)->nullable();
                $table->bigInteger('status')->nullable();
                $table->timestamps();
            });
        }else{
            Schema::table('application',function(Blueprint $table){
                $table->string('language',50)->nullable();
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
        Schema::dropIfExists('application');
    }
}
