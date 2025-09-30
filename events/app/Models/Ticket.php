<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'ticket_no',
        'price',
        'event_id'
    ];
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
