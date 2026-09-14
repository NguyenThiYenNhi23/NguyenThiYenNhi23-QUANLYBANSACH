<?php

namespace App\Http\Controllers;

use App\Models\NhanVien;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class QuanLyNhanVienController extends Controller
{
    // Hiển thị danh sách nhân viên
    public function index(Request $request)
    {
        $keyword = $request->keyword;

        $nhanViens = NhanVien::with('user')
            ->whereHas('user', function ($query) {
                $query->where('role', 'employee');
            })
            ->when($keyword, function ($query) use ($keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('hoTen', 'like', '%' . $keyword . '%')
                        ->orWhere('sdt', 'like', '%' . $keyword . '%')
                        ->orWhere('email', 'like', '%' . $keyword . '%');
                });
            })
            ->orderBy('maNV', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('quantri.ql_nhanvien.nv_index', compact(
            'nhanViens',
            'keyword'
        ));
    }

    // Hiển thị form thêm nhân viên
    public function create()
    {
        return view('quantri.ql_nhanvien.nv_create');
    }

    // Lưu nhân viên mới
    public function store(Request $request)
    {
        $request->validate([
            'hoTen' => 'required|string|max:100',
            'sdt' => 'nullable|string|max:15',
            'email' => 'required|email|max:100|unique:users,email',
            'diaChi' => 'nullable|string|max:255',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'hoTen.required' => 'Vui lòng nhập họ tên.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email đã tồn tại.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
        ]);

        DB::transaction(function () use ($request) {

            $user = new User();

            $user->name = $request->hoTen;
            $user->email = $request->email;
            $user->phone = $request->sdt;
            $user->password = $request->password;
            $user->role = 'employee';
            $user->trang_thai = true;
            $user->save();

            NhanVien::create([
                'user_id' => $user->id,
                'hoTen' => $request->hoTen,
                'sdt' => $request->sdt,
                'email' => $request->email,
                'diaChi' => $request->diaChi,
            ]);
        });

        return redirect()
            ->route('quantri.nhanvien.index')
            ->with('success', 'Thêm nhân viên thành công!');
    }

    // Hiển thị form sửa
    public function edit(NhanVien $nhanVien)
    {
        $nhanVien->load('user');

        return view(
            'quantri.ql_nhanvien.nv_edit',
            compact('nhanVien')
        );
    }

    // Cập nhật nhân viên
    public function update(Request $request, NhanVien $nhanVien)
    {
        $nhanVien->load('user');

        $request->validate([
            'hoTen' => 'required|string|max:100',
            'sdt' => 'nullable|string|max:15',
            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('users', 'email')->ignore($nhanVien->user_id),
            ],
            'diaChi' => 'nullable|string|max:255',
        ], [
            'hoTen.required' => 'Vui lòng nhập họ tên.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email đã tồn tại.',
        ]);

        DB::transaction(function () use ($request, $nhanVien) {

            // Cập nhật bảng users
            $nhanVien->user->name = $request->hoTen;
            $nhanVien->user->email = $request->email;
            $nhanVien->user->phone = $request->sdt;
            $nhanVien->user->save();

            // Cập nhật bảng nhan_viens
            $nhanVien->update([
                'hoTen' => $request->hoTen,
                'sdt' => $request->sdt,
                'email' => $request->email,
                'diaChi' => $request->diaChi,
            ]);
        });

        return redirect()
            ->route('quantri.nhanvien.index')
            ->with('success', 'Cập nhật nhân viên thành công!');
    }

    // Xóa nhân viên
    public function destroy(NhanVien $nhanVien)
    {
        $nhanVien->load('user');

        DB::transaction(function () use ($nhanVien) {

            if ($nhanVien->user) {
                $nhanVien->user->delete();
            } else {
                $nhanVien->delete();
            }
        });

        return redirect()
            ->route('quantri.nhanvien.index')
            ->with('success', 'Xóa nhân viên thành công!');
    }

    // Khóa / mở khóa tài khoản
    public function toggleStatus(NhanVien $nhanVien)
    {
        $nhanVien->load('user');

        if (!$nhanVien->user) {
            return back()->with('error', 'Không tìm thấy tài khoản nhân viên.');
        }

        $nhanVien->user->trang_thai = !$nhanVien->user->trang_thai;
        $nhanVien->user->save();

        $message = $nhanVien->user->trang_thai
            ? 'Đã mở khóa tài khoản nhân viên.'
            : 'Đã khóa tài khoản nhân viên.';

        return back()->with('success', $message);
    }
}