<?php

namespace App\Livewire\Admin;

use App\Models\Ticket;
use Livewire\Component;
use Livewire\WithPagination;

class TicketTable extends Component
{
    use WithPagination;

    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    public function sort($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    #[\Livewire\Attributes\Computed]
    public function tickets()
    {
        return Ticket::with('user', 'faculty')
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);
    }


    public function render()
    {
        return view('livewire.admin.ticket-table');
    }
}
