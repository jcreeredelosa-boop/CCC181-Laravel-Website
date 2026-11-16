<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Show all products
    public function index(Request $request)
    {
    $products = Product::query()
        ->when($request->filled('search'), function ($query) use ($request) {   
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10)
        ->withQueryString();

    return view('products.index', compact('products'));
    }

    // Show the form to add a new product
    public function create()
    {
        return view('products.create');
    }

    // Save a new product with validation and image upload
    public function store(Request $request)
    {
        // Validate product information
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'qty' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Upload product image if provided
        if ($request->hasFile('image')) {

            $imagePath = $request->file('image')
                ->store('products', 'public');

            if (!$imagePath) {
                return back()
                    ->withInput()
                    ->with('error', 'Image upload failed.');
            }

            $validated['image'] = $imagePath;
        }

        // Save product to database
        Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product created successfully!');
    }

    // Show the form to edit an existing product
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);

        return view('products.edit', compact('product'));
    }

    // Update product information and replace image if provided
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        // Validate updated product information
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'qty' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Remember the existing image
        $oldImage = $product->image;

        // Upload new image if provided
        if ($request->hasFile('image')) {

            $newImage = $request->file('image')
                ->store('products', 'public');

            if (!$newImage) {
                return back()
                    ->withInput()
                    ->with('error', 'Image upload failed.');
            }

            $validated['image'] = $newImage;
        }

        // Update product information
        $product->update($validated);

        // Delete old image after successful replacement
        if (isset($validated['image']) && $oldImage) {
            Storage::disk('public')->delete($oldImage);
        }

        return redirect()
            ->route('products.index')
            ->with('success', 'Product updated successfully!');
    }

    // Delete product and its associated image
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        // Delete associated image
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // Delete product from database
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Product deleted successfully!');
    }
}
