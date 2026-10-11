<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceOrderStatusHistory extends Model
{
    protected $table = 'service_order_status_histories';

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
