<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('collectors')) {
            //
            Schema::create('collectors', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('user_id');
                $table->bigInteger('partner_id');
                $table->string('name')->nullable();
                $table->string('city')->nullable();
                $table->boolean('is_subpartner')->nullable();
                $table->string('sub_partner',50)->nullable();
                $table->timestamps();
            });
        }else{
            Schema::table('collectors', function(Blueprint $table){
                //$table->dropColumn('sub_partner');
                $table->string('sub_partner',50)->nullable();
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
        Schema::dropIfExists('collectors');
    }
}
