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
        Schema::table('proposals', function (Blueprint $table) {
            $table->string('reviewed_pdf_path')->nullable()->after('pdf_path');
        });
    }

    public function down()
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->dropColumn('reviewed_pdf_path');
        });
    }
};
