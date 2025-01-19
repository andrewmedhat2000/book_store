<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_number',
        'user_id',
        'total_price',
        'status'
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    public function books()
    {
        return $this->belongsToMany(Book::class)->withPivot('quantity', 'price');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Enum for status
    const STATUS_PENDING = 'pending';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';
}
