<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    function index()
    {
        $categories = Category::all();

        return Inertia::render('admin/Categories/index', ['categories' => $categories]);
    }

    function update(Category $category, Request $request)
    {
        $category = $category->update(['name' => $request->name, 'name_cn' => $request->name_cn]);

        return redirect()->back();
    }

    function store(Request $request)
    {

        Category::create(['name' => $request->name, 'name_cn' => $request->name_cn]);

        return redirect()->back();
    }

    function destroy(category $category, Request $request)
    {

        $category->delete();

        return redirect()->back();
    }
}
