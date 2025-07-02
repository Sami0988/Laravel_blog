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
    Schema::table('posts', function (Blueprint $table) {
        $table->text('description')->nullable();
        $table->string('image')->nullable();
        $table->string('link')->nullable();
        $table->json('technologies')->nullable(); 
    });
}




    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('posts', function (Blueprint $table) {
        $table->dropColumn(['description', 'image', 'link', 'technologies']);
    });
}
};
