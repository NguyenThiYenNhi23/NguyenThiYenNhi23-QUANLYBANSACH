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
          Schema::create('tai_khoans', function (Blueprint $table) {
        $table->id('maTK');
        $table->string('tenDangNhap', 50)->unique();
        $table->string('matKhau', 255);
        $table->string('vaiTro', 30);
        $table->boolean('trangThai')->default(true);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tai_khoans');
    }
};
