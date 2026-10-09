<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceOrderAsset extends Model
{
    protected $table = 'service_order_assets';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function serviceOrder()
    {
        return $this->belongsTo(ServiceOrder::class, 'service_order_id');
    }

    public function customerAsset()
    {
        return $this->belongsTo(CustomerAsset::class, 'customer_asset_id');
    }
}
