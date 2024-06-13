<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('penjualan_id')->unsigned();
            $table->date('tanggal');
            $table->string('bank');
            $table->string('bukti');
            $table->integer('total')->default(0);
            $table->smallInteger('status')->default(0);
            $table->text('deskripsi');
            $table->timestamps();
            $table->foreign('penjualan_id')->references('id')->on('penjualans');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
