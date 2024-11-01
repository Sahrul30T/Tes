<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function getOrderDetails(Request $request)
    {
        $orderId = $request->input('orderId');
        $order = Order::with('user', 'products')->find($orderId);

        return view('admin.orders.details', compact('order'));
    }

    public function showOrders()
    {
        $newOrders = Order::where('status', 'new')->get();
        $paidOrders = Order::where('status', 'paid')->get();
        $processedOrders = Order::where('status', 'processed')->get();
        $shippedOrders = Order::where('status', 'shipped')->get();
        $completedOrders = Order::where('status', 'completed')->get();        

        return view('admin.orders.index', compact('newOrders', 'paidOrders', 'processedOrders', 'shippedOrders', 'completedOrders'));
    }

    public function approvePayment($id)
    {
        $order = Order::findOrFail($id);

        // Perform any additional logic for approving payment, if needed

        // Update the order status to "processed" or any other appropriate status
        $order->update(['status' => 'processed']);

        return redirect()->route('admin.orders.index', $order->id)->with('success', 'Pembayaran disetujui.');
    }

    public function updateStatus($id)
    {
        $order = Order::findOrFail($id);

        // Perform any additional logic for updating status, if needed

        // Update the order status to "shipped" or any other appropriate status
        $order->update(['status' => 'shipped']);

        return redirect()->route('admin.orders.index', $order->id)->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function payment($orderId)
    {
        $order = Auth::user()->orders()->findOrFail($orderId);

        return view('user.orders.payment', compact('order'));
    }

    public function uploadPayment(Request $request, $orderId)
    {
        // Ambil data pesanan berdasarkan ID
        $order = Auth::user()->orders()->findOrFail($orderId);

        // Validasi formulir unggah bukti pembayaran
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Simpan bukti pembayaran
        $image = $request->file('payment_proof');
        $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();        
        $paymentProofPath = $image->storeAs('images/payment_proofs', $imageName, 'public');

        // Update status pesanan menjadi "paid" dan simpan path bukti pembayaran
        $order->update([
            'status' => 'paid'            
        ]);

        // Tambahkan data bukti pembayaran ke data pembayaran
        $payment = new Payment([
            'order_id' => $order->id,
            'amount' => $order->total_amount,
            'payment_method' => 'bank_transfer', // Sesuaikan metode pembayaran jika diperlukan
            'proof_of_payment' => $paymentProofPath,
        ]);
        $payment->save();

        return redirect()->route('orders.transactions')->with('success', 'Payment proof uploaded successfully!');
    }

    public function transactions()
    {
        // Ambil semua pesanan pengguna
        $orders = Auth::user()->orders()->latest()->paginate(10);

        return view('user.orders.transactions', compact('orders'));
    }

    public function completeOrder($orderId)
    {
        // Ambil data pesanan berdasarkan ID
        $order = Order::findOrFail($orderId);

        // Update status pesanan menjadi "completed"
        $order->update(['status' => 'completed']);

        return redirect()->route('orders.transactions')->with('success', 'Order completed successfully!');
    }
}
