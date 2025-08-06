<?php

namespace App\Livewire\Admin;

use App\Models\Ticket;
use App\Models\TicketAssignment;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class DisplayTicket extends Component
{
    public $ticket;
    public $ticketId;
    public $selectedAdminId = '';
    public $admins;
    public $name, $no_hp, $email;


    public function mount($ticketId)
    {
        $this->ticketId = $ticketId;
        $this->admins = User::where('role', 'admin')->get(); // Assuming you have a User model with a role field
        //  $this->selectedAdminId = $this->admins->first()->id ?? null;
         $this->loadTicket();
    }

    public function loadTicket()
    {
        $this->ticket = Ticket::with([
            'user',
            'faculty',
            'assignment.assignedTo',
            'assignment.assignedBy'
        ])->find($this->ticketId);

        if (!$this->ticket) {
            abort(404, 'Ticket not found');
        }

        $this->name = $this->ticket->name;
        $this->no_hp = $this->ticket->no_hp;
        $this->email = $this->ticket->email;
    }

    public function goBack()
    {
        return redirect()->route('tickets.index'); // Adjust route name as needed
    }

    public function assignToAdmin()
    {
        // Validate that both ticket and admin are selected
        if (!$this->ticket || !$this->selectedAdminId) {
            session()->flash('error', 'Please select an admin to assign the ticket to.');
            return;
        }

        try {
            TicketAssignment::updateOrCreate(
                ['ticket_id' => $this->ticket->id],
                [
                    'assigned_by' => Auth::user()->id,
                    'assigned_to' => $this->selectedAdminId,
                    'assigned_at' => now()
                ]
            );

            Ticket::where('id', $this->ticket->id)->update([
                'status' => 'in_progress', // Update status to in_progress
            ]);

            // Reload the ticket to show updated assignment
            $this->loadTicket();

            // Clear the selection
            $this->selectedAdminId = null;

            // Flash success message
            session()->flash('success', 'Ticket assigned successfully!');
            // $this->dispatchBrowserEvent('notify', ['type' => 'success', 'message' => 'Ticket assigned successfully!']);



            // Dispatch event
            $this->dispatch('ticket-assigned');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to assign ticket. Please try again.');
        }
    }


    public function getSelectedAdminNameProperty()
    {
        return User::find($this->selectedAdminId)?->name;
    }


    public function render()
    {

        return view('livewire.admin.display-ticket');
    }
}
