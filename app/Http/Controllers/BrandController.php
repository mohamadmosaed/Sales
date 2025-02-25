<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrandController extends Controller
{

    public function index()
    {

            $brand=Brand::get();
            return view("brand.index",compact('brand'));
           }


    public function create( )
    {

        return view('brand.create');

    }

    public function store(Request $request)
    {
        if ($request->user()->cannot('create', Brand::class)) {
            abort(403);
        }

        // التحقق من صحة البيانات
        $validatedData = $request->validate([
            'brand_ar.*' => 'required|string|max:255',
            'brand_en.*' => 'required|string|max:255',
        ]);

        // إدخال البيانات في قاعدة البيانات
        foreach ($validatedData['brand_ar'] as $index => $brandAr) {
            brand::create([
                'brand_ar' => $brandAr,
                'brand_en' => $validatedData['brand_en'][$index],
            ]);
        }

        return redirect()->route('brand.index')->with('success', 'تمت إضافة العلامات التجارية بنجاح!');
    }




    public function show($id)
    {
        $brand = Brand::findOrFail($id);

        if (!auth()->user()->can('view', $brand)) {
            return view(('403'));
        }

        return view('brand.show', compact('brand'));
    }

    public function edit($id)
    {
        $brand=Brand::findOrFail($id);
        if(!auth()->user()->can('update',$brand)){
            return view(('403'));
        }
        return view('brand.edit',compact('brand'));

    }





    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);
        $brand->update([
            'brand_ar' => $request->brand_ar,
            'brand_en' => $request->brand_en,
        ]);

        return redirect()->route('brand.index')->with('success', 'تم تحديث العلامة التجارية بنجاح');
    }

    public function destroy( $id)
    {
$brand= DB::table('brands')->where('id',$id);
if(!auth()->user()->can('destory',
$brand)){
    return view(('403'));
}
$brand->delete();
return redirect()->route('brand.index')->with('success','brand is deleted ');
  }


}
