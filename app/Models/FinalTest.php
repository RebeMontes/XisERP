<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinalTest extends Model
{
    protected $table = 'final_tests';

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
