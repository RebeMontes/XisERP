<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryMovement extends Model
{
    protected $table = 'inventory_movements';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function serviceOrder()
    {
        return $this->belongsTo(ServiceOrder::class, 'service_order_id');
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
