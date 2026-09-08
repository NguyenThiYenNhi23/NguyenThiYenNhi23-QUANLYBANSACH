<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt lại mật khẩu</title>
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
            width: min(92vw, 380px);
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
            margin-bottom: 12px;
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
            margin: 0 0 8px;
            text-align: center;
            font-size: 24px;
            color: #111827;
        }

        .intro {
            text-align: center;
            font-size: 14px;
            color: #4b5563;
            margin: 0 0 14px;
        }

        .error {
            margin: 0 0 12px;
            padding: 10px 12px;
            border-radius: 8px;
            background: #fff3f3;
            color: #b91c1c;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 14px;
        }

        .field-label {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 7px;
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
            padding: 12px 11px;
            font-size: 14px;
            outline: none;
        }

        .input:focus {
            border-color: #1e88e5;
            box-shadow: 0 0 0 3px rgba(30, 136, 229, 0.12);
        }

        .primary-btn {
            width: 100%;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #1e88e5, #0d6ad7);
            color: #fff;
            padding: 12px 14px;
            font-size: 17px;
            font-weight: 700;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="brand">
            <span class="brand-mark">◌</span>
            <span>ttshop</span>
        </div>

        <h1>Đặt lại mật khẩu</h1>
        <p class="intro">Nhập mật khẩu mới cho tài khoản của bạn.</p>

        @if ($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
                <div class="field-label">
                    <label for="email">Email</label>
                    <span class="required">Required</span>
                </div>
                <input id="email" class="input" type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com">
            </div>

            <div class="form-group">
                <div class="field-label">
                    <label for="password">Mật khẩu mới</label>
                    <span class="required">Required</span>
                </div>
                <input id="password" class="input" type="password" name="password" placeholder="••••••••">
            </div>

            <div class="form-group">
                <div class="field-label">
                    <label for="password_confirmation">Xác nhận mật khẩu</label>
                    <span class="required">Required</span>
                </div>
                <input id="password_confirmation" class="input" type="password" name="password_confirmation" placeholder="••••••••">
            </div>

            <button class="primary-btn" type="submit">Cập nhật mật khẩu</button>
        </form>
    </div>
</body>
</html>
