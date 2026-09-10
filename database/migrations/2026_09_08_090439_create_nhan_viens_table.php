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

        $table->foreignId('user_id')
        ->unique()
        ->constrained('users')
        ->onUpdate('cascade')
        ->onDelete('cascade');

        $table->string('hoTen', 100);
        $table->string('sdt', 15)->nullable();
        $table->string('email', 100)->nullable();
        $table->string('diaChi', 255)->nullable();


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
