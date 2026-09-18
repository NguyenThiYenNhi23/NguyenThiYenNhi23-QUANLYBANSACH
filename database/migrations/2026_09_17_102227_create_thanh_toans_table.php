<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('thanh_toans', function (Blueprint $table) {

            $table->id('maThanhToan');

            // Có thể chưa có đơn hàng khi giao dịch VNPay mới được tạo
            $table->unsignedBigInteger('maDH')->nullable();

            // Phương thức thanh toán
            $table->unsignedBigInteger('maPTTT');

            // Số tiền thanh toán
            $table->decimal('soTien', 15, 2);

            // Mã giao dịch mô phỏng VNPay
            $table->string('maGiaoDich', 100)->unique();

            // Phương thức được chọn bên trong VNPay
            // qr / bank / international / app
            $table->string('phuongThuc', 50)->nullable();

            // Trang thái giao dịch
            // ChoThanhToan / DaThanhToan / ThatBai
            $table->string('trangThai', 50)
                ->default('ChoThanhToan');

            // Thời gian thanh toán thành công
            $table->dateTime('thoiGianThanhToan')->nullable();

            $table->timestamps();

            // Liên kết đơn hàng
            $table->foreign('maDH')
                ->references('maDH')
                ->on('don_hangs')
                ->onUpdate('cascade')
                ->onDelete('set null');

            // Liên kết phương thức thanh toán
            $table->foreign('maPTTT')
                ->references('maPTTT')
                ->on('phuong_thuc_thanh_toans')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('thanh_toans');
    }
};