<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::when($request->search, function ($query) use ($request) {
            return $query->whereTranslationLike('name', '%'. $request->search . '%');
        })->latest()->paginate(7);

        return view('dashboard.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('dashboard.categories.create');
    }

    public function store(Request $request)
    {

        $data = $request->validate([
            'ar.*' => 'required|unique:category_translations',
            'en.*' => 'required|unique:category_translations',
        ]);
        Category::create($request->all());

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.categories.index');
    }

    public function edit(Category $category)
    {
        return view('dashboard.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'ar.*' => [
                'required',
                Rule::unique('category_translations')->ignore($category->id, 'category_id'),
            ],

            'en.*' => [
                'required',
                Rule::unique('category_translations')->ignore($category->id, 'category_id'),
            ],

        ]);
        $category->update($request->all());

        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.categories.index');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.categories.index');
    }

} // end of class
