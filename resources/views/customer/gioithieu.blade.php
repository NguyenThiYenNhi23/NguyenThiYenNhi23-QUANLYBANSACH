<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Giới thiệu - Nhà xuất bản Kim Đồng</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            color: #333;
        }

        .gioi-thieu {
            max-width: 1100px;
            margin: 50px auto;
            padding: 40px;
            background: white;
            border-radius: 10px;
        }

        .gioi-thieu h1 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 30px;
        }

        .gioi-thieu h2 {
            margin-top: 30px;
            margin-bottom: 15px;
            font-size: 22px;
        }

        .gioi-thieu p {
            line-height: 1.8;
            margin-bottom: 15px;
            color: #555;
        }

        .linh-vuc {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 25px;
        }

        .linh-vuc-item {
            padding: 25px;
            background: #f8f9fa;
            border-radius: 8px;
            text-align: center;
        }

        .linh-vuc-item h3 {
            margin-bottom: 12px;
        }

        .quay-lai {
            display: block;
            width: fit-content;
            margin: 35px auto 0;
            padding: 10px 20px;
            background: #2f80ed;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }

        .quay-lai:hover {
            opacity: 0.9;
        }
    </style>
</head>

<body>

    <div class="gioi-thieu">

        <h1>Giới thiệu về Nhà xuất bản Kim Đồng</h1>

        <p>
            Nhà xuất bản Kim Đồng là đơn vị xuất bản chuyên về sách
            dành cho thiếu nhi, thanh thiếu niên và bạn đọc trẻ.
            Nhà xuất bản phát hành nhiều thể loại sách với nội dung
            phong phú, phù hợp với nhiều độ tuổi.
        </p>

        <p>
            Các sản phẩm được phát hành gồm truyện tranh, truyện thiếu nhi,
            văn học, sách kiến thức, giáo dục và nhiều ấn phẩm khác.
            Hoạt động xuất bản góp phần mang đến những tác phẩm có giá trị
            phục vụ nhu cầu học tập, đọc sách và giải trí của bạn đọc.
        </p>

        <h2>Lĩnh vực hoạt động</h2>

        <div class="linh-vuc">

            <div class="linh-vuc-item">
                <h3>📚 Sách thiếu nhi</h3>
                <p>
                    Các tác phẩm dành cho trẻ em và bạn đọc nhỏ tuổi.
                </p>
            </div>

            <div class="linh-vuc-item">
                <h3>📖 Văn học</h3>
                <p>
                    Các tác phẩm văn học trong nước và nước ngoài
                    dành cho nhiều đối tượng độc giả.
                </p>
            </div>

            <div class="linh-vuc-item">
                <h3>🎓 Sách kiến thức</h3>
                <p>
                    Sách giáo dục, kiến thức và các ấn phẩm
                    hỗ trợ học tập.
                </p>
            </div>

        </div>

        <h2>Về website bán sách</h2>

        <p>
            Website được xây dựng nhằm hỗ trợ khách hàng dễ dàng tìm kiếm,
            xem thông tin, lựa chọn và đặt mua các sản phẩm sách trực tuyến.
            Hệ thống giúp quá trình mua sách trở nên thuận tiện và nhanh chóng hơn.
        </p>

        <a href="{{ route('customer.home') }}" class="quay-lai">
            ← Quay lại trang chủ
        </a>

    </div>

</body>
</html>