<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceOrderAuthorization extends Model
{
    protected $table = 'service_order_authorizations';

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