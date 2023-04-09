<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();

        $products = Product::when($request->search, function ($query) use ($request) {
            return $query->whereTranslationLike('name', '%' . $request->search . '%');

        })->when($request->category_id, function ($q) use ($request) {

            return $q->where('category_id', $request->category_id);

        })->latest()->paginate(7);;


        return view('dashboard.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('dashboard.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ar.name' => 'required',
            'ar.description' => 'required',
            'en.name' => 'required|unique',
            'en.description' => 'required',
            'category_id' => 'required',
            'images' => 'image',
            'buy_price' => 'required',
            'sale_price' => 'required',
            'stock' => 'required',

        ]);

        $data = $request->except(['image']);
        if ($request->image) {
            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })
                ->save(public_path('uploads/products_images/' . $request->image->hashName()));

            $data['image'] = $request->image->hashName();
        }

        Product::create($data);
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.products.index');

    } //end of store


    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('dashboard.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'ar.name' => [
                'required',
                Rule::unique('products_translations', 'name')->ignore($product->id, 'product_id')
            ],
            'en.name' => [
                'required',
                Rule::unique('products_translations', 'name')->ignore($product->id, 'product_id')
            ],
            'ar.description' => 'required',
            'en.description' => 'required',
            'category_id' => 'required',
            'images' => 'image',
            'buy_price' => 'required',
            'sale_price' => 'required',
            'stock' => 'required',

        ]);

        $data = $request->except(['image']);

        if (request()->image) {

            if ($product->image != 'default.png') {

                Storage::disk('public_uploads')->delete('/products_images/' . $product->image);

            }

            if ($request->image) {
                Image::make($request->image)->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                    ->save(public_path('uploads/products_images/' . $request->image->hashName()));

                $data['image'] = $request->image->hashName();
            }
        }

        $product->update($data);
        session()->flash('success', __('site.updated_successfully_successfully'));
        return redirect()->route('dashboard.products.index');

    }

    public function destroy(Product $product)
    {
        if ($product->image != 'default.png') {
            Storage::disk('public_uploads')->delete('/products_images/' . $product->image);
        }

        $product->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.products.index');
    }// end of destroy

} //end of controller
