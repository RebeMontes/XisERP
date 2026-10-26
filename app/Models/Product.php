<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    
    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subcategories()
    {
        return $this->belongsTo(Subcategory::class, 'subcategory_id');
    }

    public function brands()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function units()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function taxes()
    {
        return $this->belongsToMany(Tax::class, 'tax_id');
    }
}