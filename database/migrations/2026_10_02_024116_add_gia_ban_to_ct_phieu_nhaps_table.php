<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ct_phieu_nhaps', function (Blueprint $table) {
            $table->decimal(
                'giaBan',
                15,
                2
            )->after('donGia');
        });
    }

    public function down(): void
    {
        Schema::table('ct_phieu_nhaps', function (Blueprint $table) {
            $table->dropColumn('giaBan');
        });
    }
};