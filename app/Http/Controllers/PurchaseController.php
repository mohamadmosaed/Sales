<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseDetails;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{

    public function index()
    {
        $purchase = Purchase::paginate(10);
$parchaseDetails=PurchaseDetails::get();
return view('purchase.index',compact('purchase','parchaseDetails'));
    }


    public function create()
    {
        $suppliers=Supplier::get();
        return view('purchase.create',compact('suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date_bill_purchase' => 'required|date',
            'supplier_id' => 'required',
            'date_of_pay' => 'required|date',
            'product_ar' => 'required|array',
            'product_en' => 'required|array',
            'quantity' => 'required|array',
            'purchase_price' => 'required|array',
            'discount' => 'required|array',
            'tax' => 'required|array',
            'paid' => 'required|array',
            'product_date' => 'required|array',
            'expired_date' => 'required|array',

        ]);


       DB::beginTransaction();

        try {
            $purchase = Purchase::create([
                'date_bill_purchase' => $request->date_bill_purchase,
                'supplier_id' => $request->supplier_id,
                'date_of_pay' => $request->date_of_pay,
                'bill_number'=>$request->bill_number
            ]);

            foreach ($request->product_ar as $key => $productAr) {
                PurchaseDetails::create([
                    'product_ar' => $productAr,
                    'purchase_id' => $purchase->id,
                    'supplier_id' => $purchase->supplier_id,
                    'product_en' => $request->product_en[$key],
                    'quantity' => $request->quantity[$key],
                    'purchase_price' => $request->purchase_price[$key],
                    'discount' => $request->discount[$key],
                    'tax' => $request->tax[$key],
                    'paid' => $request->paid[$key],
                    'product_date' => $request->product_date[$key],
                    'expired_date' => $request->expired_date[$key],
                ]);
            }

            DB::commit();

            return redirect()->route('purchase.index')->with('success', 'تم حفظ البيانات بنجاح.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors(['error' => 'حدث خطأ أثناء حفظ البيانات. يرجى المحاولة لاحقًا.']);
       }
    }


    public function show($id)
        {


             $purchaseDetails = PurchaseDetails::where('purchase_id',$id)->get();


            return view('purchase.show', compact('purchaseDetails'));  }


    public function edit($id)
        {
//return $id;
            $suppliers=Supplier::get();

        $purchases = PurchaseDetails::where('purchase_id',$id)->get();
        $purchase = Purchase::where('id',$id)->get();

            return view('purchase.edit',compact('suppliers','purchases','purchase'));
    }
    public function update(Request $request,
    )
        {
        //
    }

    public function destroy($id)
        {
        DB::table('purchases')->where('id',$id)->delete();
        return redirect()->route('purchase.index')->with('success','PurchaseBill is deleted successfuly');
    }
}
