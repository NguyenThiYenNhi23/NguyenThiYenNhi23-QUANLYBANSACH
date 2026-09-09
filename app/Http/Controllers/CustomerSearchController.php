<?php

namespace App\Http\Controllers;

use App\Models\Sach;
use Illuminate\Http\Request;

class CustomerSearchController extends Controller
{
    public function index(Request $request)
    {
        $keyword = trim($request->input('q', ''));

        $sachs = Sach::with(['danhMuc', 'tonKho'])
            ->when($keyword !== '', function ($query) use ($keyword) {
                $query->where('tenSach', 'like', '%' . $keyword . '%');
            })
            ->orderBy('tenSach')
            ->get();

        return view('customer.search', compact('sachs', 'keyword'));
    }
}
