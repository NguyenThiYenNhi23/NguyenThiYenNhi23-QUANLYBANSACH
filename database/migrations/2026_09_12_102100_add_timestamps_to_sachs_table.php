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
        Schema::table('sachs', function (Blueprint $table) {
            if (! Schema::hasColumn('sachs', 'created_at')) {
                $table->timestamp('created_at')->nullable();
            }

            if (! Schema::hasColumn('sachs', 'updated_at')) {
                $table->timestamp('updated_at')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sachs', function (Blueprint $table) {
            if (Schema::hasColumn('sachs', 'created_at')) {
                $table->dropColumn('created_at');
            }

            if (Schema::hasColumn('sachs', 'updated_at')) {
                $table->dropColumn('updated_at');
            }
        });
    }
};
