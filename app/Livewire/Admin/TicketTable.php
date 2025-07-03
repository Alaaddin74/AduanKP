<?php

namespace App\Livewire\Admin;

use App\Models\Ticket;
use App\Models\Faculty;
use Livewire\Component;
use Livewire\WithPagination;

class TicketTable extends Component
{
    use WithPagination;

    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $showTicketModal = false;
    public $selectedTicket = null;

    // Filter properties
    public $search = '';
    public $statusFilter = '';
    public $facultyFilter = '';
    public $searchInput = '';

    // Faculties for dropdown
    public $faculties = [];

    public function mount()
    {
        $this->faculties = Faculty::all();
    }

    public function applySearch()
    {
        $this->search = $this->searchInput;
        $this->resetPage();
    }

    public function updated($property)
    {
        // Reset pagination when filters change
        if (in_array($property, ['search', 'statusFilter', 'facultyFilter'])) {
            $this->resetPage();
        }
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function updatedFacultyFilter()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->searchInput = '';
        $this->statusFilter = '';
        $this->facultyFilter = '';
        $this->resetPage();
    }

    #[\Livewire\Attributes\Computed]
    public function tickets()
    {
        $query = Ticket::with([
            'user',
            'faculty',
            'assignment.assignedTo'
        ]);

        // Apply search filter
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('ticket_number', 'like', '%' . $this->search . '%')
                  ->orWhere('category', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', function ($userQuery) {
                      $userQuery->where('name', 'like', '%' . $this->search . '%')
                               ->orWhere('email', 'like', '%' . $this->search . '%');
                  });
            });
        }

        // Apply status filter
        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        // Apply faculty filter
        if ($this->facultyFilter) {
            $query->where('faculty_id', $this->facultyFilter);
        }

        // Handle sorting
        if ($this->sortBy === 'assigned_to') {
            $query->leftJoin('ticket_assignments', 'tickets.id', '=', 'ticket_assignments.ticket_id')
                  ->leftJoin('users as assigned_users', 'ticket_assignments.assigned_to', '=', 'assigned_users.id')
                  ->select('tickets.*')
                  ->orderBy('assigned_users.name', $this->sortDirection);
        } elseif ($this->sortBy === 'user') {
            $query->join('users', 'tickets.user_id', '=', 'users.id')
                  ->select('tickets.*')
                  ->orderBy('users.name', $this->sortDirection);
        } elseif ($this->sortBy === 'faculty') {
            $query->leftJoin('faculties', 'tickets.faculty_id', '=', 'faculties.id')
                  ->select('tickets.*')
                  ->orderBy('faculties.name', $this->sortDirection);
        } else {
            $query->orderBy($this->sortBy, $this->sortDirection);
        }

        return $query->paginate(10);
    }

    public function sort($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }

    public function viewTicket($ticketId)
    {
        $this->selectedTicket = Ticket::with([
            'user',
            'faculty',
            'assignment.assignedTo'
        ])->find($ticketId);

        $this->showTicketModal = true;
    }

    public function closeTicketModal()
    {
        $this->showTicketModal = false;
        $this->selectedTicket = null;
    }

    // Get statistics for the dashboard cards
    #[\Livewire\Attributes\Computed]
    public function ticketStats()
    {
        $baseQuery = Ticket::query();

        // Apply same filters as main query for consistent stats
        if ($this->search) {
            $baseQuery->where(function ($q) {
                $q->where('ticket_number', 'like', '%' . $this->search . '%')
                  ->orWhere('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', function ($userQuery) {
                      $userQuery->where('name', 'like', '%' . $this->search . '%')
                               ->orWhere('email', 'like', '%' . $this->search . '%');
                  });
            });
        }

        if ($this->statusFilter) {
            $baseQuery->where('status', $this->statusFilter);
        }

        if ($this->facultyFilter) {
            $baseQuery->where('faculty_id', $this->facultyFilter);
        }

        return [
            'total' => $baseQuery->count(),
            'in_progress' => (clone $baseQuery)->where('status', 'in_progress')->count(),
            'completed' => (clone $baseQuery)->where('status', 'done')->count(),
            'high_priority' => (clone $baseQuery)->where('priority', 'high')->count(),
        ];
    }

    public function render()
    {
        return view('livewire.admin.ticket-table');
    }
}
