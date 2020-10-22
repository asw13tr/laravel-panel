<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableNavigations extends Migration{

    public function up(){
        Schema::create('navigations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug')->nullable();
            $table->enum('type', ['menu', 'item'])->default('item');
            $table->integer('parent')->default('0');
            $table->string('url')->nullable();
            $table->boolean('target')->default(false);
            $table->string('css')->nullable();
            $table->integer('menu_order')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('navigations');
    }
}
