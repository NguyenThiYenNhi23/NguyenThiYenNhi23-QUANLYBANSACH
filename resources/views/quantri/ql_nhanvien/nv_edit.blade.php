<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sửa nhân viên</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f6fa;
        }

        .container {
            width: 700px;
            max-width: 90%;
            margin: 40px auto;
        }

        .form-box {
            background: white;
            padding: 30px;
            border-radius: 8px;
        }

        h1 {
            margin-top: 0;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input,
        textarea {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
        }

        textarea {
            min-height: 90px;
            resize: vertical;
        }

        .error {
            color: #dc3545;
            font-size: 13px;
            margin-top: 5px;
        }

        .actions {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        .btn {
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-save {
            background: #198754;
            color: white;
        }

        .btn-back {
            background: #6c757d;
            color: white;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="form-box">

        <h1> Sửa nhân viên</h1>

        <form
            method="POST"
            action="{{ route('quantri.nhanvien.update', $nhanVien->maNV) }}"
        >

            @csrf
            @method('PUT')


            <div class="form-group">

                <label>Họ tên</label>

                <input
                    type="text"
                    name="hoTen"
                    value="{{ old('hoTen', $nhanVien->hoTen) }}"
                >

                @error('hoTen')
                    <div class="error">{{ $message }}</div>
                @enderror

            </div>


            <div class="form-group">

                <label>Số điện thoại</label>

                <input
                    type="text"
                    name="sdt"
                    value="{{ old('sdt', $nhanVien->sdt) }}"
                >

                @error('sdt')
                    <div class="error">{{ $message }}</div>
                @enderror

            </div>


            <div class="form-group">

                <label>Email</label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email', $nhanVien->email) }}"
                >

                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror

            </div>


            <div class="form-group">

                <label>Địa chỉ</label>

                <textarea
                    name="diaChi"
                >{{ old('diaChi', $nhanVien->diaChi) }}</textarea>

                @error('diaChi')
                    <div class="error">{{ $message }}</div>
                @enderror

            </div>


            <div class="actions">

                <button type="submit"
                        class="btn btn-save">
                    Cập nhật
                </button>

                <a href="{{ route('quantri.nhanvien.index') }}"
                   class="btn btn-back">
                    Quay lại
                </a>

            </div>

        </form>

    </div>

</div>

</body>
</html>