<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'item_id',
        'user_id',
        'status',
        'queue_position',
    ];

    /**
     * Get the item for the booking.
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Get the user for the booking.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
