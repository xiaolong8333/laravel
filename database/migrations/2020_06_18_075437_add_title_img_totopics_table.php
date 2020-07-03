<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTitleImgTotopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('topics', function (Blueprint $table) {
            //
            $table->string('title_img')->nullable()->default('')->after('body');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('topics', function (Blueprint $table) {
            //
            $table->dropColumn('title_img');
        });
    }
}
