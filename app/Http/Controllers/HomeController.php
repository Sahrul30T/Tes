<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{    
    public function index()
    {           
        // Tambahkan logika atau ambil data yang diperlukan untuk halaman pengguna di sini
        $bestSellers = Product::bestSellers();

        return view('user.home', compact('bestSellers'));
        // return view('layouts.user-app');
    }
}
