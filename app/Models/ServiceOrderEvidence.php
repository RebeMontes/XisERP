<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceOrderEvidence extends Model
{
    protected $table = 'service_order_evidences';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function serviceOrder()
    {
        return $this->belongsTo(ServiceOrder::class, 'service_order_id');
    }

    public function serviceOrderAsset()
    {
        return $this->belongsTo(ServiceOrderAsset::class, 'service_order_asset_id');
    }
}
