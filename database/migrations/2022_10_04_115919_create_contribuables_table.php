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
        Schema::create('contribuables', function (Blueprint $table) {
            $table->id();
            $table->string('nif')->unique();
            $table->string('raison_sociale')->nullable();
            $table->integer('s_matrim')->nullable()->default(0)
                ->comment('0: Célibataire; 1: Mariée, 2:Divorcé; 3:Veuf');
            $table->string('activite');
            $table->integer('type_contr')->nullable()->default(0)
                ->comment('0: Personne physique; 1: Personne morale');
            $table->json('localisation')->default(json_encode(['x', 'y']));
            $table->timestamps();

            $table->foreignId('user_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contribuables');
    }
};
