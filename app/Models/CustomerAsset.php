<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerAsset extends Model
{
    protected $table = 'customer_assets';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subcategories()
    {
        return $this->belongsTo(Subcategory::class, 'subcategory_id');
    }
}
