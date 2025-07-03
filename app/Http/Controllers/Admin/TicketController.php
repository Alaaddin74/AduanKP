<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $tickets = Ticket::with([
                'user',
                'faculty',
                'assignment.assignedTo' // relasi ke user yang ditugaskan
            ])
            ->latest()
            ->get();

        // Tambahkan nama assigned_to agar bisa dipanggil di blade lewat JavaScript
        $tickets->each(function ($ticket) {
            if ($ticket->assignment && $ticket->assignment->assignedTo) {
                $ticket->assignment->assigned_to_name = $ticket->assignment->assignedTo->name;
            } else {
                $ticket->assignment = (object)[
                    'assigned_to_name' => 'Not Assigned'
                ];
            }
        });

        return view('admin.dashboard', compact('tickets'));
    }
}
