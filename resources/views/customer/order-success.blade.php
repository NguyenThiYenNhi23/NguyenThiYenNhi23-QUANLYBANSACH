<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng thành công</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #ecfdf5, #f8fafc);
            color: #1f2937;
        }

        .page {
            max-width: 1000px;
            margin: 50px auto;
            padding: 0 20px;
        }

        .card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
            padding: 32px;
        }

        .success-box {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            border-radius: 16px;
            padding: 20px;
            color: #065f46;
            font-size: 1.05rem;
            margin-bottom: 24px;
            font-weight: 600;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }

        h1, h2, h3 {
            margin-top: 0;
        }

        .info-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 18px;
        }

        .items {
            display: flex;
            flex-direction: column;
            gap: 14px;
            margin-top: 16px;
        }

        .item-row {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 12px;
            align-items: center;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 12px 14px;
        }

        .price {
            color: #d97706;
            font-weight: 700;
        }

        .btn {
            border: none;
            border-radius: 10px;
            padding: 12px 18px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: #fff;
            margin-top: 24px;
        }

        @media (max-width: 800px) {
            .grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="card">
            <div class="success-box">
                ✅ Đặt hàng thành công! Đơn hàng của bạn đã được ghi nhận và đang chờ xác nhận.
            </div>

            <div class="grid">
                <div>
                    <h2>Thông tin đơn hàng</h2>
                    <div class="info-box">
                        <p><strong>Mã đơn hàng:</strong> #{{ $donHang->maDH }}</p>
                        <p><strong>Ngày đặt:</strong> {{ $donHang->ngayDat }}</p>
                        <p><strong>Trạng thái:</strong> {{ $donHang->trangThai }}</p>
                        <p><strong>Phương thức thanh toán:</strong> {{ $donHang->phuongThucThanhToan->tenPhuongThuc ?? 'Chưa xác định' }}</p>
                    </div>
                </div>

                <div>
                    <h2>Giao hàng</h2>
                    <div class="info-box">
                        <p><strong>Người nhận:</strong> {{ $donHang->diaChi->hoTenNguoiNhan ?? 'Chưa cập nhật' }}</p>
                        <p><strong>Số điện thoại:</strong> {{ $donHang->diaChi->sdt ?? 'Chưa cập nhật' }}</p>
                        <p><strong>Địa chỉ:</strong> {{ $donHang->diaChi->diaChiChiTiet ?? 'Chưa cập nhật' }}</p>
                    </div>
                </div>
            </div>

            <h2 style="margin-top: 28px;">Sản phẩm đã đặt</h2>
            <div class="items">
                @foreach ($donHang->chiTietDonHangs as $item)
                    <div class="item-row">
                        <div>
                            <div><strong>{{ $item->sach->tenSach ?? 'Sách' }}</strong></div>
                            <div>Số lượng: {{ $item->soLuong }}</div>
                        </div>
                        <div class="price">
                            {{ number_format($item->thanhTien, 0, ',', '.') }} đ
                        </div>
                    </div>
                @endforeach
            </div>

            <div style="margin-top: 24px; font-size: 1.1rem; font-weight: 700; text-align: right;">
                Tổng tiền: {{ number_format($donHang->tongTien, 0, ',', '.') }} đ
            </div>

            <a href="{{ route('customer.home') }}" class="btn">Tiếp tục mua sắm</a>
        </div>
    </div>
</body>
</html>
