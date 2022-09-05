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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('code_app', 20);
            $table->string('nom_app', 100);
            $table->string('abrev_app', 100)->nullable();
            $table->text('desc_app')->nullable();
            $table->text('lien_app')->default('http://www.impots.mg/');
            $table->tinyInteger('type_app')->default(0)->nullable()
                  ->comment('0: application par défaut; 1: application de l\'utilisateur');
            $table->string('logo_app');
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
        /*Schema::table('user_privilege_apps', function (Blueprint $table) {
            $table->dropForeign('user_privilege_apps_application_id_foreign');
            $table->dropColumn('application_id');
        });*/

        Schema::dropIfExists('applications');

    }
};
