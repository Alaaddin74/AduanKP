<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketAssignment extends Model
{
    //
    protected $fillable = [
        'ticket_id',
        'assigned_by',
        'assigned_to',
        'assigned_at',
        'finished_at',
        'result',
        'note',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'finished_at' => 'datetime',
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
