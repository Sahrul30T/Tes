<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use App\Models\Order;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function datatables()
    {
        $products = Product::with('category')->select(['id', 'name', 'price', 'stock', 'category_id', 'weight']);        

        return DataTables::of($products)
            ->addColumn('action', function ($product) {
                return '<a href="' . route('admin.products.edit', $product->id) . '" class="btn btn-sm btn-info">Edit</a>
                        <button class="btn btn-sm btn-danger btn-delete" data-id="' . $product->id . '" data-url="'. route('admin.products.destroy', $product->id) .'">Delete</button>';
            })
            ->make(true);
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $product = Product::findOrFail($id);

            // Hapus gambar terkait produk dari penyimpanan
            foreach ($product->images as $image) {
                Storage::delete('public/'.$image->image_url);
                $image->delete();
            }

            // Hapus produk
            $product->delete();

            DB::commit();
            return response()->json(['message' => 'Produk Berhasil dihapus.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Terjadi kesalahan saat menghapus produk.']);
        }
    }    

    public function showUploadForm()
    {        
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {        
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'weight' => 'required|numeric',
            'category' => 'required|numeric',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        // Simpan data produk
        $product = new Product([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'price' => $request->get('price'),
            'stock' => $request->get('stock'),
            'weight' => $request->get('weight'),
            'category_id' => $request->get('category'),
        ]);

        $product->save();        

        // Simpan gambar
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('images/products', $imageName, 'public');

                $productImage = new ProductImage([
                    'product_id' => $product->id,
                    'image_url' => $path,
                ]);

                $productImage->save();
            }
        }

        return redirect()->route('admin.products.create')->with('success', 'Data produk berhasil di-upload.');
    }

    public function showEditForm($id)
    {
        $categories = Category::all();
        $product = Product::with('images')->findOrFail($id);

        return view('admin.products.edit', compact('product', 'categories'));
    }  

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'weight' => 'required|numeric',
            'category' => 'required|numeric',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product = Product::findOrFail($id);

        $product->update([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'price' => $request->get('price'),
            'stock' => $request->get('stock'),
            'weight' => $request->get('weight'),
            'category_id' => $request->get('category'),
        ]);

        // Hapus gambar yang dihapus dari database
        if ($request->has('deleted_images')) {
            foreach ($request->input('deleted_images') as $imageId) {

                $imageObj = $product->images()->find($imageId);
                $imagePath = $imageObj->image_url;

                // Delete Image
                Storage::delete('public/'.$imagePath);
                $product->images()->find($imageId)->delete();
            }
        }
        
        // Simpan gambar
        if ($request->hasFile('images')) {

            $limit = $product->images()->count();
            $limit = 5 - $limit;

            $iterationCount = 0;            

            foreach ($request->file('images') as $image) {
                if ($iterationCount >= $limit) {
                    break; // Keluar dari loop jika sudah mencapai batas
                }

                $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('images/products', $imageName, 'public');

                $productImage = new ProductImage([
                    'product_id' => $product->id,
                    'image_url' => $path,
                ]);

                $productImage->save();

                // Tambahkan hitungan iterasi
                $iterationCount++;
            }
        }

        return redirect()->route('admin.products.edit', $product->id)->with('success', 'Data produk berhasil diperbarui.');
    }

    public function index(Request $request)
    {
        $categories = Category::all();
        $selectedCategory = $request->input('category', null);
        
        $productsQuery = Product::query();

        if ($selectedCategory) {
            $productsQuery->where('category_id', $selectedCategory);
        }

        $products = $productsQuery->paginate(8);        

        return view('user.products.index', compact('products', 'categories', 'selectedCategory'));
    }

    public function show($id)
    {   
        $product = Product::findOrFail($id);
        return view('user.products.detail', compact('product'));
    }
    
}
