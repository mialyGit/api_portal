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
            $table->json('cin')->nullable();
            $table->string('telephone')->nullable();
            $table->string('password')->nullable();
            $table->string('photo')->nullable();
            $table->string('adresse')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreignId('type_user_id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_privilege_apps', function (Blueprint $table) {
            $table->dropForeign('user_privilege_apps_user_id_foreign');
            $table->dropColumn('user_id');
        });
        
        Schema::dropIfExists('users');
    }
};
