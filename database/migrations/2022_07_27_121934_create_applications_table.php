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
            $table->string('code_app');
            $table->string('nom_app');
            $table->string('abrev_app')->nullable();
            $table->text('desc_app')->nullable();
            $table->text('lien_app');
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
        Schema::table('user_privilege_apps', function (Blueprint $table) {
            $table->dropForeign('user_privilege_apps_application_id_foreign');
            $table->dropColumn('application_id');
        });

        Schema::dropIfExists('applications');

    }
};
