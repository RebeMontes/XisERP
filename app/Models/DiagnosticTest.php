<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiagnosticTest extends Model
{
    protected $table = 'diagnostic_tests';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function serviceOrderDiagnostics()
    {
        return $this->belongsTo(ServiceOrderDiagnostic::class, 'service_order_diagnostic_id');
    }
}
