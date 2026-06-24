<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = ['user_id', 'status', 'total', 'customer_name', 'phone', 'address'];

    protected $casts = ['total' => 'decimal:2'];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
