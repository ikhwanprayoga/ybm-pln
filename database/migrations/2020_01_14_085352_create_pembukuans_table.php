<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembukuansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembukuans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('kategori_pembukuan_id')->nullable();
            $table->unsignedBigInteger('kategori_ashnaf_id')->nullable();
            $table->unsignedBigInteger('kategori_program_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->date('tanggal');
            $table->string('tipe');
            $table->text('uraian');
            $table->integer('nominal');
            // $table->integer('sisa_saldo');
            $table->integer('penerima_manfaat');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
            
            $table->foreign('kategori_pembukuan_id')
                ->references('id')
                ->on('kategori_pembukuans')
                ->onDelete('set null');

            $table->foreign('kategori_ashnaf_id')
                ->references('id')
                ->on('kategori_ashnafs')
                ->onDelete('set null');

            $table->foreign('kategori_program_id')
                ->references('id')
                ->on('kategori_programs')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembukuans');
    }
}
