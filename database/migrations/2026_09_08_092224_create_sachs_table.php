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
        Schema::create('sachs', function (Blueprint $table) {
            $table->id('maSach');

            $table->unsignedBigInteger('maDanhMuc');

            $table->string('tenSach', 255);
            $table->decimal('giaBan', 15, 2);

            $table->text('moTa')->nullable();
            $table->string('hinhAnh', 255)->nullable();

            $table->enum('trangThai', [
                'Đang kinh doanh',
                'Hết hàng',
                'Ngừng kinh doanh'
            ])->default('Đang kinh doanh');

            $table->timestamps();

            $table->foreign('maDanhMuc')
                ->references('maDanhMuc')
                ->on('danh_mucs')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sachs');
    }
};