<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class  ServiceOrderItem extends Model
{
    protected $table = 'service_order_items';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function serviceOrder()
    {
        return $this->belongsTo(ServiceOrder::class);
    }

    public function orderAsset()
    {
        return $this->belongsTo(OrderAsset::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
