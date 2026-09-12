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
        if (! Schema::hasColumn('sachs', 'trangThai')) {
            Schema::table('sachs', function (Blueprint $table) {
                $table->enum('trangThai', [
                    'Đang kinh doanh',
                    'Hết hàng',
                    'Ngừng kinh doanh',
                ])->default('Đang kinh doanh');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('sachs', 'trangThai')) {
            Schema::table('sachs', function (Blueprint $table) {
                $table->dropColumn('trangThai');
            });
        }
    }
};
