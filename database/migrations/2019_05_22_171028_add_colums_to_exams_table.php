<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumsToExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exams', function (Blueprint $table) {

            $table->string('term')->after('exam_name');
            $table->dateTime('start_date')->after('active');
            $table->dateTime('end_date')->after('active');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exams', function (Blueprint $table) {
            $table->dropColumn(['term','start_date','end_date']);
        });
    }
}
