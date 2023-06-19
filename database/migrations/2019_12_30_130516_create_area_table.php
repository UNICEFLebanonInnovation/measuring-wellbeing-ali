<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('area')) {
            Schema::create('area', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('caza_id');
                $table->bigInteger('gouvernate_id');
                $table->string('name',50)->nullable();
                $table->string('arabic',50)->nullable();
                $table->timestamps();
            });
        }else{
            Schema::table('area',function(Blueprint $table){
                $table->bigInteger('gouvernate_id');
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
        Schema::dropIfExists('area');
    }
}
