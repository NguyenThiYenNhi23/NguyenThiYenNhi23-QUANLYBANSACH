<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Đặt hàng thành công - Kim Đồng</title>
<style>
*{
    box-sizing:border-box;
}

body{
    margin:0;
    font-family:Arial,Helvetica,sans-serif;
    background:#f6f6f6;
    color:#333;
}

.header{
    background:#fff;
    border-bottom:1px solid #eee;
}

.header-inner{
    max-width:1200px;
    margin:auto;
    height:82px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:0 20px;
}

.logo{
    color:#d71920;
    font-size:28px;
    font-weight:800;
    letter-spacing:.5px;
}

.logo span{
    display:block;
    color:#555;
    font-size:11px;
    font-weight:400;
    letter-spacing:1.5px;
    margin-top:3px;
}

.header-title{
    color:#333;
    font-size:15px;
}

.page{
    max-width:1000px;
    margin:45px auto;
    padding:0 20px 50px;
}

.success-card{
    background:#fff;
    border-radius:10px;
    box-shadow:0 4px 18px rgba(0,0,0,.08);
    overflow:hidden;
}

.success-top{
    background:#d71920;
    color:#fff;
    text-align:center;
    padding:38px 25px;
}

.success-icon{
    width:68px;
    height:68px;
    border-radius:50%;
    background:#fff;
    color:#d71920;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:36px;
    font-weight:bold;
    margin:0 auto 18px;
}

.success-top h1{
    margin:0 0 10px;
    font-size:27px;
}

.success-top p{
    margin:0;
    font-size:15px;
    line-height:1.6;
}

.content{
    padding:32px;
}

.order-code{
    background:#fff5f5;
    border:1px solid #ffd5d5;
    border-radius:8px;
    padding:18px 20px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom:28px;
}

.order-code span{
    color:#666;
    font-size:14px;
}

.order-code strong{
    color:#d71920;
    font-size:22px;
}

.section-title{
    font-size:20px;
    margin:0 0 15px;
    color:#333;
}

.info-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
    margin-bottom:30px;
}

.info-box{
    border:1px solid #e5e5e5;
    border-radius:8px;
    padding:20px;
    background:#fff;
}

.info-box h3{
    margin:0 0 16px;
    color:#d71920;
    font-size:17px;
    border-bottom:1px solid #eee;
    padding-bottom:12px;
}

.info-box p{
    margin:10px 0;
    line-height:1.5;
    font-size:14px;
}

.info-box p strong{
    color:#444;
}

.items{
    border:1px solid #e5e5e5;
    border-radius:8px;
    overflow:hidden;
    margin-bottom:24px;
}

.item-header{
    display:grid;
    grid-template-columns:1fr 130px;
    gap:15px;
    background:#f8f8f8;
    padding:14px 18px;
    font-size:13px;
    font-weight:bold;
    color:#555;
    border-bottom:1px solid #e5e5e5;
}

.item-row{
    display:grid;
    grid-template-columns:1fr 130px;
    gap:15px;
    align-items:center;
    padding:12px 18px;
    border-bottom:1px solid #eee;
    min-height:110px;
}

.item-row:last-child{
    border-bottom:none;
}

.product-info{
    display:flex;
    align-items:center;
    gap:15px;
    min-width:0;
}

.product-image{
    width:65px;
    height:85px;
    flex-shrink:0;
    border:1px solid #eee;
    border-radius:6px;
    overflow:hidden;
    background:#f8f8f8;
    display:flex;
    align-items:center;
    justify-content:center;
}

.product-image img{
    width:100%;
    height:100%;
    object-fit:contain;
}

.no-image{
    font-size:9px;
    color:#999;
    text-align:center;
    padding:3px;
}

.product-detail{
    min-width:0;
}

.item-name{
    font-weight:600;
    color:#333;
    margin-bottom:7px;
    line-height:1.4;
}

.item-quantity{
    font-size:13px;
    color:#777;
}

.price{
    color:#d71920;
    font-weight:bold;
    text-align:right;
}

.total{
    background:#fafafa;
    border:1px solid #eee;
    border-radius:8px;
    padding:20px;
    display:flex;
    justify-content:flex-end;
    align-items:center;
    gap:20px;
    margin-bottom:28px;
}

.total-label{
    font-size:16px;
    font-weight:600;
}

.total-price{
    color:#d71920;
    font-size:24px;
    font-weight:800;
}

.actions{
    display:flex;
    justify-content:center;
    gap:12px;
}

.btn{
    display:inline-block;
    text-decoration:none;
    padding:13px 24px;
    border-radius:6px;
    font-size:15px;
    font-weight:600;
    transition:.2s;
}

.btn-primary{
    background:#d71920;
    color:#fff;
}

.btn-primary:hover{
    background:#b9141a;
}

.btn-outline{
    background:#fff;
    color:#d71920;
    border:1px solid #d71920;
}

.btn-outline:hover{
    background:#fff5f5;
}

@media(max-width:700px){
    .header-inner{
        height:auto;
        padding:16px 20px;
    }

    .header-title{
        display:none;
    }

    .page{
        margin:25px auto;
    }

    .success-top{
        padding:30px 20px;
    }

    .success-top h1{
        font-size:23px;
    }

    .content{
        padding:20px;
    }

    .info-grid{
        grid-template-columns:1fr;
    }

    .order-code{
        align-items:flex-start;
        flex-direction:column;
        gap:8px;
    }

    .item-header{
        grid-template-columns:1fr auto;
    }

    .item-row{
        grid-template-columns:1fr auto;
        padding:12px;
    }

    .product-info{
        gap:10px;
    }

    .product-image{
        width:55px;
        height:72px;
    }

    .total{
        flex-direction:column;
        align-items:flex-end;
        gap:8px;
    }

    .actions{
        flex-direction:column;
    }

    .btn{
        text-align:center;
    }
}
</style>
</head>
<body>

<header class="header">
    <div class="header-inner">
        <div class="logo">
            KIM ĐỒNG
            <span>NHÀ XUẤT BẢN KIM ĐỒNG</span>
        </div>
        <div class="header-title">Đặt hàng thành công</div>
    </div>
</header>

<div class="page">
    <div class="success-card">

        <div class="success-top">
            <div class="success-icon">✓</div>
            <h1>Đặt hàng thành công!</h1>
            <p>Cảm ơn bạn đã mua hàng tại Nhà xuất bản Kim Đồng.</p>
            <p>Đơn hàng của bạn đã được ghi nhận và đang chờ xác nhận.</p>
        </div>

        <div class="content">

            <div class="order-code">
                <span>Mã đơn hàng của bạn</span>
                <strong>#{{ $donHang->maDH }}</strong>
            </div>

            <h2 class="section-title">Thông tin đơn hàng</h2>

            <div class="info-grid">

                <div class="info-box">
                    <h3>Thông tin đơn hàng</h3>

                    <p>
                        <strong>Ngày đặt:</strong>
                        {{ $donHang->ngayDat }}
                    </p>

                    <p>
                        <strong>Trạng thái:</strong>
                        {{ \App\Models\DonHang::statusLabel($donHang->trangThai) }}
                    </p>

                    <p>
                        <strong>Thanh toán:</strong>
                        {{ $donHang->phuongThucThanhToan->tenPhuongThuc ?? 'Chưa xác định' }}
                    </p>
                </div>

                <div class="info-box">
                    <h3>Thông tin giao hàng</h3>

                    <p>
                        <strong>Người nhận:</strong>
                        {{ $donHang->diaChi->hoTenNguoiNhan ?? 'Chưa cập nhật' }}
                    </p>

                    <p>
                        <strong>Số điện thoại:</strong>
                        {{ $donHang->diaChi->sdt ?? 'Chưa cập nhật' }}
                    </p>

                    <p>
                        <strong>Địa chỉ:</strong>
                        {{ $donHang->diaChi->diaChiChiTiet ?? 'Chưa cập nhật' }}
                    </p>
                </div>

            </div>

            <h2 class="section-title">Sản phẩm đã đặt</h2>

            <div class="items">

                <div class="item-header">
                    <div>Sản phẩm</div>
                    <div style="text-align:right;">Thành tiền</div>
                </div>

                @foreach ($donHang->chiTietDonHangs as $item)
                    <div class="item-row">
                        <div class="product-info">

                            <div class="product-image">
                                @if($item->sach && $item->sach->hinhAnh)
                                    <img src="{{ asset('storage/'.$item->sach->hinhAnh) }}"
                                         alt="{{ $item->sach->tenSach }}">
                                @else
                                    <div class="no-image">Không có ảnh</div>
                                @endif
                            </div>

                            <div class="product-detail">
                                <div class="item-name">
                                    {{ $item->sach->tenSach ?? 'Sách' }}
                                </div>

                                <div class="item-quantity">
                                    Số lượng: {{ $item->soLuong }}
                                </div>
                            </div>

                        </div>

                        <div class="price">
                            {{ number_format($item->thanhTien, 0, ',', '.') }} đ
                        </div>
                    </div>
                @endforeach

            </div>

            <div class="total">
                <span class="total-label">Tổng tiền</span>
                <span class="total-price">
                    {{ number_format($donHang->tongTien, 0, ',', '.') }} đ
                </span>
            </div>

            <div class="actions">
                <a href="{{ route('customer.home') }}" class="btn btn-outline">
                    Tiếp tục mua sắm
                </a>

                <a href="{{ url('/customer/account?section=orders') }}" class="btn btn-primary">
                    Xem đơn hàng
                </a>
            </div>

        </div>
    </div>
</div>

</body>
</html>