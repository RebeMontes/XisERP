<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkActivity extends Model
{
    protected $table = 'work_activities';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function serviceOrderAsset()
    {
        return $this->belongsTo(ServiceOrderAsset::class, 'service_order_asset_id');
    }
}