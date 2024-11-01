<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Order;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function datatables()
    {
        $categories = Category::select(['id', 'name']);

        return DataTables::of($categories)
            ->addColumn('action', function ($category) {
                return '<a href="' . route('admin.categories.edit', $category->id) . '" class="btn btn-sm btn-info">Edit</a>
                        <button class="btn btn-sm btn-danger btn-delete" data-id="' . $category->id . '" data-url="'. route('admin.categories.destroy', $category->id) .'">Delete</button>';
            })
            ->make(true);
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $category = Category::findOrFail($id);
            $category->delete();

            DB::commit();
            return response()->json(['message' => 'Kategori Berhasil dihapus.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Terjadi kesalahan saat menghapus kategori.']);            
        }
    }
    
    public function showCategoryUploadForm()
    {        
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        // Simpan data kategori
        $category = new Category([
            'name' => $request->get('name'),
        ]);

        $category->save();

        return redirect()->route('admin.categories.create')->with('success', 'Data kategori berhasil di-upload.');
    }

    public function showCategoryEditForm($id)
    {
        $category = Category::findOrFail($id);

        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $category = Category::findOrFail($id);        

        $category->update([
            'name' => $request->get('name'),
        ]);

        return redirect()->route('admin.categories.edit', $category->id)->with('success', 'Data kategori berhasil diperbarui.');
    }

    public function getCategories()
    {
        $categories = Category::all();

        return response()->json(['categories' => $categories]);
    }
}
