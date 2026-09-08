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
Schema::create('phieu_nhaps', function (Blueprint $table) {
        $table->id('maPN');

        $table->unsignedBigInteger('maNV');

        $table->dateTime('ngayNhap');
        $table->decimal('tongTien', 15, 2);
        $table->string('trangThai', 50)->default('HoanThanh');

        $table->foreign('maNV')
            ->references('maNV')
            ->on('nhan_viens')
            ->onUpdate('cascade')
            ->onDelete('restrict');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phieu_nhaps');
    }
};
