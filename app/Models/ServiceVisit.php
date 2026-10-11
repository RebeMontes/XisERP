<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceVisit extends Model
{
    protected $table = 'service_visits';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function serviceOrder()
    {
        return $this->belongsTo(ServiceOrder::class, 'service_order_id');
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }
}
