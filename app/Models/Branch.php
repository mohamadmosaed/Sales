<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $table = 'branches';
    protected $fillable = [
        'store_id',
        'Invoice_date',
        'Invoice_Number',
        'supplier_name',
        'product_serial',
        'product_ar',
        'product_en',
        'product_description',
        'stock_quantity',
        'Reorder_level',
        'unit',
        'price',
        'barcode',
        'Status',
        'date_added',
        'last_update_added',
        'product_date',
        'expired_date',
    ];

    public function store()
    {
        return $this->belongsTo(TypeStore::class, 'store_id');
    }
    public function branchName()
    {
        return $this->belongsTo(BranchName::class, 'store_id','id');
    }
    protected $dates = [
        'Invoice_date',
        'date_added',
        'last_update_added',
        'product_date',
        'expired_date',
    ];

    protected $attributes = [
        'Status' => 'active',
    ];



    public function transferBackToTypeStore($quantity)
    {

        $branch = TypeStore::where('product_serial', $this->product_serial)->first();

        $store = Branch::where('product_serial', $this->product_serial)->first();

        if ($branch && $store) {

            $branch->stock_quantity += $quantity;
            $store->stock_quantity -= $quantity;

            // Ensure stock_quantity doesn't go below zero in Branch
            if ($store->stock_quantity > 0) {
                throw new \Exception('Not enough stock in Branch to transfer.');
            }

            // Save the updated records
            $branch->save();
            $store->save();
        } else {
            // If record does not exist in TypeStore, create a new record in TypeStore
            $branch = new TypeStore();
            $branch->Invoice_date = $this->Invoice_date;
            $branch->Invoice_Number = $this->Invoice_Number;
            $branch->supplier_name = $this->supplier_name;
            $branch->product_serial = $this->product_serial;
            $branch->product_ar = $this->product_ar;
            $branch->product_en = $this->product_en;
            $branch->product_description = $this->product_description;
            $branch->stock_quantity = $quantity;
            $branch->Reorder_level = $this->Reorder_level;
            $branch->unit = $this->unit;
            $branch->price = $this->price;
            $branch->barcode = $this->barcode;
            $branch->Status = $this->Status;
            $branch->date_added = $this->date_added;
            $branch->last_update_added = $this->last_update_added;
            $branch->product_date = $this->product_date;
            $branch->expired_date = $this->expired_date;

            // Save the new record in TypeStore
            $branch->save();

            // If the product serial exists in Branch, subtract from Branch stock
            if ($store) {
                $store->stock_quantity -= $quantity;

                // Ensure stock_quantity doesn't go below zero in Branch
                if ($store->stock_quantity < 0) {
                    throw new \Exception('Not enough stock in Branch to transfer.');
                }

                // Save the updated Branch record
                $store->save();
            } else {
                // If store record doesn't exist, handle as needed (e.g., throw an error or log a message)
                throw new \Exception('Product not found in Branch to transfer.');
            }
        }

        return $branch;
    }


    public function subtractDamagedQuantity($quantity)
        {
            $this->stock_quantity -= $quantity;
            $this->save();
        }

}

