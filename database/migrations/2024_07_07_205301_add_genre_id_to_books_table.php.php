<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGenreIdToBooksTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Check if the column exists before adding it
        if (!Schema::hasColumn('books', 'genre_id')) {
            Schema::table('books', function (Blueprint $table) {
                $table->unsignedBigInteger('genre_id')->default(1);
                $table->foreign('genre_id')->references('id')->on('genres')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropForeign(['genre_id']);
            $table->dropColumn('genre_id');
        });
    }
}
