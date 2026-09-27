<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Quên mật khẩu - Nhà xuất bản Kim Đồng</title>
<style>
*{box-sizing:border-box}
body{margin:0;min-height:100vh;font-family:Arial,Helvetica,sans-serif;background:#f7f7f7;color:#333;display:flex;align-items:center;justify-content:center;padding:20px}
.auth-wrapper{width:100%;max-width:1000px;background:#fff;display:grid;grid-template-columns:1fr 1fr;box-shadow:0 5px 25px rgba(0,0,0,.1);border-radius:4px;overflow:hidden}
.brand-side{background:#e31837;color:#fff;display:flex;align-items:center;justify-content:center;text-align:center;padding:45px}
.brand-content{max-width:350px}
.book-symbol{font-size:65px;margin-bottom:12px}
.logo{font-size:44px;font-weight:900;letter-spacing:2px}
.logo-line{width:65px;height:4px;background:#fff;margin:15px auto 22px}
.brand-content h2{font-size:25px;margin:0 0 14px}
.brand-content p{font-size:15px;line-height:1.7;margin:0}
.form-side{padding:55px 65px;display:flex;align-items:center}
.form-container{width:100%;max-width:400px;margin:auto}
.form-container h1{font-size:27px;color:#222;text-align:center;margin:0 0 8px}
.intro{text-align:center;font-size:14px;color:#777;line-height:1.6;margin:0 0 24px}
.alert{padding:11px 13px;background:#edf9f2;border-left:4px solid #16834b;color:#146c3e;font-size:13px;margin-bottom:18px;border-radius:3px}
.error{padding:11px 13px;background:#fff1f1;border-left:4px solid #e31837;color:#c41430;font-size:13px;margin-bottom:18px;border-radius:3px}
.form-group{margin-bottom:18px}
.field-label{display:flex;justify-content:space-between;align-items:center;margin-bottom:7px;font-size:14px;font-weight:600;color:#333}
.required{font-size:10px;color:#999;font-weight:400}
.input{width:100%;height:45px;border:1px solid #d5d5d5;border-radius:3px;padding:0 12px;font-size:14px;outline:none;transition:.2s}
.input:focus{border-color:#e31837;box-shadow:0 0 0 2px rgba(227,24,55,.08)}
.primary-btn{width:100%;height:47px;border:0;border-radius:3px;background:#e31837;color:#fff;font-size:16px;font-weight:700;cursor:pointer;transition:.2s}
.primary-btn:hover{background:#c91430}
.divider{display:flex;align-items:center;gap:10px;margin:22px 0 0;color:#aaa;font-size:11px}
.divider:before,.divider:after{content:"";height:1px;background:#e5e5e5;flex:1}
.switch-box{text-align:center;margin-top:16px;font-size:13px}
.switch-box a{color:#e31837;text-decoration:none;font-weight:700}
@media(max-width:768px){
body{padding:15px}
.auth-wrapper{display:block}
.brand-side{padding:28px 20px}
.book-symbol{font-size:42px;margin-bottom:5px}
.logo{font-size:34px}
.logo-line{margin:10px auto 15px}
.brand-content h2{font-size:20px}
.brand-content p{font-size:13px}
.form-side{padding:32px 25px}
}
</style>
</head>
<body>
<div class="auth-wrapper">
<div class="brand-side">
<div class="brand-content">
<div class="book-symbol">📚</div>
<div class="logo">KIM ĐỒNG</div>
<div class="logo-line"></div>
<h2>Nhà xuất bản Kim Đồng</h2>
<p>Lan tỏa tri thức, chắp cánh những ước mơ.</p>
</div>
</div>

<div class="form-side">
<div class="form-container">
<h1>Quên mật khẩu</h1>
<p class="intro">Nhập email của bạn để nhận liên kết đặt lại mật khẩu.</p>

@if(session('status'))
<div class="alert">{{ session('status') }}</div>
@endif

@if($errors->any())
<div class="error">{{ $errors->first() }}</div>
@endif

<form method="POST" action="{{ route('password.email') }}">
@csrf

<div class="form-group">
<div class="field-label">
<label for="email">Địa chỉ email</label>
<span class="required">Required</span>
</div>
<input id="email" class="input" type="email" name="email" value="{{ old('email') }}" placeholder="Nhập địa chỉ email">
</div>

<button class="primary-btn" type="submit">Gửi liên kết đặt lại mật khẩu</button>
</form>

<div class="divider">KIM ĐỒNG</div>

<div class="switch-box">
<a href="{{ route('login') }}">← Quay lại đăng nhập</a>
</div>
</div>
</div>
</div>
</body>
</html>