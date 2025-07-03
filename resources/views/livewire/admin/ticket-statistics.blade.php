<div class="space-y-10">

    <!-- Section: Ticket Overview -->
    <div>
        <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Ticket Overview</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
            @include('components.stats-card', [
                'title' => 'Total Tickets',
                'count' => $totalTickets,
                'subtitle' => 'All time submissions',
                'color' => 'purple',
                'icon' => 'document'
            ])

            @include('components.stats-card', [
                'title' => 'Submitted',
                'count' => $submittedCount,
                'subtitle' => 'Awaiting review',
                'color' => 'blue',
                'icon' => 'plus'
            ])

            @include('components.stats-card', [
                'title' => 'In Progress',
                'count' => $inProgressCount,
                'subtitle' => 'Being worked on',
                'color' => 'amber',
                'icon' => 'clock'
            ])

            @include('components.stats-card', [
                'title' => 'Completed',
                'count' => $doneCount,
                'subtitle' => 'Successfully resolved',
                'color' => 'emerald',
                'icon' => 'check'
            ])

            @include('components.stats-card', [
                'title' => 'Rejected',
                'count' => $rejectedCount,
                'subtitle' => 'Unable to process',
                'color' => 'red',
                'icon' => 'x'
            ])
        </div>
    </div>

    <!-- Section: Activity & Performance -->
    <div>
        <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Activity & Performance</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @include('components.stats-card', [
                'title' => "Today's Activity",
                'count' => $todayTickets,
                'subtitle' => 'Tickets created today',
                'color' => 'cyan',
                'icon' => 'calendar'
            ])

            @include('components.stats-card', [
                'title' => 'This Week',
                'count' => $thisWeekTickets,
                'subtitle' => 'Last 7 days',
                'color' => 'teal',
                'icon' => 'bar-chart'
            ])

            @include('components.stats-card', [
                'title' => 'Avg Response',
                'count' => $avgResponseTime,
                'subtitle' => 'Hours to first response',
                'color' => 'violet',
                'icon' => 'bolt'
            ])

            @include('components.stats-card', [
                'title' => 'Resolution Rate',
                'count' => $resolutionRate . '%',
                'subtitle' => 'Success percentage',
                'color' => 'lime',
                'icon' => 'chart'
            ])
        </div>
    </div>

    <!-- Section: Priorities & Alerts -->
    <div>
        <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Priorities & Alerts</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @include('components.stats-card', [
                'title' => 'High Priority',
                'count' => $highPriorityCount,
                'subtitle' => 'Urgent tickets',
                'color' => 'orange',
                'icon' => 'alert'
            ])

            @include('components.stats-card', [
                'title' => 'Active Assignments',
                'count' => $activeAssignments,
                'subtitle' => 'Currently assigned',
                'color' => 'indigo',
                'icon' => 'users'
            ])

            @include('components.stats-card', [
                'title' => 'Overdue',
                'count' => $overdueCount,
                'subtitle' => 'Need attention',
                'color' => 'pink',
                'icon' => 'clock-alert'
            ])
        </div>
    </div>

</div>
