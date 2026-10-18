<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGouvernateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('gouvernate')) {
            Schema::create('gouvernate', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name',50)->nullable();
                $table->string('arabic',50)->nullable();
                $table->timestamps();
            });
        }else{
            Schema::table('gouvernate',function(Blueprint $table){
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
        Schema::dropIfExists('gouvernate');
    }
}
