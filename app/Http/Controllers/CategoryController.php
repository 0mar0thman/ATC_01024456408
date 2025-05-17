<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view("categories.index", compact("categories"));
    }
    public function sidebar()
    {
        $categorys = Category::all();
        return view("layouts.main-sidebar",  ['categorys' => $categorys]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:categories|max:255',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'اسم التصنيف مطلوب',
            'name.unique' => 'هذا التصنيف موجود بالفعل',
        ]);

        Category::create([
            'name' => $request->name,
            'description' => $request->description ?? 'لا يوجد وصف',
        ]);

        session()->flash('Add', 'تم إضافة التصنيف بنجاح');
        return redirect()->route('categories.index');
    }

    public function create()
    {
        return view('categories.create');
    }


    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
        ], [
            'name.required' => 'اسم التصنيف مطلوب',
            'name.unique' => 'هذا التصنيف موجود بالفعل',
        ]);

        $category->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        session()->flash('edit', 'تم تعديل التصنيف بنجاح');
        return redirect()->route('categories.index');
    }

    public function destroy(Category $category)
    {
        if ($category->events()->count() > 0) {
            session()->flash('error', 'لا يمكن حذف التصنيف لأنه مرتبط بفعاليات');
            return redirect()->route('categories.index');
        }

        $category->delete();
        session()->flash('delete', 'تم حذف التصنيف بنجاح');
        return redirect()->route('categories.index');
    }
}
