<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>VNPay - Thanh toán</title>
        <style>
            *{box-sizing:border-box;margin:0;padding:0}
            body{font-family:Arial,Helvetica,sans-serif;background:#f3f5f7;color:#333}
            .header{height:64px;background:#fff;border-bottom:1px solid #e5e5e5;display:flex;align-items:center;padding:0 7%}
            .logo{font-size:30px;font-weight:bold;color:#e31837;letter-spacing:-1px}
            .secure{margin-left:auto;font-size:14px;color:#666}
            .secure span{color:#198754;font-weight:bold}
            .container{max-width:1000px;margin:35px auto;padding:0 20px}
            .payment-box{background:#fff;border-radius:8px;box-shadow:0 3px 15px rgba(0,0,0,.08);overflow:hidden}
            .title{background:#e31837;color:#fff;padding:20px 30px}
            .title h1{font-size:22px;margin-bottom:6px}
            .title p{font-size:14px;opacity:.9}
            .content{display:grid;grid-template-columns:1fr 1.2fr;gap:30px;padding:30px}
            .section-title{font-size:17px;font-weight:bold;margin-bottom:18px;color:#333}
            .info{border:1px solid #e2e2e2;border-radius:6px;overflow:hidden}
            .info-row{display:flex;justify-content:space-between;padding:14px 16px;border-bottom:1px solid #eee;font-size:14px;gap:15px}
            .info-row:last-child{border-bottom:none}
            .info-label{color:#666}
            .info-value{font-weight:600;text-align:right;max-width:65%;word-break:break-word}
            .amount{color:#e31837;font-size:20px;font-weight:bold}
            .error{background:#fff0f0;color:#c62828;border:1px solid #ffcdd2;padding:12px 15px;border-radius:5px;margin-bottom:20px;font-size:14px}
            .success{background:#effaf3;color:#198754;border:1px solid #b7e4c7;padding:12px 15px;border-radius:5px;margin-bottom:20px;font-size:14px}
            .methods{display:flex;flex-direction:column;gap:10px;margin-bottom:22px}
            .method input{display:none}
            .method label{display:flex;align-items:center;gap:14px;border:1px solid #ddd;border-radius:7px;padding:14px 16px;cursor:pointer;background:#fff;transition:.2s}
            .method label:hover{border-color:#e31837}
            .method input:checked+label{border:2px solid #e31837;background:#fff7f8}
            .method-icon{width:42px;height:42px;border-radius:6px;background:#f5f5f5;display:flex;align-items:center;justify-content:center;font-size:21px;flex-shrink:0}
            .method-name{font-weight:bold;margin-bottom:4px}
            .method-desc{font-size:12px;color:#777}
            .payment-panel{border-top:1px solid #eee;padding-top:22px}
            .panel{display:none}
            .panel.active{display:block}
            .panel-title{font-size:16px;font-weight:bold;margin-bottom:15px}
            .form-group{margin-bottom:15px}
            .form-group label{display:block;font-size:14px;font-weight:600;margin-bottom:7px}
            .form-group input,.form-group select{width:100%;height:44px;padding:0 12px;border:1px solid #ccc;border-radius:5px;font-size:14px;outline:none;background:#fff}
            .form-group input:focus,.form-group select:focus{border-color:#e31837}
            .note{font-size:12px;color:#777;margin-top:6px;line-height:1.4}
            .demo-box{background:#f8f9fa;border:1px dashed #bbb;border-radius:6px;padding:11px 14px;margin-bottom:17px;font-size:12px;color:#666}
            .demo-box strong{color:#e31837}
            .buttons{display:flex;gap:10px;margin-top:20px}
            .btn{height:45px;border-radius:5px;padding:0 22px;font-size:14px;font-weight:bold;cursor:pointer;border:none}
            .btn-payment{flex:1;background:#e31837;color:#fff}
            .btn-payment:hover{background:#c91430}
            .btn-cancel{background:#eee;color:#555;text-decoration:none;display:flex;align-items:center;justify-content:center}
            .footer{text-align:center;padding:18px;font-size:12px;color:#888;border-top:1px solid #eee}
            @media(max-width:768px){
            .content{grid-template-columns:1fr}
            .header{padding:0 20px}
            .secure{display:none}
        }
        </style>
    </head>
<body>
    <header class="header">
        <div class="logo">VNPay</div>
        <div class="secure">🔒 <span>Kết nối an toàn</span></div>
    </header>
        <div class="container">
        <div class="payment-box">
        <div class="title">
            <h1>Thanh toán VNPay</h1>
            <p>Cổng thanh toán điện tử VNPay</p>
        </div>
        <div class="content">
            <div>
                <div class="section-title">Thông tin giao dịch</div>
                <div class="info">
                <div class="info-row">
                    <span class="info-label">Mã giao dịch</span>
                    <span class="info-value">{{ $thanhToan->maGiaoDich }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Số tiền thanh toán</span>
                    <span class="info-value amount">{{ number_format($thanhToan->soTien,0,',','.') }} đ</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Đơn vị</span>
                    <span class="info-value">Nhà xuất bản Kim Đồng</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Nội dung</span>
                    <span class="info-value">Thanh toán đơn hàng sách</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Trạng thái</span>
                    <span class="info-value">Chờ thanh toán</span>
                </div>
        </div>
        </div>
        <div>
            <div class="section-title">Chọn phương thức thanh toán</div>
                @if(session('error'))
            <div class="error">{{ session('error') }}</div>
                @endif
                @if(session('success'))
            <div class="success">{{ session('success') }}</div>
                @endif
                <form method="POST" action="{{ route('customer.vnpay.confirm') }}" id="paymentForm">
                @csrf
                <input type="hidden" name="maGiaoDich" value="{{ $thanhToan->maGiaoDich }}">
            <div class="methods">
                <div class="method">
                    <input type="radio" id="bank" name="phuongThuc" value="bank" checked>
                    <label for="bank">
                        <div class="method-icon">🏦</div>
                        <div>
                            <div class="method-name">Thẻ ATM / Tài khoản ngân hàng</div>
                            <div class="method-desc">Chọn ngân hàng và xác thực giao dịch</div>
                        </div>
                     </label>
                 </div>
                <div class="method">
                    <input type="radio" id="app" name="phuongThuc" value="app">
                    <label for="app">
                    <div class="method-icon">💰</div>
                    <div>
                         <div class="method-name">Ví VNPAY</div>
                        <div class="method-desc">Thanh toán bằng tài khoản Ví VNPAY</div>
                    </div>
                    </label>
                </div>
        </div>
            <div class="payment-panel">
                <div class="panel active" id="panel-bank">
                    <div class="panel-title">Thanh toán qua ngân hàng</div>
                    <div class="form-group">
                        <label for="bankName">Chọn ngân hàng</label>
                        <select id="bankName" name="bankName">
                            <option value="">-- Chọn ngân hàng --</option>
                            <option value="Vietcombank">Vietcombank</option>
                            <option value="BIDV">BIDV</option>
                            <option value="VietinBank">VietinBank</option>
                            <option value="Agribank">Agribank</option>
                            <option value="Techcombank">Techcombank</option>
                            <option value="MB Bank">MB Bank</option>
                            <option value="ACB">ACB</option>
                            <option value="VPBank">VPBank</option>
                        </select>
                    </div>
            <div class="form-group">
                <label for="bankPhone">Số điện thoại</label>
                <input type="text" id="bankPhone" name="bankPhone" placeholder="Nhập số điện thoại" maxlength="15">
             </div>
            <div class="form-group">
                <label for="bankAccount">Số tài khoản</label>
                <input type="text" id="bankAccount" name="account" placeholder="Nhập số tài khoản">
                <div class="note">Tài khoản demo: 1234567890</div>
            </div>
             <div class="form-group">
                <label for="bankOtp">Mã OTP</label>
                <input type="text" id="bankOtp" name="bankOtp" placeholder="Nhập mã OTP 6 số" maxlength="6" inputmode="numeric">
                <div class="note">OTP mô phỏng: 123456</div>
            </div>
        </div>
        <div class="panel" id="panel-app">
            <div class="panel-title">Thanh toán bằng Ví VNPAY</div>
            <div class="form-group">
            <label for="walletPhone">Số điện thoại ví</label>
            <input type="text" id="walletPhone" name="walletPhone" placeholder="Nhập số điện thoại Ví VNPAY" maxlength="15">
        </div>
        <div class="form-group">
            <label for="walletPin">Mã PIN</label>
            <input type="password" id="walletPin" name="pin" placeholder="Nhập mã PIN" maxlength="6" inputmode="numeric">
            <div class="note">PIN mô phỏng: 123456</div>
        </div>
        <div class="form-group">
            <label for="walletOtp">Mã OTP</label>
            <input type="text" id="walletOtp" name="walletOtp" placeholder="Nhập mã OTP 6 số" maxlength="6" inputmode="numeric">
            <div class="note">OTP mô phỏng: 123456</div>
        </div>
        </div>
        </div>
        <div class="demo-box">
            <strong>Chế độ mô phỏng:</strong>
            Đây là cổng thanh toán VNPay giả lập phục vụ mục đích demo.
        </div>
        <div class="buttons">
        <a href="{{ route('customer.checkout') }}" class="btn btn-cancel">Hủy thanh toán</a>
        <button type="submit" name="ketQua" value="success" class="btn btn-payment">Xác nhận thanh toán</button>
        </div>
        </form>
        </div>
        </div>
        <div class="footer">VNPay Mock Payment · Hệ thống mô phỏng thanh toán</div>
        </div>
        </div>
<script>
        const methods=document.querySelectorAll('input[name="phuongThuc"]');
        const bankPanel=document.getElementById('panel-bank');
        const appPanel=document.getElementById('panel-app');

        methods.forEach(method=>{
            method.addEventListener('change',function(){
                bankPanel.classList.remove('active');
                appPanel.classList.remove('active');
                if(this.value==='bank') bankPanel.classList.add('active');
                if(this.value==='app') appPanel.classList.add('active');
            });
        });

        document.getElementById('paymentForm').addEventListener('submit',function(e){
            const method=document.querySelector('input[name="phuongThuc"]:checked').value;

            if(method==='bank'){
                const bank=document.getElementById('bankName').value;
                const phone=document.getElementById('bankPhone').value.trim();
                const account=document.getElementById('bankAccount').value.trim();
                const otp=document.getElementById('bankOtp').value.trim();

            if(!bank){
                e.preventDefault();
                alert('Vui lòng chọn ngân hàng.');
                return;
                }
            if(!phone){
                e.preventDefault();
                alert('Vui lòng nhập số điện thoại.');
                return;
            }
            if(!account){
                e.preventDefault();
                alert('Vui lòng nhập số tài khoản.');
                return;
            }
            if(!/^\d{6}$/.test(otp)){
                e.preventDefault();
                alert('Mã OTP phải gồm 6 chữ số.');
                return;
            }
        }
            if(method==='app'){
                const phone=document.getElementById('walletPhone').value.trim();
                const pin=document.getElementById('walletPin').value.trim();
                const otp=document.getElementById('walletOtp').value.trim();

            if(!phone){
                e.preventDefault();
                alert('Vui lòng nhập số điện thoại Ví VNPAY.');
                return;
            }

            if(!/^\d{6}$/.test(pin)){
                e.preventDefault();
                alert('Mã PIN phải gồm 6 chữ số.');
                return;
            }

            if(!/^\d{6}$/.test(otp)){
                e.preventDefault();
                alert('Mã OTP phải gồm 6 chữ số.');
                return;
            }
            }
        });
</script>
</body>
</html>