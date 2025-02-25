<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\TypeStore;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;

class TypeStoreController extends Controller
{

    public function index()
    {
        $store=TypeStore::paginate('10');
        return view('store.index',compact('store'));
    }

    public function create()
    {
        $suppliers=Supplier::get();
       return view('store.create',compact('suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Invoice_date' => 'required|date',
            'Invoice_Number' => 'required|numeric',
            'supplier_name' => 'required|string',
            'product_serial' => 'required|array',
            'product_serial.*' => 'required|string',

        ]);


        $products = [];
        foreach ($request->input('product_serial') as $index => $serial) {
            $products[] = [
                'Invoice_date' => $request->input('Invoice_date'),
                'Invoice_Number' => $request->input('Invoice_Number'),
                'supplier_name' => $request->input('supplier_name'),
                'product_serial' => $serial,
                'product_ar' => $request->input('product_ar')[$index],
                'product_en' => $request->input('product_en')[$index],
                'product_description' => $request->input('product_description')[$index],
                'stock_quantity' => $request->input('stock_quantity')[$index],
                'Reorder_level' => $request->input('Reorder_level')[$index],
                'unit' => $request->input('unit')[$index],
                'price' => $request->input('price')[$index],
                'barcode' => $request->input('barcode')[$index],
                'Status' => $request->input('Status')[$index],
                'date_added' => $request->input('date_added')[$index],
                'last_update_added' => $request->input('last_update_added')[$index],
                'product_date' => $request->input('product_date')[$index],
                'expired_date' => $request->input('expired_date')[$index],
            ];
        }

        // Insert the products into the database (adjust according to your model)
       TypeStore::insert($products);

        return redirect()->route('store.store')->with('success', 'Products added successfully');
    }




    public function show(TypeStore $typeStore)
    {
        //
    }


    public function edit($id)
    {
        $store=TypeStore::findOrFail($id);
        $suppliers=Supplier::get();
        return view('store.edit',compact('store','suppliers'));
    }

        public function update(Request $request, $id)
        {

            $store = TypeStore::findOrFail($id);


            $store->update([
                'Invoice_date' => $request->input('Invoice_date'),
                'Invoice_Number' => $request->input('Invoice_Number'),
                'supplier_name' => $request->input('supplier_id'),
                'product_serial' => $request->input('product_serial'),
                'product_ar' => $request->input('product_ar'),
                'product_en' => $request->input('product_en'),
                'product_description' => $request->input('product_description'),
                'stock_quantity' => $request->input('stock_quantity'),
                'Reorder_level' => $request->input('Reorder_level'),
                'unit' => $request->input('unit'),
                'price' => $request->input('price'),
                'barcode' => $request->input('barcode'),
                'Status' => $request->input('Status'),
                'date_added' => $request->input('date_added'),
                'last_update_added' => $request->input('last_update_added'),
                'product_date' => $request->input('product_date'),
                'expired_date' => $request->input('expired_date'),
            ]);



            return redirect()->route('store.index', $store->id)
                             ->with('success', 'Product updated successfully!');
        }



    public function destroy(TypeStore $typeStore)
    {
        //
    }
}
