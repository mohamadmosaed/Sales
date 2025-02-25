<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Sub_Brand;
use App\Models\Sub_Category;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    public function index()
    {
        $product=Product::paginate(10);
        $purchase_price=Product::sum('purchase_price');
        $sell_price=Product::sum('sell_price');
        $final_price_with_tax=Product::sum('final_price_with_tax');
        $brand=Brand::get();
        $subbrand=Sub_Brand::get();
        $category=Category::get();
        $subcategory=Sub_Category::get();
        return view("product.index",compact('brand','subbrand','category','subcategory','product','final_price_with_tax','sell_price','purchase_price'));
    }


        public function create()
    {
        $brand=Brand::get();
        $subbrand=Sub_Brand::get();
        $category=Category::get();
        $subcategory=Sub_Category::get();
        return view("product.create",compact('brand','subbrand','category','subcategory'));
    }

    public function store(Request $request)
    {


        $validate=$request->validate([
            'product_ar'=>'required|unique:products|max:255',
            'product_en'=>'required|unique:products|max:255',

        ]);
        if ($request->hasFile('photo')) {
            $image = $request->file('photo')->getClientOriginalName();
            $path = $request->file('photo')->storeAs('users', $image, 'mohamad');
        } else {
            $path = null;
        }

$product=Product::create([
    'product_ar'=>$request->input('product_ar'),
    'product_en'=>$request->input('product_en'),
    'brand_id'=>$request->input('brand_id'),
    'category_id'=>$request->input('category_id'),
    'sub_category_id'=>$request->input('sub_category_id'),
    'sub_brand_id'=>$request->input('sub_brand_id'),
    'quantity'=>$request->input('quantity'),
    'purchase_price'=>$request->input('purchase_price'),
    'sell_price'=>$request->input('sell_price'),
    'discount'=>$request->input('discount'),
    'tax'=>$request->input('tax'),
    'barcode'=>$request->input('barcode'),
    'product_date'=>$request->input('product_date'),
    'expired_date'=>$request->input('expired_date'),
    'photo'=>$path,

]);
$product->save();
return redirect()->route('product.index')->with('success', 'تم تحديث المنتج بنجاح.');
    }

    public function edit($id)

    {
        $product=Product::findOrFail($id);
        $brand=Brand::get();
        $subbrand=Sub_Brand::get();
        $category=Category::get();
        $subcategory=Sub_Category::get();
        return view("product.edit",compact('brand','subbrand','category','subcategory','product'));
    }

    public function update(Request $request, Product $product)
{

    $request->validate([
        'product_ar' => 'required',
        'product_en' => 'required',
        'photo' => 'image',
    ]);

    $product->update($request->all());

    return redirect()->route('product.index')->with('success', 'تم تحديث المنتج بنجاح.');
}
    public function show($id)
    {
        $product=Product::findOrFail($id);
        $brand=Brand::get();
        $subbrand=Sub_Brand::get();
        $category=Category::get();
        $subcategory=Sub_Category::get();
        return view("product.show",compact('brand','subbrand','category','subcategory','product'));
    }

       public function destroy($id)
    {
DB::table('products')->where('id',$id)->delete();
return redirect()->route('product.index')->with('success','product is deleted');
    }
}
