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
 Schema::create('ct_phieu_nhaps', function (Blueprint $table) {
        $table->unsignedBigInteger('maPN');
        $table->unsignedBigInteger('maSach');

        $table->integer('soLuong');
        $table->decimal('donGia', 15, 2);
        $table->decimal('thanhTien', 15, 2);

        $table->foreign('maPN')
            ->references('maPN')
            ->on('phieu_nhaps')
            ->onUpdate('cascade')
            ->onDelete('cascade');

        $table->foreign('maSach')
            ->references('maSach')
            ->on('sachs')
            ->onUpdate('cascade')
            ->onDelete('restrict');

        $table->primary(['maPN', 'maSach']);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ct_phieu_nhaps');
    }
};
