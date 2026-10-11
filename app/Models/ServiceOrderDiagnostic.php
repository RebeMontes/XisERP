<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceOrderDiagnostic extends Model
{
    protected $table = 'service_order_diagnostics';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function serviceOrderAsset()
    {
        return $this->belongsTo(ServiceOrderAsset::class, 'service_order_asset_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }
}
