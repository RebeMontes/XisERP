<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    protected $table = 'licenses';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function customerAsset()
    {
        return $this->belongsTo(CustomerAsset::class, 'customer_asset_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function serviceOrder()
    {
        return $this->belongsTo(ServiceOrder::class, 'service_order_id');
    }
}
