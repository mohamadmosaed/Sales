<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LastBills extends Controller
{

    public function index()
    {
       $bill= Bill::latest()->first();
      $billDetails = BillDetails::where('bill_id', $bill->id)->get(); // عرض صفحة الفاتورة مع البيانات
      return view('bill.show', compact('bill', 'billDetails'));

    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }
    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
