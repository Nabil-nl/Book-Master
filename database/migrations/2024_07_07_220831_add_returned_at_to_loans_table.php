<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReturnedAtToLoansTable extends Migration
{
    public function up()
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->timestamp('returned_at')->nullable()->after('due_at');
        });
    }

    public function down()
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropColumn('returned_at');
        });
    }
}
