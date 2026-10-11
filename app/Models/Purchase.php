<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $table = 'purchases';
    
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
    
    public funcrion serviceOrder()
    {
        return $this->belongsTo(ServiceOrder::class, 'service_order_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
