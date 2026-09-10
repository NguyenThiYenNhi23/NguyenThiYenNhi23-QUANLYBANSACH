<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DonMua;
use App\Models\CTDonMua;
use Illuminate\Support\Facades\Auth;

class CustomerDonMuaController extends Controller
{
    // Hiển thị danh sách đơn hàng
    public function index(Request $request)
    {
        // LƯU Ý: Đổi 'maKhachHang' thành tên cột lưu ID người mua trong DB của bạn (ví dụ: user_id, maDocGia,...)
        $query = DonMua::where('maKhachHang', Auth::id());

        // Lọc theo trạng thái nếu có chọn
        if ($request->filled('trangThai')) {
            $query->where('trangThai', $request->trangThai);
        }

        $donMuas = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('customer.donmua.index', compact('donMuas'));
    }

    // Hiển thị chi tiết đơn hàng
    public function show($id)
    {
        $donMua = DonMua::with(['chiTiets.sach'])
            ->where('maKhachHang', Auth::id())
            ->where('maDonMua', $id)
            ->firstOrFail();

        return view('customer.donmua.show', compact('donMua'));
    }

    // Hủy đơn hàng khi trạng thái là "Chờ duyệt"
    public function cancel($id)
    {
        $donMua = DonMua::where('maKhachHang', Auth::id())
            ->where('maDonMua', $id)
            ->firstOrFail();

        if ($donMua->trangThai !== 'Chờ duyệt') {
            return redirect()->back()->with('error', 'Khách hàng không được phép hủy đơn hàng đã được xác nhận, đang giao hoặc đã giao.');
        }

        try {
            $donMua->trangThai = 'Đã hủy';
            $donMua->save();

            return redirect()->route('customer.donmua.show', $id)
                ->with('success', 'Hủy đơn hàng thành công!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Xảy ra lỗi khi cập nhật trạng thái. Vui lòng thử lại!');
        }
    }
}