<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Đăng ký - Nhà xuất bản Kim Đồng</title>
<style>
*{box-sizing:border-box}
body{margin:0;min-height:100vh;font-family:Arial,Helvetica,sans-serif;background:#f7f7f7;color:#333;display:flex;align-items:center;justify-content:center;padding:20px}
.auth-wrapper{width:100%;max-width:1050px;background:#fff;display:grid;grid-template-columns:1fr 1fr;box-shadow:0 5px 25px rgba(0,0,0,.1);border-radius:4px;overflow:hidden}
.brand-side{background:#e31837;display:flex;align-items:center;justify-content:center;padding:45px;color:#fff;text-align:center}
.brand-content{max-width:360px}
.book-symbol{font-size:60px;margin-bottom:12px}
.logo{font-size:44px;font-weight:900;letter-spacing:2px}
.logo-line{width:65px;height:4px;background:#fff;margin:15px auto 22px}
.brand-content h2{font-size:25px;margin:0 0 14px}
.brand-content p{font-size:15px;line-height:1.7;margin:0}
.form-side{padding:38px 65px;display:flex;align-items:center}
.form-container{width:100%;max-width:400px;margin:auto}
.form-container h1{text-align:center;font-size:27px;margin:0 0 7px;color:#222}
.subtitle{text-align:center;color:#777;font-size:14px;margin:0 0 22px}
.form-group{margin-bottom:13px}
.field-label{display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;font-size:14px;font-weight:600;color:#333}
.required{font-size:10px;color:#999;font-weight:400}
.input{width:100%;height:43px;border:1px solid #d5d5d5;border-radius:3px;padding:0 12px;font-size:14px;outline:none}
.input:focus{border-color:#e31837;box-shadow:0 0 0 2px rgba(227,24,55,.08)}
.error{display:block;margin-top:4px;color:#c41430;font-size:12px}
.primary-btn{width:100%;height:46px;margin-top:5px;border:0;border-radius:3px;background:#e31837;color:#fff;font-size:16px;font-weight:700;cursor:pointer}
.primary-btn:hover{background:#c91430}
.switch-box{text-align:center;font-size:14px;color:#666;margin-top:18px}
.switch-box a{color:#e31837;text-decoration:none;font-weight:700}
.home-link{display:block;margin-top:13px!important;color:#777!important;font-size:13px!important;font-weight:400!important}
.home-link:hover{color:#e31837!important}
.divider{display:flex;align-items:center;gap:10px;margin:20px 0 0;color:#aaa;font-size:11px}
.divider:before,.divider:after{content:"";height:1px;background:#e5e5e5;flex:1}
@media(max-width:768px){
body{padding:15px}
.auth-wrapper{display:block}
.brand-side{padding:28px 20px}
.book-symbol{font-size:42px;margin-bottom:5px}
.logo{font-size:34px}
.logo-line{margin:10px auto 15px}
.brand-content h2{font-size:20px}
.brand-content p{font-size:13px}
.form-side{padding:30px 25px}
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
<p>Đăng ký tài khoản để khám phá và mua sắm các đầu sách từ Nhà xuất bản Kim Đồng.</p>
</div>
</div>

<div class="form-side">
<div class="form-container">
<h1>Đăng ký tài khoản</h1>
<p class="subtitle">Tạo tài khoản để bắt đầu mua sắm</p>

<form method="POST" action="{{ route('register.store') }}">
@csrf

<div class="form-group">
<div class="field-label">
<label for="name">Họ tên</label>
<span class="required">Required</span>
</div>
<input id="name" class="input" type="text" name="name" value="{{ old('name') }}" placeholder="Nhập họ tên">
@error('name')<span class="error">{{ $message }}</span>@enderror
</div>

<div class="form-group">
<div class="field-label">
<label for="email">Email</label>
<span class="required">Required</span>
</div>
<input id="email" class="input" type="email" name="email" value="{{ old('email') }}" placeholder="Nhập địa chỉ email">
@error('email')<span class="error">{{ $message }}</span>@enderror
</div>

<div class="form-group">
<div class="field-label">
<label for="phone">Số điện thoại</label>
<span class="required">Required</span>
</div>
<input id="phone" class="input" type="tel" name="phone" value="{{ old('phone') }}" placeholder="Nhập số điện thoại">
@error('phone')<span class="error">{{ $message }}</span>@enderror
</div>

<div class="form-group">
<div class="field-label">
<label for="password">Mật khẩu</label>
<span class="required">Required</span>
</div>
<input id="password" class="input" type="password" name="password" placeholder="Nhập mật khẩu">
@error('password')<span class="error">{{ $message }}</span>@enderror
</div>

<div class="form-group">
<div class="field-label">
<label for="password_confirmation">Nhập lại mật khẩu</label>
<span class="required">Required</span>
</div>
<input id="password_confirmation" class="input" type="password" name="password_confirmation" placeholder="Nhập lại mật khẩu">
</div>

<button class="primary-btn" type="submit">Đăng ký</button>
</form>

<div class="switch-box">
Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập</a>
</div>

<div class="divider">KIM ĐỒNG</div>

<a href="{{ route('customer.home') }}" class="switch-box home-link">← Về trang chủ</a>
</div>
</div>
</div>
</body>
</html>