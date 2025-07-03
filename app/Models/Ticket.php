<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;


use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'ticket_number',
        'user_id',
        'category',
        'priority',
        'site_link',
        'faculty_id',
        'attachment',
        'status',
        'description',
        'resolved_at',
    ];

    // In app/Models/Ticket.php
    public function assignment()
    {
        return $this->hasOne(TicketAssignment::class);
    }

    public function assignedTo()
    {
        return $this->hasOneThrough(User::class, TicketAssignment::class, 'ticket_id', 'id', 'id', 'assigned_to');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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
