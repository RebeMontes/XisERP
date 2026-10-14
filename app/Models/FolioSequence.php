<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FolioSequence extends Model
{
    protected $table = 'folio_sequences';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];
}
