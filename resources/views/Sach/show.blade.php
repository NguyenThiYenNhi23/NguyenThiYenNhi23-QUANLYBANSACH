<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chi tiết sách</title>
</head>

<body>

<h1>CHI TIẾT SÁCH</h1>

<table border="1" cellpadding="10">

    <tr>
        <th>Mã sách</th>
        <td>{{ $sach->maSach }}</td>
    </tr>

    <tr>
        <th>Tên sách</th>
        <td>{{ $sach->tenSach }}</td>
    </tr>

    <tr>
        <th>Danh mục</th>
        <td>
            {{ $sach->danhMuc->tenDanhMuc ?? 'Không có' }}
        </td>
    </tr>

    <tr>
        <th>Giá bán</th>
        <td>
            {{ number_format($sach->giaBan, 0, ',', '.') }} đ
        </td>
    </tr>

    <tr>
        <th>Mô tả</th>
        <td>
            {{ $sach->moTa ?? 'Không có' }}
        </td>
    </tr>

    <tr>
        <th>Hình ảnh</th>
        <td>
            @if ($sach->hinhAnh)
                <img
                    src="{{ asset('storage/' . $sach->hinhAnh) }}"
                    alt="{{ $sach->tenSach }}"
                    style="max-width: 220px; max-height: 220px; object-fit: cover; border: 1px solid #ccc;"
                >
            @else
                Không có
            @endif
        </td>
    </tr>

    <tr>
        <th>Trạng thái</th>
        <td>
            {{ $sach->trangThai }}
        </td>
    </tr>

</table>

<br>

<a href="{{ route('sach.index') }}">
    Quay lại
</a>

</body>

</html>