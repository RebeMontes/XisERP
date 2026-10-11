<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseTrackingEvent extends Model
{
    protected $table = 'purchase_tracking_events';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }
}
