<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRkatProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rkat_programs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('kategori_program_id')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('rincian_rkat')->nullable();
            $table->integer('rupiah')->nullable();
            $table->integer('periode')->nullable();
            $table->timestamps();

            $table->foreign('kategori_program_id')->references('id')->on('kategori_programs')->onDelete('set null');
            $table->foreign('parent_id')->references('id')->on('rkat_programs')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rkat_programs');
    }
}
