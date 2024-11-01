<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{   
    public function index()
    {   
        if (auth()->guest()) {            
            return back()->with('error', 'Please log in to add products to your cart.');
        }

        $cart = Cart::with('products')->where('user_id', auth()->id())->firstOrFail();        
        
        return view('user.cart.index', compact('cart'));
    }

    public function store(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Periksa apakah pengguna sedang login
        if (auth()->check()) {

            // Cari atau buat cart untuk pengguna saat ini
            $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);
            
            $cartProduct = $cart->products()->where('product_id', $product->id)->first();            

            if ($cartProduct) {
                // Jika produk sudah ada dalam keranjang, update kuantitas
                $quantity = $cartProduct->pivot->quantity;
                $newQuantity = $quantity + $request->input('quantity');            

                $productStock = $cartProduct->stock;            

                if($newQuantity > $productStock){
                    $newQuantity = $productStock;
                }                        

                $cart->products()->updateExistingPivot($product->id, ['quantity' => $newQuantity]);
            } else {
                // Jika produk belum ada dalam keranjang, tambahkan baru
                $cart->products()->attach($product->id, ['quantity' => $request->input('quantity')]);
                
            }        

            return redirect()->route('cart.index')->with('success', 'Product added to cart successfully!');
        } else {
            // Pengguna belum login, berikan respons sesuai kebutuhan Anda (contoh: redirect ke halaman login)
            return back()->with('error', 'Please log in to add products to your cart.');
        }
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Ambil atau buat keranjang untuk pengguna saat ini
        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);

        // Pastikan quantity tidak melebihi stock produk
        if ($request->input('quantity') > $product->stock) {
            return redirect()->route('cart.index')->with('error', 'Quantity cannot exceed available stock!');
        }

        // Synchronize quantity pada pivot table
        $cart->products()->updateExistingPivot($product->id, ['quantity' => $request->input('quantity')]);

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully!');
    }

    public function destroy(Product $product)
    {        
        // Hapus produk dari keranjang pengguna saat ini        
        auth()->user()->cart->products()->detach($product->id);

        return redirect()->route('cart.index')->with('success', 'Product removed from cart successfully!');
    }

    public function cartCount()
    {
        $cartCount = auth()->user()->cart ? auth()->user()->cart->products->count() : 0;        

        return response()->json(['count' => $cartCount]);
    }

    public function checkout()
    {   
        if (auth()->guest()) {
            return back()->with('error', 'Please log in and add products to your cart.');
        }

        // Ambil data keranjang dan user saat ini
        $cart = Auth::user()->cart;

        // Pastikan keranjang tidak kosong
        if (!$cart || $cart->products->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty. Add products before checkout.');
        }

        // Hitung total harga
        $totalPrice = $cart->products->sum(function ($product) {
            return $product->price * $product->pivot->quantity;
        });

        return view('user.cart.checkout', compact('cart', 'totalPrice'));
    }

    public function processCheckout()
    {
        // Ambil data user saat ini
        $user = Auth::user();

        // Pastikan alamat user tidak kosong
        if (empty($user->address)) {
            return redirect()->route('checkout.index')->with('error', 'Please provide your address before checkout.')->with('editAddress', true);
        }

        // Mulai transaksi database
        DB::beginTransaction();        

        try {
            // Ambil data keranjang
            $cart = $user->cart;

            // Pastikan keranjang tidak kosong
            if (!$cart || $cart->products->isEmpty()) {
                return redirect()->route('cart.index')->with('error', 'Your cart is empty. Add products before checkout.');
            }

            // Hitung total harga
            $totalAmount = $cart->products->sum(function ($product) {
                return $product->price * $product->pivot->quantity;
            });

            // Simpan data order
            $order = new Order([
                'user_id' => $user->id,
                'shipping_costs' => 0, // Sesuaikan biaya pengiriman jika diperlukan
                'total_amount' => $totalAmount,
                'status' => 'new', // Sesuaikan status sesuai kebutuhan
            ]);
            $user->orders()->save($order);

            // Attach produk pada order dan kurangi stok
            foreach ($cart->products as $product) {
                $quantity = $product->pivot->quantity;

                // Kurangi stok produk
                $product->decrement('stock', $quantity);

                // Attach produk pada order
                $order->products()->attach($product->id, ['quantity' => $quantity]);
            }

            // Hapus data keranjang
            $cart->products()->detach();
            $cart->delete();

            // Commit transaksi database
            DB::commit();

            return redirect()->route('orders.payment', $order->id)->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            // Rollback transaksi database jika terjadi kesalahan
            DB::rollback();

            return redirect()->route('cart.checkout')->with('error', 'Checkout failed. Please try again.');
        }
    }
}
