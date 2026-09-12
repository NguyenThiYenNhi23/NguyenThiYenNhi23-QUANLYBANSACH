<?php

namespace App\Http\Controllers;

use App\Models\DonHang;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CustomerDonMuaController extends Controller
{
    public function index(Request $request): View
    {
        $customerId = $this->customerId($request);
        $query = DonHang::query()
            ->with(['chiTietDonHangs.sach', 'diaChi', 'phuongThucThanhToan'])
            ->where('maKH', $customerId);

        if ($request->filled('trangThai')) {
            $query->where('trangThai', $request->trangThai);
        }

        $donHangs = $query->orderByDesc('ngayDat')->paginate(10)->withQueryString();

        return view('customer.donmua.index', compact('donHangs'));
    }

    public function show(Request $request, DonHang $donHang): View
    {
        abort_unless((int) $donHang->maKH === $this->customerId($request), 404);

        $donHang->load(['chiTietDonHangs.sach', 'diaChi', 'phuongThucThanhToan']);

        return view('customer.donmua.show', [
            'donHang' => $donHang,
            'addressCount' => DB::table('dia_chis')
                ->where('maKH', $donHang->maKH)
                ->count(),
        ]);
    }

    public function cancel(Request $request, DonHang $donHang): RedirectResponse
    {
        abort_unless((int) $donHang->maKH === $this->customerId($request), 404);

        if ($donHang->trangThai !== 'ChoXacNhan') {
            return back()->with('error', 'Chỉ có thể hủy đơn hàng đang chờ xác nhận.');
        }

        $donHang->update(['trangThai' => 'DaHuy']);

        return redirect()->route('customer.donmua.show', $donHang)
            ->with('success', 'Hủy đơn hàng thành công.');
    }

    private function customerId(Request $request): int
    {
        $user = $request->user();
        $customerId = DB::table('khach_hangs')
            ->where(function ($query) use ($user): void {
                $query->where('email', $user->email)
                    ->orWhere('sdt', $user->phone);
            })
            ->value('maKH');

        abort_unless($customerId, 404, 'Không tìm thấy thông tin khách hàng.');

        return (int) $customerId;
    }
}
