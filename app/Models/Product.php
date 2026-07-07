<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Traits\BelongsToCompany;

class Product extends Model
{
    use BelongsToCompany;

    protected $fillable = [
        'company_id', 'category_id', 'name', 'slug', 'description',
        'price', 'old_price', 'available', 'stock', 'badges'
    ];

    protected $casts = [
        'available' => 'boolean',
        'price' => 'decimal:2',
        'old_price' => 'decimal:2',
        'stock' => 'integer',
        'badges' => 'array',
    ];

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('order');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
