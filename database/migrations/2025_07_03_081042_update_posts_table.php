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
        $table->dropColumn(['image', 'link', 'content', 'technologies']);
        $table->string('author_name')->after('user_id');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('posts', function (Blueprint $table) {
        $table->text('content')->nullable();
        $table->string('image')->nullable();
        $table->string('link')->nullable();
        $table->string('technologies')->nullable();
        $table->dropColumn('author_name');
    });
}
};
