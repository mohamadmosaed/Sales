<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeStore extends Model
{
    use HasFactory;
    protected $fillable = [
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
    public function supplierMan(){
        return $this->belongsTo(Supplier::class,'supplier_name','id');
    }

        public function transferToBranch($quantity, $storeId)
        {
            if ($this->stock_quantity < $quantity) {
                throw new \Exception('Not enough stock in TypeStore');
            }
            $this->subtractDamagedQuantity($quantity);
            $branch = new Branch();
            $branch->store_id = $storeId;
            $branch->Invoice_date = $this->Invoice_date;
            $branch->Invoice_Number = $this->Invoice_Number;
            $branch->supplier_name = $this->supplier_name;
            $branch->product_serial = $this->product_serial;
            $branch->product_ar = $this->product_ar;
            $branch->product_en = $this->product_en;
            $branch->product_description = $this->product_description;
            $branch->stock_quantity = $quantity; // Set the transferred quantity in Branch
            $branch->Reorder_level = $this->Reorder_level;
            $branch->unit = $this->unit;
            $branch->price = $this->price;
            $branch->barcode = $this->barcode;
            $branch->Status = $this->Status;  // Default to 'active'
            $branch->date_added = $this->date_added;
            $branch->last_update_added = $this->last_update_added;
            $branch->product_date = $this->product_date;
            $branch->expired_date = $this->expired_date;


            $branch->save();

            return $branch;
        }

        public function subtractDamagedQuantity($quantity)
        {
            $this->stock_quantity -= $quantity;
            $this->save();
        }

        public function addStockQuantity($quantity)
        {
            // Add the quantity to TypeStore stock
            $this->stock_quantity -= $quantity;
            $this->save();
        }
    }



