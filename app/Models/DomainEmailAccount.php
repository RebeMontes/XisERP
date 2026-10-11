<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DomainEmailAccount extends Model
{
    protected $table = 'domain_email_accounts';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function domain()
    {
        return $this->belongsTo(Domain::class, 'domain_id');
    }
}
