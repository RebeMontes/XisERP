<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    protected $table = 'purchase_items';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function serviceOrderItem()
    {
        return $this->belongsTo(ServiceOrderItem::class, 'service_order_item_id');
    }

    public function serviceOrderAsset()
    {
        return $this->belongsTo(ServiceOrderAsset::class, 'service_order_asset_id');
    }
}
