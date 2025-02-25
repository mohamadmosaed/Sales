<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\BranchName;
use App\Models\DamagedProduct;
use App\Models\TypeStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DamagedProductController extends Controller
{


    public function recordDamagedProduct(Request $request)
    {

        DB::beginTransaction();
        try {
            $product_id = $request->input('product_id');
            $quantity = $request->input('quantity');
            $product = TypeStore::findOrFail($product_id);
            $damagedProduct = DamagedProduct::create([
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);

            // Subtract the damaged quantity from the product
            $product->subtractDamagedQuantity($quantity);
            DB::commit();
            return redirect()->route('store.index')->with('success', 'Damaged product recorded successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error recording damaged product: ' . $e->getMessage());
            return redirect()->route('store.index')->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function createDamagedProduct(){
        $products=TypeStore::get();
        return view('product.damage',compact('products'));
    }
    public function storeDamagedProduct(Request $request){
      $damage=DamagedProduct::create([
            'product_id'=>$request->product_id,
            'quantity'=>$request->quantity
        ]);
       $damage->save();

    }
    public function indexDamagedProduct(){
$productDamage=DamagedProduct::get();
        return view('store.show',compact('productDamage'));
    }




    public function transferProductToBranch(Request $request)
    {
        $productSerial = $request->input('product_serial');
        $quantity = $request->input('quantity');
        $storeId = $request->input('store_id');

        // Find the product in the TypeStore
        $typeStore = TypeStore::where('product_serial', $productSerial)->first();

        if (!$typeStore) {
            return response()->json(['error' => 'Product not found in TypeStore'], 404);
        }

        // Begin the transaction
        DB::beginTransaction();

        try {
            // Attempt the transfer to the branch
            $branch = $typeStore->transferToBranch($quantity, $storeId);

            // If successful, commit the transaction
            DB::commit();

            // Redirect back with success message
            return redirect()->route('store.index')->with('success', 'التحويل تم بنجاح');
        } catch (\Exception $e) {
            // If an exception occurs, roll back the transaction
            DB::rollBack();

            // Return error response with exception message
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function transferProductBackToStore(Request $request)
    {
      $branch_id=$request->input('branch_id');
        $productSerial = $request->input('product_serial'); // Product serial
        $quantity = $request->input('stock_quantity');     // Quantity to transfer back

        $branch = Branch::where('product_serial', $productSerial)->first();
        $branch_id = Branch::where('id', $branch_id)->first();
        if (!$branch) {
            return response()->json(['error' => 'Product not found in Branch'], 404);
        }

        DB::beginTransaction();

        try {
            // Call the method to transfer product back to TypeStore
            $branch->transferBackToTypeStore($quantity);
            $branch_id->subtractDamagedQuantity($quantity);
            DB::commit();

            // Redirect back with a success message
            return redirect()->route('store.index')->with('success', 'المنتج تم إرجاعه إلى المخزن الرئيسي بنجاح');
        } catch (\Exception $e) {
            // If an error occurs, rollback the transaction
            DB::rollBack();

            // Return error response
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

        public function transfertobranch(){
        $branch=BranchName::get();
        $store=TypeStore::get();
        return view('store.transfer',compact('branch','store'));
    }
    public function transfertostore($id){

        $branch=Branch::where('id',$id)->first();

        return view('store.transfertostore',compact('branch'));
    }
    }



