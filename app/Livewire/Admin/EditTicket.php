<?php

namespace App\Livewire\Admin;

use App\Models\Faculty;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EditTicket extends Component
{
    public Ticket $ticket;
    public string $status;
    public string $note = '';

    public function mount(Ticket $ticket)
    {
        // Restrict edit access to assigned admin only
        if (!$ticket->assignment || $ticket->assignment->assigned_to !== Auth::id()) {
            // Optionally, you can redirect or show an error message
            session()->flash('error', 'You are not authorized to edit this ticket.');
            // return redirect()->back();
            abort(403, 'Unauthorized');
        }

        $this->ticket = $ticket;
        $this->status = $ticket->status;
        $this->note = $ticket->assignment->note ?? '';
    }

    public function save()
    {
        $this->validate([
            'status' => 'required|in:done,rejected',
            'note' => 'nullable|string',
        ]);

        $this->ticket->update([
            'status' => $this->status,
            'resolved_at' => now(),
        ]);

        $this->ticket->assignment->update([
            'note' => $this->note,
            'result' => $this->status,
            'finished_at' => now(),
        ]);


        session()->flash('success', 'Ticket updated successfully.');
    }

    public function render()
    {
        return view('livewire.admin.edit-ticket');
    }
}

