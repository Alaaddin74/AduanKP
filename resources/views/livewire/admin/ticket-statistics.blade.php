<div class="space-y-10">

    <!-- Welcome Header -->
    <div class="pb-2 border-b border-gray-200 dark:border-gray-700">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Dashboard</h1>
        <p class="text-gray-600 dark:text-gray-400"></p>
    </div>

    <!-- Section: Ticket Overview -->
    <section>
        <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">
            Ticket Overview
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
            @include('components.stats-card', [
                'title' => 'Total Tickets',
                'count' => $totalTickets,
                'subtitle' => 'All time submissions',
                'color' => 'purple',
                'icon' => 'document'
            ])

            @include('components.stats-card', [
                'title' => 'New Tickets',
                'count' => $submittedCount,
                'subtitle' => 'Awaiting review',
                'color' => 'blue',
                'icon' => 'inbox'
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
                'icon' => 'check-circle'
            ])

            @include('components.stats-card', [
                'title' => 'Rejected',
                'count' => $rejectedCount,
                'subtitle' => 'Unable to process',
                'color' => 'red',
                'icon' => 'x-circle'
            ])
        </div>
    </section>

    <!-- Section: Recent Activity -->
    <section>
        <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">
            Recent Activity
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @include('components.stats-card', [
                'title' => "Today's Tickets",
                'count' => $todayTickets,
                'subtitle' => 'New tickets today',
                'color' => 'cyan',
                'icon' => 'calendar'
            ])

            @include('components.stats-card', [
                'title' => 'This Week',
                'count' => $thisWeekTickets,
                'subtitle' => 'Last 7 days',
                'color' => 'teal',
                'icon' => 'trending-up'
            ])

            @include('components.stats-card', [
                'title' => 'Avg Response',
                'count' => $avgResponseTime,
                'subtitle' => 'Hours to first response',
                'color' => 'violet',
                'icon' => 'lightning-bolt'
            ])

            @include('components.stats-card', [
                'title' => 'Resolution Rate',
                'count' => $resolutionRate . '%',
                'subtitle' => 'Success percentage',
                'color' => 'lime',
                'icon' => 'chart-pie'
            ])
        </div>
    </section>

    <!-- Section: Priorities -->
    <section>
        <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">
            Priority Tickets
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @include('components.stats-card', [
                'title' => 'Active Assignments',
                'count' => $activeAssignments,
                'subtitle' => 'Currently assigned',
                'color' => 'indigo',
                'icon' => 'user-group'
            ])

            @include('components.stats-card', [
                'title' => 'Overdue',
                'count' => $overdueCount,
                'subtitle' => 'Need attention',
                'color' => 'pink',
                'icon' => 'clock-alert'
            ])

            {{-- @include('components.stats-card', [
                'title' => 'High Priority',
                'count' => $highPriorityCount,
                'subtitle' => 'Urgent tickets',
                'color' => 'orange',
                'icon' => 'exclamation-triangle'
            ]) --}}
        </div>
    </section>
</div>
