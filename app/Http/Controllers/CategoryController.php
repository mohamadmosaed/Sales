<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Sub_Brand;
use App\Models\Sub_Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $category=Category::get();
        return view("category.index",compact('category'));

    }


    public function create()
    {
        return view("category.create");
    }
    public function store(Request $request)
    {
        // التحقق من صحة البيانات
        $validatedData = $request->validate([
            'category_ar.*' => 'required|string|max:255',
            'category_en.*' => 'required|string|max:255',
        ]);

        // إدخال البيانات في قاعدة البيانات
        foreach ($validatedData['category_ar'] as $index => $categoryAr) {
            Category::create([
                'category_ar' => $categoryAr,
                'category_en' => $validatedData['category_en'][$index],
            ]);
        }

        return redirect()->route('category.index')->with('success', 'تمت إضافة العلامات التجارية بنجاح!');
    }

    public function show($id)
    {
        $category=Category::findOrFail($id);
return view('category.edit',compact('category'));
    }


    public function edit(Category $category)
    {

    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'category_ar' => 'required',
            'category_en' => 'required',
        ]);

        $category->update([
            'category_ar' => $request->category_ar,
            'category_en' => $request->category_en,
        ]);

        return redirect()->route('category.index')->with('success', 'تم تحديث الفئة بنجاح.');
    }
    public function destroy($id)
    {
        DB::table("categories")->where('id',$id)->delete();

        return redirect()->route('category.index')

                        ->with('success','category deleted successfully');
    }
}
