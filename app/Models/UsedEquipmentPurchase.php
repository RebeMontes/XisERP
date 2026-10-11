<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsedEquipmentPurchase extends Model
{
    protected $table = 'used_equipment_purchases';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function serviceOrder()
    {
        return $this->belongsTo(ServiceOrder::class, 'service_order_id');
    }
}
