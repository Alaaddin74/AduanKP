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
    public $selectedAdminId;
    // public $selectedTicket;
    public $admins;

    public function mount($ticketId)
    {
        $this->ticketId = $ticketId;
        $this->loadTicket();
        $this->admins = User::where('role', 'admin')->get(); // Assuming you have a User model with a role field
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


    public function getSelectedAdminNameProperty(){
        return User::find($this->selectedAdminId)?->name;
    }


    public function render()
    {

        return view('livewire.admin.display-ticket');
    }
}
