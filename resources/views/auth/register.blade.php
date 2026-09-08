<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            font-family: Arial, Helvetica, sans-serif;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1f2937;
        }

        .auth-card {
            width: min(92vw, 400px);
            background: rgba(255,255,255,0.82);
            border: 1px solid #dfe3e8;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
            padding: 22px 22px 18px;
        }

        .brand {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 14px;
            font-weight: 700;
            font-size: 18px;
            color: #1f2937;
        }

        .brand-mark {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: #1e88e5;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 13px;
        }

        h1 {
            margin: 0 0 16px;
            text-align: center;
            font-size: 22px;
            color: #111827;
        }

        .form-group {
            margin-bottom: 12px;
        }

        .field-label {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 7px;
            font-size: 14px;
            font-weight: 600;
            color: #111827;
        }

        .required {
            color: #6b7280;
            font-size: 11px;
            font-weight: 500;
        }

        .input {
            width: 100%;
            border: 1px solid #d1d5db;
            background: #fff;
            border-radius: 10px;
            padding: 11px 11px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .input:focus {
            border-color: #1e88e5;
            box-shadow: 0 0 0 3px rgba(30, 136, 229, 0.12);
        }

        .error {
            display: block;
            margin-top: 5px;
            color: #b91c1c;
            font-size: 12px;
        }

        .primary-btn {
            width: 100%;
            margin-top: 6px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #1e88e5, #0d6ad7);
            color: #fff;
            padding: 12px 14px;
            font-size: 17px;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.15s ease, opacity 0.2s ease;
        }

        .primary-btn:hover {
            opacity: 0.96;
            transform: translateY(-1px);
        }

        .switch-box {
            margin-top: 16px;
            text-align: center;
            font-size: 13px;
            color: #374151;
        }

        .switch-box a {
            color: #0d6ad7;
            text-decoration: none;
            font-weight: 700;
        }
    </style>
</head>

<body>
    <div class="auth-card">
        <div class="brand">
            <span class="brand-mark">◌</span>
            <span>Nhà Sách Kim Đồng</span>
        </div>

        <h1>Đăng ký tài khoản</h1>

        <form method="POST" action="{{ route('register.store') }}">
            @csrf

            <div class="form-group">
                <div class="field-label">
                    <label for="name">Họ tên</label>
                    <span class="required">Required</span>
                </div>
                <input id="name" class="input" type="text" name="name" value="{{ old('name') }}">
                @error('name')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <div class="field-label">
                    <label for="email">Email</label>
                    <span class="required">Required</span>
                </div>
                <input id="email" class="input" type="email" name="email" value="{{ old('email') }}">
                @error('email')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <div class="field-label">
                    <label for="phone">Số điện thoại</label>
                    <span class="required">Required</span>
                </div>
                <input id="phone" class="input" type="tel" name="phone" value="{{ old('phone') }}">
                @error('phone')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <div class="field-label">
                    <label for="password">Mật khẩu</label>
                    <span class="required">Required</span>
                </div>
                <input id="password" class="input" type="password" name="password">
                @error('password')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <div class="field-label">
                    <label for="password_confirmation">Nhập lại mật khẩu</label>
                    <span class="required">Required</span>
                </div>
                <input id="password_confirmation" class="input" type="password" name="password_confirmation">
            </div>

            <button class="primary-btn" type="submit">Đăng ký</button>
        </form>

        <div class="switch-box">
            Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập</a>
        </div>

        <div class="switch-box" style="margin-top: 10px;">
            <a href="{{ url('/') }}">← Về trang chủ</a>
        </div>
    </div>
</body>
</html>