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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();            
            $table->foreignId('user_id')->constrained()->onDelete('cascade');            
            $table->foreignId('technology')->constrained()->onDelete('cascade');            
            $table->string('title');
            $table->text('body');
            $table->boolean('isFeatured')->default(false);
            $table->boolean('isActive')->default(true);
            $table->boolean('isSolved')->default(false);
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
        Schema::dropIfExists('questions');
    }
};
