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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('code_sc', 10)->nullable()->unique();
            $table->string('nom_sc', 100);
            $table->string('abrev_sc', 100)->nullable();
            $table->string('cur_bur_sc', 20)->nullable();
            $table->string('lieu_bur_sc', 100)->nullable();
            $table->string('adresse_sc')->nullable();
            $table->string('mail_sc')->nullable();
            $table->string('tel_sc', 20)->nullable();
            $table->string('tel_2_sc', 20)->nullable();
            $table->timestamps();

            $table->foreignId('direction_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
};
