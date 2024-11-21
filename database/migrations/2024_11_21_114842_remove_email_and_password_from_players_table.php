<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('players', function (Blueprint $table) {
            $table->dropColumn('email');
            $table->dropColumn('password');
        });
    }
    
    public function down()
    {
        Schema::table('players', function (Blueprint $table) {
            $table->string('email')->unique();
            $table->string('password');
        });
    }
    
};
