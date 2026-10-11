<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function serviceOrder()
    {
        return $this->belongsTo(ServiceOrder::class, 'service_order_id');
    }

    public function receivedBy()
    {
        return $this->belongsTo(User::class, 'received_by_user_id');
    }
}
