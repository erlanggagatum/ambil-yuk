<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'description',
        'stock',
        'harga',
        'status',
    ];

    public function photos()
    {
        return $this->hasMany(ItemPhoto::class)->orderBy('order');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
