<?php

namespace App\Http\Controllers;

use App\Models\ThanhToan;
use Illuminate\Http\Request;

class VnpayMockController extends Controller
{
    public function show(string $maGiaoDich)
    {
        $thanhToan = ThanhToan::where('maGiaoDich', $maGiaoDich)
            ->where('trangThai', 'ChoThanhToan')
            ->first();

        if (!$thanhToan) {
            return redirect()
                ->route('customer.checkout')
                ->with('error', 'Giao dịch VNPay không tồn tại hoặc đã được xử lý.');
        }

        $pending = session('pending_vnpay');

        if (!$pending || ($pending['maGiaoDich'] ?? null) !== $maGiaoDich) {
            return redirect()
                ->route('customer.checkout')
                ->with('error', 'Phiên thanh toán không hợp lệ hoặc đã hết hạn.');
        }

        return view('customer.vnpay', compact('thanhToan', 'pending'));
    }

    public function confirm(Request $request)
    {
        $request->validate([
            'maGiaoDich' => [
                'required',
                'string',
                'exists:thanh_toans,maGiaoDich'
            ],
            'phuongThuc' => [
                'required',
                'in:bank,app'
            ],
            'ketQua' => [
                'required',
                'in:success'
            ],
        ]);

        $thanhToan = ThanhToan::where('maGiaoDich', $request->maGiaoDich)
            ->where('trangThai', 'ChoThanhToan')
            ->first();

        if (!$thanhToan) {
            return redirect()
                ->route('customer.checkout')
                ->with('error', 'Giao dịch không tồn tại hoặc đã được xử lý.');
        }

        $pending = session('pending_vnpay');

        if (!$pending || ($pending['maGiaoDich'] ?? null) !== $thanhToan->maGiaoDich) {
            return redirect()
                ->route('customer.checkout')
                ->with('error', 'Phiên thanh toán không hợp lệ hoặc đã hết hạn.');
        }

        if ($request->phuongThuc === 'bank') {
            $request->validate([
                'bankName' => [
                    'required',
                    'string'
                ],
                'bankPhone' => [
                    'required',
                    'string',
                    'max:15'
                ],
                'account' => [
                    'required',
                    'string'
                ],
                'bankOtp' => [
                    'required',
                    'digits:6'
                ],
            ]);

            // Danh sách 8 ngân hàng hiển thị trên giao diện.
            // Chỉ BIDV và Vietcombank được phép thanh toán trong demo.
            $payableBanks = [
                'Vietcombank',
                'BIDV',
            ];

            if (!in_array($request->bankName, $payableBanks)) {
                return back()
                    ->withInput()
                    ->with('error', 'Ngân hàng này chưa được hỗ trợ thanh toán trong hệ thống demo.');
            }

            if ($request->bankPhone !== '0912345678') {
                return back()
                    ->withInput()
                    ->with('error', 'Số điện thoại ngân hàng không đúng.');
            }

            if ($request->account !== '1234567890') {
                return back()
                    ->withInput()
                    ->with('error', 'Số tài khoản ngân hàng không đúng.');
            }

            if ($request->bankOtp !== '123456') {
                return back()
                    ->withInput()
                    ->with('error', 'Mã OTP ngân hàng không đúng.');
            }
        }

        if ($request->phuongThuc === 'app') {
            $request->validate([
                'walletPhone' => [
                    'required',
                    'string',
                    'max:15'
                ],
                'pin' => [
                    'required',
                    'digits:6'
                ],
                'walletOtp' => [
                    'required',
                    'digits:6'
                ],
            ]);

            if ($request->walletPhone !== '0912345678') {
                return back()
                    ->withInput()
                    ->with('error', 'Số điện thoại Ví VNPAY không đúng.');
            }

            if ($request->pin !== '123456') {
                return back()
                    ->withInput()
                    ->with('error', 'Mã PIN Ví VNPAY không đúng.');
            }

            if ($request->walletOtp !== '123456') {
                return back()
                    ->withInput()
                    ->with('error', 'Mã OTP Ví VNPAY không đúng.');
            }
        }

        $thanhToan->update([
            'phuongThuc' => $request->phuongThuc,
            'trangThai' => 'DaThanhToan',
            'thoiGianThanhToan' => now(),
        ]);

        session()->forget('vnpay_otp_sent');

        return redirect()->route(
            'customer.vnpay.return',
            [
                'maGiaoDich' => $thanhToan->maGiaoDich
            ]
        );
    }

    public function returnPayment(string $maGiaoDich)
    {
        $thanhToan = ThanhToan::where(
            'maGiaoDich',
            $maGiaoDich
        )->first();

        if (!$thanhToan) {
            return redirect()
                ->route('customer.checkout')
                ->with('error', 'Không tìm thấy giao dịch VNPay.');
        }

        if ($thanhToan->trangThai !== 'DaThanhToan') {
            return redirect()
                ->route('customer.checkout')
                ->with('error', 'Giao dịch chưa được thanh toán.');
        }

        return app(CustomerBookController::class)
            ->completeVnpayOrder($thanhToan);
    }
}