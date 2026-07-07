<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Traits\BelongsToCompany;

class Order extends Model
{
    use BelongsToCompany;

    protected $fillable = [
        'company_id', 'number', 'customer_name', 'phone', 'address',
        'notes', 'total', 'status'
    ];

    protected $casts = [
        'total' => 'decimal:2'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
