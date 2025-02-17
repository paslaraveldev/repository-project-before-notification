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
        Schema::table('reports', function (Blueprint $table) {
            $table->string('review_pdf')->nullable()->after('pdf_file'); // Store supervisor review PDFs separately
        });
    }

    public function down()
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn('review_pdf');
        });
    }

};
