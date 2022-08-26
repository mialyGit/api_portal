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
            $table->json('cin_upload')->nullable();
            $table->string('telephone',20)->nullable();
            $table->string('password');
            $table->string('photo')->nullable();
            $table->string('adresse');
            $table->integer('status');
            $table->boolean('online');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreignId('type_user_id')->nullable()->constrained();
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
