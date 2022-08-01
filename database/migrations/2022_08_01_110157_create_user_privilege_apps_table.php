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
        Schema::create('user_privilege_apps', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('application_id')->constrained()->cascadeOnDelete();
            $table->foreignId('privilege_id')->constrained()->cascadeOnDelete();
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
        
        Schema::table('user_privilege_apps', function (Blueprint $table) {
            $table->dropForeign('user_privilege_apps_privilege_id_foreign');
            $table->dropColumn('privilege_id');
        });

        Schema::table('user_privilege_apps', function (Blueprint $table) {
            $table->dropForeign('user_privilege_apps_application_id_foreign');
            $table->dropColumn('application_id');
        });

        Schema::dropIfExists('user_privilege_apps');
    }
};
