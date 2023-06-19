<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCazaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('caza')) {
            Schema::create('caza', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('gouvernate_id');
                $table->string('name',50)->nullable();
                $table->string('arabic',50)->nullable();
                $table->timestamps();
            });
        }else{
            Schema::table('caza',function(Blueprint $table){
                $table->string('arabic',50)->nullable();
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
        Schema::dropIfExists('caza');
    }
}
