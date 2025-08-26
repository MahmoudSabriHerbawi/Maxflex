<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Category::class, 'category');
    }

    public function index(Request $r)
    {
        $categories = Category::when($r->q, fn($q)=>$q->where('name','like',"%{$r->q}%"))
            ->orderBy('name')->paginate(30)->withQueryString();

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create($data);
        return redirect()->route('admin.categories.index')->with('ok','Created');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $r, Category $category)
    {
        $data = $r->validate([
            'name' => 'required|string|max:255|unique:categories,name,'.$category->id,
        ]);

        $category->update($data);
        return redirect()->route('admin.categories.index')->with('ok','Updated');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('ok','Deleted');
    }
}
