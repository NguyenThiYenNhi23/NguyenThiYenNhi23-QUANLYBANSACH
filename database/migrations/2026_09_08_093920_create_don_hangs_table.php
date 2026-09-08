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
        Schema::create('don_hangs', function (Blueprint $table) {
        $table->id('maDH');

        $table->unsignedBigInteger('maKH');
        $table->unsignedBigInteger('maDiaChi');
        $table->unsignedBigInteger('maPTTT');

        $table->dateTime('ngayDat');
        $table->decimal('tongTien', 15, 2);
        $table->string('trangThai', 50)->default('ChoXacNhan');

        $table->foreign('maKH')
            ->references('maKH')
            ->on('khach_hangs')
            ->onUpdate('cascade')
            ->onDelete('restrict');

        $table->foreign('maDiaChi')
            ->references('maDiaChi')
            ->on('dia_chis')
            ->onUpdate('cascade')
            ->onDelete('restrict');

        $table->foreign('maPTTT')
            ->references('maPTTT')
            ->on('phuong_thuc_thanh_toans')
            ->onUpdate('cascade')
            ->onDelete('restrict');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('don_hangs');
    }
};
