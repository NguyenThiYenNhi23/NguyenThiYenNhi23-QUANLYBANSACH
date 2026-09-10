<?php

// filepath: c:\Users\Hello\Laravel\NguyenThiYenNhi23-QUANLYBANSACH\app\Http\Controllers\CustomerAccountController.php

namespace App\Http\Controllers;

use App\Models\DiaChi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class CustomerAccountController extends Controller
{
    public function index(Request $request): View
    {
        $customerId = $this->customerId($request);
        $editingAddress = null;

        if ($customerId && $request->query('edit')) {
            $editingAddress = DiaChi::where('maKH', $customerId)
                ->find($request->query('edit'));
        }

        return view('customer.account', [
            'user' => $request->user(),
            'section' => $request->query('section', 'info'),
            'addresses' => $customerId
                ? DiaChi::where('maKH', $customerId)->orderByDesc('isDefault')->get()
                : collect(),
            'editingAddress' => $editingAddress,
        ]);
    }

    public function storeAddress(Request $request): RedirectResponse
    {
        $customerId = $this->customerId($request);

        if (! $customerId) {
            return back()
                ->withInput()
                ->withErrors(['address' => 'Không tìm thấy thông tin khách hàng của tài khoản này.']);
        }

        $validated = $request->validate([
            'hoTenNguoiNhan' => ['required', 'string', 'max:100'],
            'sdt' => ['required', 'string', 'max:15', 'regex:/^[0-9]+$/'],
            'diaChiChiTiet' => ['required', 'string', 'max:255'],
            'isDefault' => ['nullable', 'boolean'],
        ], [
            'sdt.regex' => 'Số điện thoại chỉ được nhập số.',
        ]);

        $validated['isDefault'] = (bool) ($validated['isDefault'] ?? false);

        if ($validated['isDefault'] || ! DiaChi::where('maKH', $customerId)->exists()) {
            DiaChi::where('maKH', $customerId)->update(['isDefault' => false]);
            $validated['isDefault'] = true;
        }

        DiaChi::create($validated + ['maKH' => $customerId]);

        return redirect()->route('customer.account', ['section' => 'addresses'])
            ->with('success', 'Thêm địa chỉ thành công.');
    }

    public function destroyAddress(Request $request, DiaChi $diaChi): RedirectResponse
    {
        abort_unless((int) $diaChi->maKH === (int) $this->customerId($request), 404);

        if ($diaChi->isDefault) {
            return redirect()->route('customer.account', ['section' => 'addresses'])
                ->with('address_delete_error', 'Không được xóa địa chỉ mặc định. Vui lòng chọn địa chỉ mặc định khác trước khi xóa.');
        }

        $diaChi->delete();

        return redirect()->route('customer.account', ['section' => 'addresses'])
            ->with('success', 'Đã xóa địa chỉ.');
    }

    public function updateAddress(Request $request, DiaChi $diaChi): RedirectResponse
    {
        abort_unless((int) $diaChi->maKH === (int) $this->customerId($request), 404);

        $validated = $request->validate([
            'hoTenNguoiNhan' => ['required', 'string', 'max:100'],
            'sdt' => ['required', 'string', 'max:15', 'regex:/^[0-9]+$/'],
            'diaChiChiTiet' => ['required', 'string', 'max:255'],
            'isDefault' => ['nullable', 'boolean'],
        ], [
            'sdt.regex' => 'Số điện thoại chỉ được nhập số.',
        ]);

        $validated['isDefault'] = $request->boolean('isDefault') || (bool) $diaChi->isDefault;

        if ($validated['isDefault']) {
            DiaChi::where('maKH', $diaChi->maKH)->update(['isDefault' => false]);
            $validated['isDefault'] = true;
        }

        $diaChi->update($validated);

        return redirect()->route('customer.account', ['section' => 'addresses'])
            ->with('success', 'Cập nhật địa chỉ thành công.');
    }

    public function editAddress(Request $request, DiaChi $diaChi): RedirectResponse
    {
        abort_unless((int) $diaChi->maKH === (int) $this->customerId($request), 404);

        return redirect()->route('customer.account', [
            'section' => 'addresses',
            'edit' => $diaChi->maDiaChi,
        ]);
    }

    public function setDefaultAddress(Request $request, DiaChi $diaChi): RedirectResponse
    {
        abort_unless((int) $diaChi->maKH === (int) $this->customerId($request), 404);

        DiaChi::where('maKH', $diaChi->maKH)->update(['isDefault' => false]);
        $diaChi->update(['isDefault' => true]);

        return redirect()->route('customer.account', ['section' => 'addresses'])
            ->with('success', 'Đã đặt địa chỉ mặc định.');
    }

    private function customerId(Request $request): ?int
    {
        $user = $request->user();
        $customerId = DB::table('khach_hangs')
            ->where(function ($query) use ($user): void {
                $query->where('email', $user->email)
                    ->orWhere('sdt', $user->phone);
            })
            ->value('maKH');

        if ($customerId) {
            return (int) $customerId;
        }

        $accountId = DB::table('tai_khoans')
            ->where('tenDangNhap', $user->email)
            ->value('maTK');

        if (! $accountId) {
            $accountId = DB::table('tai_khoans')->insertGetId([
                'tenDangNhap' => $user->email,
                'matKhau' => $user->getAuthPassword(),
                'vaiTro' => $user->role ?? 'customer',
                'trangThai' => true,
            ], 'maTK');
        }

        return (int) DB::table('khach_hangs')->insertGetId([
            'maTK' => $accountId,
            'hoTen' => $user->name,
            'sdt' => $user->phone,
            'email' => $user->email,
        ], 'maKH');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'current_password.current_password' => 'Mật khẩu hiện tại không chính xác.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
            'password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự.',
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()
            ->route('customer.account', ['section' => 'password'])
            ->with('success', 'Đổi mật khẩu thành công.');
    }

    public function logout(Request $request): RedirectResponse
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('customer.home');
    }
}
