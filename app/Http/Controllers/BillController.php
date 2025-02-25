<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillDetails;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Sub_Brand;
use App\Models\Sub_Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillController extends Controller
{

    public function index()
    {
        $brand=Brand::get();
        $sub_brand=Sub_Brand::get();
        $product=Product::get();
        $category=Category::get();
        $sub_category=Sub_Category::get();

        return view('bill.index',compact('sub_category','sub_brand','brand','category','product'));

    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
$paid = 0;
$remain = 0;
if ($request->type === 'cash') {
    $paid = $request->totalg;
    $remain = 0;
} elseif ($request->type === 'later') {
    $paid = 0;
    $remain = $request->totalg;
} else {
    $paid = 0;
    $remain = 0;
}
        DB::beginTransaction();
        try {
            $bill = Bill::create([
                'tel' => $request->tel,
                'address' => $request->address,
                'customer_name' => $request->customer_name,
                'sum_tax' => $request->sum_tax,
                'totalg' => $request->totalg,
                'discount1' => $request->discount1,
                'discount2' => $request->discount2,
                'charge' => $request->charge,
                'type' => $request->type,
                'paid' => $paid,
                'remain' => $remain,
                'bill_notes'=>$request->billNotes,
                'cust_remark'=>$request->cust_remark,

            ]);

            foreach ($request->name as $index => $name) {
                BillDetails::create([
                    'bill_id' => $bill->id,
                    'name' => $name,
                    'quantity' => $request->quantity[$index],
                    'sell_price' => $request->sell_price[$index],
                    'tax' => $request->tax[$index],
                    'discount' => $request->discount[$index],
                    'original_tax' => $request->original_tax[$index],
                    'total' => $request->total[$index],
                ]);
                $product = Product::where('product_ar', $name)->first();
                if ($product) {
                    $product->quantity -= $request->quantity[$index];
                    $product->save();
                }
            }


            DB::commit();
            return redirect()->route('bill.show',$bill->id);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while saving the form data.');
        }
    }

    public function show($id) {
        $bill = Bill::findOrFail($id);
         $billDetails = BillDetails::where('bill_id', $id)->get(); // عرض صفحة الفاتورة مع البيانات
         return view('bill.show', compact('bill', 'billDetails')); }


    public function edit(Bill $bill)
    {
        //
    }


    public function update(Request $request, Bill $bill)
    {
        //
    }


    public function destroy(Bill $bill)
    {
        //
    }
    public function AllBills(){
        return 'ok';
    }
}
