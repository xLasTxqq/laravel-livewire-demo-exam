<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() 
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->smallInteger('age');
            $table->string('image');
            $table->double('price');
            $table->foreignId('genres_id')->constrained('genres','id')->cascadeOnDelete();
            $table->timestamp('show_date');
            $table->integer('amount');
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
        Schema::dropIfExists('sessions');
    }
};
