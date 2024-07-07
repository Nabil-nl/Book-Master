<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReturnedAtAndFineAmountToLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loans', function (Blueprint $table) {
            if (!Schema::hasColumn('loans', 'returned_at')) {
                $table->timestamp('returned_at')->nullable();
            }
            if (!Schema::hasColumn('loans', 'fine_amount')) {
                $table->decimal('fine_amount', 8, 2)->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropColumn('returned_at');
            $table->dropColumn('fine_amount');
        });
    }
}
