<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Sub_Brand;
use App\Models\Sub_Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubCategoryController extends Controller
{

    public function index()
    {
        $category=Category::get();
        $Sub_category=Sub_Category::get();
        $brand=Brand::get();
        $subbrand=Sub_Brand::get();

        $subcategory=Sub_Category::get();
        return view("subcategory.index",compact('brand','subbrand','category','Sub_category'));


    }


    public function create()
    {
        $category=Category::get();
        return view("subcategory.create",compact('category'));

    }
    public function store(Request $request)
    {
        // التحقق من صحة البيانات
        $validatedData = $request->validate([
            'sub_category_ar.*' => 'required',
            'sub_category_en.*' => 'required',
            'category_id.*' => 'required',

        ]);

        // إدخال البيانات في قاعدة البيانات
        foreach ($validatedData['sub_category_ar'] as $index => $Sub_CategoryAr) {
            Sub_Category::create([
                'sub_category_ar' => $Sub_CategoryAr,
                'sub_category_en' => $validatedData['sub_category_en'][$index],
                'category_id' => $validatedData['category_id'][$index],

            ]);
        }

        return redirect()->route('sub_category.index')->with('success', 'تمت إضافة العلامات التجارية بنجاح!');
    }



    public function show($id)
    {
        $subcategory=Sub_Category::findOrFail($id);
        $categories=Category::get();

return view('subcategory.edit',compact('subcategory','categories'));
    }



    public function edit(Sub_Category $sub_Category)
    {
        //
    }


public function update(Request $request, $id)
{
    $request->validate([
        'sub_category_ar' => 'required',
        'sub_category_en' => 'required',
        'category_id' => 'required',
    ]);

    DB::table("sub__categories")->where('id',$id)->update([
        'sub_category_ar' => $request->sub_category_ar,
        'sub_category_en' => $request->sub_category_en,
        'category_id' => $request->category_id,
    ]);
    return redirect()->route('sub_category.index')->with('success', 'تم تحديث الفئة بنجاح.');
}

    public function destroy($id)
    {
        DB::table("sub__categories")->where('id',$id)->delete();

        return redirect()->route('sub_category.index')

                        ->with('success','category deleted successfully');
    }
}
