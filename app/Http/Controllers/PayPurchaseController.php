<?php

namespace App\Http\Controllers;

use App\Models\PayPurchase;
use App\Models\Purchase;
use App\Models\PurchaseDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayPurchaseController extends Controller
{

    public function index()
    {
        //
    }


    public function create()
    {
        //
    }


    public function store(Request $request,$id)
    {
        $purchaseDetails = PurchaseDetails::where('purchase_id', $id)->get();
        $amountPaid = $request->input('amount-paid');
        $newPaid = PurchaseDetails::where('purchase_id', $id)->sum('paid');
        $newRemainder = PurchaseDetails::where('purchase_id', $id)->sum('remainder');
        $totalPaid = $amountPaid + $newPaid;
        foreach ($purchaseDetails as $index => $detail) {
            if ($totalPaid <= 0) {
                break;
            }
            if ($detail->remainder == 0) {
                $paymentToApply = $totalPaid;
                $detail->paid = $paymentToApply;
                $detail->save();
                $totalPaid -= $paymentToApply;
            } else {
                $paymentToApply = min($detail->remainder, $totalPaid);
                $detail->paid += $paymentToApply;
                $detail->save();
                $totalPaid -= $paymentToApply;
            }
            if ($totalPaid <= 0) {
                break;
            }
            if ($totalPaid > 0) {
                return redirect()->route('purchase.index')
                    ->with('status', 'Some balance remains unpaid.');

            }
        return response()->json(['message' => 'Payments updated successfully.']);
    }
        $payment = PayPurchase::create([
           'supplier_id' => $request->input('supplier_id'),
           'bill_number' => $request->input('bill_number'),
          'paid-amount' => $request->input('amount-paid'),
            'payment-method' => $request->input('payment-method'),
            'remaining-balance' => $request->input('remaining-balance'),

        ]);
      return redirect()->route('purchase.index');
    }
    public function show($id)
    {$payPurchase = PurchaseDetails::where('purchase_id', $id)->first();
        $totalPaid = PurchaseDetails::where('purchase_id', $id)->sum('paid');
        $totalremainder = PurchaseDetails::where('purchase_id', $id)->sum('remainder');
        $total = PurchaseDetails::where('purchase_id', $id)->sum('total');
        $purchase=Purchase::find($id);
        return view('purchase.paypurchase',compact('payPurchase','purchase','totalPaid','totalremainder','total'));
    }
    public function edit(PayPurchase $payPurchase)
    {
        //
    }

    public function update(Request $request, $id)
    {

      //  return $request;
        if ($request->remaining_balance == 0) {

            $purchase = Purchase::find($id);


            $purchase->update([
                'type_payment' => 'تم الدفع',
            ]);
        }


        $purchaseDetails = PurchaseDetails::where('purchase_id', $id)->get();


        $amountPaid = $request->amountpaid;
        $paidSoFar = 0;

        foreach ($purchaseDetails as $purchaseDetail) {
            $paid = $purchaseDetail->paid;
            $total = $purchaseDetail->total;


            $newPaid = $paid + $amountPaid;
            $newRemainder = $total - $newPaid;
            if ($newRemainder < 0) {
                $purchaseDetail->paid = $total;
                $amountPaid = abs($newRemainder);
                $newRemainder = 0;
            } else {
                $purchaseDetail->paid = $newPaid;
                $amountPaid = 0;
            }
            $dateOfPay = $newRemainder == 0 ? now() : $request->date_of_pay;
            $purchaseDetail->update([
                'paid' => $purchaseDetail->paid,
                'date_of_pay' => $dateOfPay,
            ]);
            if ($amountPaid == 0) {
                break;
            }
        }
        return redirect()->route('purchase.index')->with('message', 'Purchase details updated successfully!');
    }

    public function destroy(PayPurchase $payPurchase)
    {

    }
    }

