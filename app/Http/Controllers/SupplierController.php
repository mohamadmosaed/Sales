<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{

    public function index()
    {
        $supplier=Supplier::get();
        return view('supplier.index',compact('supplier'));
    }


    public function create()
    {
        return view('supplier.create');
    }

    public function store(Request $request)

    {
        Supplier::create($request->all());

        return redirect()->route('supplier.index')->with('success', 'تم إضافة المورد بنجاح');
    }


    public function show( $id)
    {

        $supplier=Supplier::findOrFail($id);
        return view('supplier.show',compact('supplier'));    }

        public function edit($id)
    {

        $supplier=Supplier::findOrFail($id);
        return view('supplier.edit',compact('supplier'));    }

    public function update(Request $request, Supplier $supplier)
   { $supplier->update($request->all());
    return redirect()->route('supplier.index')->with('success', 'تم تحديث المنتج بنجاح.');
        }

        public function destroy($id)
        {
    DB::table('suppliers')->where('id',$id)->delete();
    return redirect()->route('supplier.index')->with('success','product is deleted');
        }
    }
