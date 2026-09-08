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
Schema::create('ton_khos', function (Blueprint $table) {
        $table->id('maTonKho');
        $table->unsignedBigInteger('maSach')->unique();
        $table->integer('soLuongTon')->default(0);
        $table->dateTime('ngayCapNhat')->nullable();

        $table->foreign('maSach')
            ->references('maSach')
            ->on('sachs')
            ->onUpdate('cascade')
            ->onDelete('restrict');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ton_khos');
    }
};
