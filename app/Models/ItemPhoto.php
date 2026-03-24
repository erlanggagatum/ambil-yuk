<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemPhoto extends Model
{
    protected $fillable = ['item_id', 'path', 'order'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
