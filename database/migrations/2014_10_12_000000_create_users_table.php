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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom')->nullable();
            $table->string('email')->unique();
            $table->json('cin')->default(json_encode([
                'numero', 'date_delivrance', 'date_naissance', 'lieu_naissance', 'date_duplicata',
                'lieu_duplicata', 'pere', 'mere'
            ]));
            $table->string('cin_upload')->nullable();
            $table->string('telephone',20)->nullable();
            $table->integer('sexe')->nullable()->default(0)
                ->comment('0: Non précisé; 1: Masculin, 2:Féminin');
            $table->string('password');
            $table->string('photo')->nullable();
            $table->string('adresse');
            $table->integer('type_user_id')->default(0)
                  ->comment('0: Utilisateur; 1: Administrateur');
            $table->integer('status')->default(0)
                  ->comment('0: non validé; 1: validé');
            $table->boolean('online')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();

            // $table->foreignId('type_user_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*Schema::table('user_privilege_apps', function (Blueprint $table) {
            $table->dropForeign('user_privilege_apps_user_id_foreign');
            $table->dropColumn('user_id');
        });*/
        
        Schema::dropIfExists('users');
    }
};
