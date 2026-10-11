<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LicenseRenewal extends Model
{
    protected $table = 'license_renewals';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function license()
    {
        return $this->belongsTo(License::class, 'license_id');
    }

    public function serviceOrder()
    {
        return $this->belongsTo(ServiceOrder::class, 'service_order_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
