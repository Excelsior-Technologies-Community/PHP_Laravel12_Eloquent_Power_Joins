<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $categoryFilter = $request->category_id;

        $products = Product::query()
            ->with('category')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->when($categoryFilter, function ($query) use ($categoryFilter) {
                $query->where('category_id', $categoryFilter);
            })
            ->paginate(10)
            ->withQueryString();

        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        Product::create($request->only(['name', 'price', 'stock', 'category_id']));

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $product = Product::findOrFail($id);
        $product->update($request->only(['name', 'price', 'stock', 'category_id']));

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Product deleted successfully');
    }
}
