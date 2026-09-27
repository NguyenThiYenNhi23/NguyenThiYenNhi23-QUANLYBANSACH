<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Đăng nhập - Nhà xuất bản Kim Đồng</title>
<style>
*{box-sizing:border-box}
    body{
        margin:0;
        min-height:100vh;
        font-family:Arial,Helvetica,sans-serif;
        background:#f7f7f7;
        color:#333;
        display:flex;
        align-items:center;
        justify-content:center}
    .auth-wrapper{
        width:100%;
        max-width:1100px;
        min-height:620px;
        background:#fff;
        display:grid;
        grid-template-columns:1fr 1fr;
        box-shadow:0 5px 25px rgba(0,0,0,.1);
        border-radius:4px;
        overflow:hidden}
    .brand-side{
        background:#e31837;
        display:flex;
        align-items:center;
        justify-content:center;
        padding:50px;
        color:#fff;
        text-align:center}
    .brand-content{max-width:380px}
    .logo{
        font-size:48px;
        font-weight:900;
        letter-spacing:2px;
        margin-bottom:12px}
    .logo-line{
        width:70px;
        height:4px;
        background:#fff;
        margin:0 auto 25px}
    .brand-content h2{
        font-size:28px;
        margin:0 0 15px;
        font-weight:700}
    .brand-content p{
        font-size:16px;
        line-height:1.7;
        margin:0;color:#fff}
    .book-symbol{
        font-size:70px;
        margin-bottom:20px}
    .form-side{
        padding:55px 70px;
        display:flex;
        align-items:center}
    .form-container{
        width:100%;
        max-width:400px;
        margin:auto}
    .form-container h1{
        font-size:28px;
        color:#222;
        text-align:center;
        margin:0 0 8px}
    .subtitle{
        text-align:center;
        color:#777;
        font-size:14px;
        margin:0 0 28px}
    .alert{
        padding:12px 14px;
        background:#fff1f1;
        border-left:4px solid #e31837;
        color:#c41430;
        font-size:14px;
        margin-bottom:18px;
        border-radius:3px}
    .form-group{
        margin-bottom:18px}
    .form-group label{
        display:block;
        font-size:14px;
        font-weight:600;
        color:#333;
        margin-bottom:8px}
    .input{
        width:100%;
        height:46px;
        border:1px solid #d5d5d5;
        border-radius:3px;
        padding:0 13px;
        font-size:14px;
        outline:none;
        transition:.2s}
    .input:focus{
        border-color:#e31837;box-shadow:0 0 0 2px rgba(227,24,55,.08)}
    .inline-actions{
        display:flex;justify-content:flex-end;margin-top:-5px;margin-bottom:22px}
    .link-btn{
        color:#e31837;text-decoration:none;font-size:13px;font-weight:600}
    .primary-btn{
        width:100%;
        height:48px;
        border:0;
        border-radius:3px;
        background:#e31837;
        color:#fff;
        font-size:16px;
        font-weight:700;
        cursor:pointer;
        transition:.2s}
    .primary-btn:hover{
        background:#c91430}
    .switch-box{
        text-align:center;
        font-size:14px;
        color:#666;
        margin-top:22px}
    .switch-box a{
        color:#e31837;
        text-decoration:none;
        font-weight:700}
    .home-link{
        display:block;
        text-align:center;
        margin-top:18px;
        color:#777!important;
        font-size:13px!important;
        font-weight:400!important}
    .home-link:hover{
        color:#e31837!important}
    .divider{
        display:flex;
        align-items:center;
        gap:12px;margin:25px 0 0;
        color:#aaa;
        font-size:12px}
    .divider:before,.divider:after{
        content:"";
        height:1px;
        background:#e5e5e5;
        flex:1}
    @media(
        max-width:768px){
    body{
        padding:15px}
    .auth-wrapper{
        display:block;
        min-height:auto}
    .brand-side{
        padding:30px 20px}
    .book-symbol{
        font-size:45px;
        margin-bottom:8px}
    .logo{
        font-size:34px}
    .logo-line{
        margin-bottom:15px}
    .brand-content h2{
        font-size:21px}
    .brand-content p{
        font-size:14px}
    .form-side{
        padding:35px 25px}
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
<p>Chào mừng bạn đến với hệ thống bán sách trực tuyến của Nhà xuất bản Kim Đồng.</p>
</div>
</div>
<div class="form-side">
<div class="form-container">
<h1>Đăng nhập</h1>
<p class="subtitle">Đăng nhập để tiếp tục mua sắm</p>

@if(session('success'))
<div class="alert">{{ session('success') }}</div>
@endif

@if($errors->any())
<div class="alert">{{ $errors->first() }}</div>
@endif

<form method="POST" action="{{ route('login.store') }}">
@csrf
<div class="form-group">
<label for="email">Địa chỉ email</label>
<input id="email" class="input" type="email" name="email" value="{{ old('email') }}" placeholder="Nhập địa chỉ email">
</div>

<div class="form-group">
<label for="password">Mật khẩu</label>
<input id="password" class="input" type="password" name="password" placeholder="Nhập mật khẩu">
</div>

<div class="inline-actions">
<a href="{{ route('password.request') }}" class="link-btn">Quên mật khẩu?</a>
</div>

<button class="primary-btn" type="submit">Đăng nhập</button>
</form>

<div class="switch-box">
Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký ngay</a>
</div>

<div class="divider">KIM ĐỒNG</div>

<a href="{{ route('customer.home') }}" class="switch-box home-link">← Về trang chủ</a>
</div>
</div>
</div>
</body>
</html>