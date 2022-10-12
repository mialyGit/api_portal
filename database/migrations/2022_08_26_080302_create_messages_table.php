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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sender_id');
            $table->bigInteger('rec_id');
            $table->text('content');
            $table->boolean('status')->default(false)
                ->comment('true: Déjà vue; false: Pas encore vue');
            $table->timestamps();
            
            $table->foreign('sender_id')->nullable()->references('id')->on('users');
            $table->foreign('rec_id')->nullable()->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
};
