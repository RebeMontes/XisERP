<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    protected $table = 'domains';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];
}
