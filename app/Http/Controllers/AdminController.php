<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Hitung jumlah pesanan baru
        $newOrdersCount = Order::where('status', 'new')->count();

        // Hitung jumlah pesanan selesai
        $completedOrdersCount = Order::where('status', 'completed')->count();

        // Hitung jumlah produk
        $productsCount = Product::count();

        // Tampilkan view dengan data yang dihitung
        return view('admin.dashboard', compact('newOrdersCount', 'completedOrdersCount', 'productsCount'));        
    }

    public function showProducts()
    {
        // Hitung jumlah pesanan baru
        $newOrdersCount = Order::where('status', 'new')->count();

        return view('admin.products.index', compact('newOrdersCount'));
    }                   
    
    public function getNewOrdersCount()
    {
        $newOrdersCount = Order::where('status', 'new')->count();
        return response()->json(['count' => $newOrdersCount]);
    }
    
    public function logout()
    {
        Auth::guard('admin')->logout(); // Logout admin
        return redirect('/admin/login'); // Redirect ke halaman login admin
    }
}
