<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('partners')) {
            //
            Schema::create('partners', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('user_id');
                $table->string('name')->nullable();
                $table->string('prefix')->nullable();
                $table->string('logo')->nullable();
                $table->bigInteger('max_app_per_year')->nullable();
                $table->timestamps();
            });
        }else{
            Schema::table('partners', function(Blueprint $table){
                $table->string('prefix')->nullable();
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
        Schema::dropIfExists('partners');
    }
}
