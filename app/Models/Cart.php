<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_amount',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function updateTotal()
    {
        $this->total_amount = $this->items()
            ->join('products', 'cart_items.product_id', '=', 'products.id')
            ->selectRaw('COALESCE(SUM(products.price * cart_items.quantity), 0) as total')
            ->value('total');
        $this->save();
    }
}
