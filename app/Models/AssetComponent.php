<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetComponent extends Model
{
    protected $table = 'asset_components';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function customerAsset()
    {
        return $this->belongsTo(CustomerAsset::class, 'customer_asset_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function purchaseItem()
    {
        return $this->belongsTo(PurchaseItem::class, 'purchase_item_id');
    }

    public function serviceOrder()
    {
        return $this->belongsTo(ServiceOrder::class, 'service_order_id');
    }
}
