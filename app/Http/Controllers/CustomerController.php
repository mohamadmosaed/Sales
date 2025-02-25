<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{

    public function index()
    {
        $customer=Customer::all();
        return view('customer.index',compact('customer'));
    }


    public function create()
    {
        $type=CustomerType::get();
        return view('customer.create',compact('type'));
    }

    public function store(Request $request)
    {
        $customer = new Customer();
        $customer->fill($request->all());
        $customer->save();
        return redirect()->route('customer.index');
    }

    public function show($id)
    {
        $type=CustomerType::get();
        $customer=DB::table('customers')->where('id',$id)->first();
        return view('customer.show',compact('customer','type'));
    }

    public function edit($id)
    {
        $type=CustomerType::get();
        $customer=DB::table('customers')->where('id',$id)->first();
        return view('customer.edit',compact('customer','type'));
    }

       public function update(Request $request, Customer $customer)
    {
        $customer->update($request->all());

        return redirect()->route('customer.index')->with('success', 'تم تحديث المنتج بنجاح.');
        }


    public function destroy($id)
    {
        DB::table('customers')->where('id',$id)->delete();
        return redirect()->route('customer.index')->with('success','customer is deleted');
    }
}
