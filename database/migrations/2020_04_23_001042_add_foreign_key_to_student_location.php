<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyToStudentLocation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_locations', function (Blueprint $table) {
            $table->bigInteger('id_siswa')->unsigned();
            $table->index('id_siswa');
            $table->foreign('id_siswa')
                  ->references('id')
                  ->on('siswa')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_locations', function (Blueprint $table) {
            $table->dropForeign(['id_siswa']);
            $table->dropIndex(['id_siswa']);
            $table->dropColumn('id_siswa');
        });
    }
}
