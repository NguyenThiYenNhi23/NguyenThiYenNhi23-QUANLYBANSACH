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
        Schema::create('dia_chis', function (Blueprint $table) {
        $table->id('maDiaChi');

        $table->unsignedBigInteger('maKH');

        $table->string('hoTenNguoiNhan', 100);
        $table->string('sdt', 15);
        $table->string('diaChiChiTiet', 255);
        $table->boolean('isDefault')->default(false);

        $table->foreign('maKH')
            ->references('maKH')
            ->on('khach_hangs')
            ->onUpdate('cascade')
            ->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dia_chis');
    }
};
