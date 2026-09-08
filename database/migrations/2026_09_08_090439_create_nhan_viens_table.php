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
       Schema::create('nhan_viens', function (Blueprint $table) {
        $table->id('maNV');

        $table->unsignedBigInteger('maTK')->unique();

        $table->string('hoTen', 100);
        $table->string('sdt', 15)->nullable();
        $table->string('email', 100)->nullable();
        $table->string('diaChi', 255)->nullable();

        $table->foreign('maTK')
            ->references('maTK')
            ->on('tai_khoans')
            ->onUpdate('cascade')
            ->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nhan_viens');
    }
};
