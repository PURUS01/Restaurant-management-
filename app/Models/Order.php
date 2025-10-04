<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'table_id',
        'restaurant_id',
        'booking_id',
        'total_amount',
        'status',
        'payment_status',
        'payment_method',
        'special_instructions',
        'created_at_order',
        'estimated_ready_time',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'created_at_order' => 'datetime',
        'estimated_ready_time' => 'datetime',
    ];

    /**
     * Get the user that made the order
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the table for this order
     */
    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    /**
     * Get the restaurant for this order
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    /**
     * Get the booking associated with this order
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Get order items for this order
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Check if order is paid
     */
    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    /**
     * Check if order can be cancelled
     */
    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'preparing']);
    }

    /**
     * Scope for pending orders
     */
    public function scopePending($query)
    {
        return $query->whereIn('status', ['pending', 'preparing']);
    }
}