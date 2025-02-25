<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Sub_Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubBrandController extends Controller
{

    public function index()
    {

        $brand=Brand::get();
        $sub_brand=Sub_Brand::get();
        return view("subbrand.index",compact('brand','sub_brand'));
    }

    public function create()
    {
        $brand=Brand::get();
        return view("subbrand.create",compact('brand'));
    }
    public function store(Request $request)
    {
        // التحقق من صحة البيانات
        $validatedData = $request->validate([
            'sub_brand_ar.*' => 'required',
            'sub_brand_en.*' => 'required',
            'brand_id.*' => 'required',

        ]);

        // إدخال البيانات في قاعدة البيانات
        foreach ($validatedData['sub_brand_ar'] as $index => $sub_brandAr) {
            Sub_brand::create([
                'sub_brand_ar' => $sub_brandAr,
                'sub_brand_en' => $validatedData['sub_brand_en'][$index],
                'brand_id' => $validatedData['brand_id'][$index],

            ]);
        }

        return redirect()->route('sub_brand.index')->with('success', 'تمت إضافة العلامات التجارية بنجاح!');
    }



    public function show()
    {
     }
    public function edit($id)
    {
        $item=Sub_Brand::find($id);
        $brand=Brand::get();
return view('subbrand.edit',compact('brand','item'));
     }


    public function update(Request $request,$id)
    {
        //return $request;
        $sub_brand=Sub_Brand::find($id);
        $sub_brand->update([
            'sub_brand_ar'=>$request->sub_brand_ar,
            'sub_brand_en'=>$request->sub_brand_en,
            'brand_id'=>$request->brand_id,
        ]);
        $sub_brand->save();
        return redirect()->route('sub_brand.index');

    }

    public function destroy($id)
    {
        DB::table("sub__brands")->where('id',$id)->delete();

        return redirect()->route('sub_brand.index')

                        ->with('success','sub_brand deleted successfully');

    }
}
