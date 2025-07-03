<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    protected $fillable = [
        'ticket_number',
        'category',
        'priority',
        'site_link',
        'faculty_name',
        'email',
        'attachment',
        'status',
        'description',
    ];

    public function assignment()
    {
        return $this->hasOne(TicketAssignment::class)->latestOfMany();
    }


    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function ticketAssignments()
    {
        return $this->hasMany(TicketAssignment::class);
    }
}
