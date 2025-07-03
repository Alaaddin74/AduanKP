<?php

namespace App\Livewire\Admin;

use App\Models\Ticket;
use App\Models\TicketAssignment;
use Carbon\Carbon;
use Livewire\Component;

class TicketStatistics extends Component
{
    // Primary Statistics
    public $totalTickets;
    public $submittedCount;
    public $inProgressCount;
    public $doneCount;
    public $rejectedCount;

    // Time-based Statistics
    public $todayTickets;
    public $thisWeekTickets;
    public $avgResponseTime;
    public $resolutionRate;

    // Priority & Assignment Statistics
    public $highPriorityCount;
    public $activeAssignments;
    public $overdueCount;

    public function mount()
    {
        // Primary Statistics
        $this->totalTickets = Ticket::count();
        $this->submittedCount = Ticket::where('status', 'submitted')->count();
        $this->inProgressCount = Ticket::where('status', 'in_progress')->count();
        $this->doneCount = Ticket::where('status', 'done')->count();
        $this->rejectedCount = Ticket::where('status', 'rejected')->count();

        // Time-based Statistics
        $this->todayTickets = Ticket::whereDate('created_at', Carbon::today())->count();
        $this->thisWeekTickets = Ticket::whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->count();

        // Calculate average response time (in hours)
        $this->avgResponseTime = $this->calculateAverageResponseTime();

        // Calculate resolution rate percentage
        $this->resolutionRate = $this->calculateResolutionRate();

        // Priority & Assignment Statistics
        $this->highPriorityCount = Ticket::where('priority', 'high')->count();
        $this->activeAssignments = TicketAssignment::whereNull('finished_at')->count();
        $this->overdueCount = $this->calculateOverdueTickets();
    }

    private function calculateAverageResponseTime()
    {
        $assignments = TicketAssignment::whereNotNull('assigned_at')->get();

        if ($assignments->isEmpty()) {
            return 0;
        }

        $totalHours = 0;
        $count = 0;

        foreach ($assignments as $assignment) {
            $ticket = $assignment->ticket;
            if ($ticket) {
                $responseTime = $ticket->created_at->diffInHours($assignment->assigned_at);
                $totalHours += $responseTime;
                $count++;
            }
        }

        return $count > 0 ? round($totalHours / $count, 1) : 0;
    }

    private function calculateResolutionRate()
    {
        $totalTickets = Ticket::count();
        $resolvedTickets = Ticket::where('status', 'done')->count();

        return $totalTickets > 0 ? round(($resolvedTickets / $totalTickets) * 100, 1) : 0;
    }

    private function calculateOverdueTickets()
    {
        // Consider tickets overdue if they're in_progress for more than 72 hours
        // or submitted for more than 48 hours
        $overdue = Ticket::where(function($query) {
            $query->where('status', 'in_progress')
                  ->where('created_at', '<', Carbon::now()->subHours(72));
        })->orWhere(function($query) {
            $query->where('status', 'submitted')
                  ->where('created_at', '<', Carbon::now()->subHours(48));
        })->count();

        return $overdue;
    }

    public function render()
    {
        return view('livewire.admin.ticket-statistics');
    }
}
