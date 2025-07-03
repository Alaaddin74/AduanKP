<div class="w-full overflow-x-auto space-y-6">
    <!-- Filters Section -->
    <div class="p-5 bg-white dark:bg-gray-900 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700">
        <div class="flex flex-wrap items-center gap-4">
            <!-- Search Input -->
            <div class="flex-1 min-w-[250px]">
                <input type="text" wire:model.debounce.300ms="search" placeholder="🔍 Search by ticket number or user"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all" />
            </div>

            <!-- Status Filter -->
            <div class="min-w-[160px]">
                <select wire:model="statusFilter"
                    class="w-full px-4 py-2 border rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500">
                    <option value="">🗂 All Statuses</option>
                    <option value="submitted">📩 Submitted</option>
                    <option value="in_progress">⏳ In Progress</option>
                    <option value="done">✅ Done</option>
                    <option value="rejected">❌ Rejected</option>
                </select>
            </div>

            <!-- Faculty Filter -->
            <div class="min-w-[160px]">
                <select wire:model="facultyFilter"
                    class="w-full px-4 py-2 border rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500">
                    <option value="">🏫 All Faculties</option>
                    @foreach ($faculties as $faculty)
                        <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Additional Search -->
            <div class="flex items-center gap-2 min-w-[250px]">
                <input type="text" wire:model.defer="searchInput" placeholder="🔍 Advanced search"
                    class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500" />
                <button wire:click="applySearch"
                    class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold shadow-sm transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M21 21l-4.35-4.35M10.5 17a6.5 6.5 0 1 0 0-13 6.5 6.5 0 0 0 0 13z" />
                    </svg>
                    Search
                </button>
            </div>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                <!-- Table Header -->
                <thead class="bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 sticky top-0 z-10">
                    <tr>
                        @foreach (['Ticket #', 'User', 'Faculty'] as $label)
                            <th class="px-4 py-3 text-left font-semibold uppercase tracking-wider">
                                {{ $label }}
                            </th>
                        @endforeach

                        @foreach (['assigned_to' => 'Assigned', 'priority' => 'Priority', 'status' => 'Status', 'created_at' => 'Created'] as $field => $label)
                            <th class="px-4 py-3 text-left font-semibold uppercase tracking-wider cursor-pointer hover:text-indigo-600 dark:hover:text-indigo-400 transition"
                                wire:click="sort('{{ $field }}')">
                                <div class="flex items-center gap-1">
                                    {{ $label }}
                                    @if ($sortBy === $field)
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="{{ $sortDirection === 'asc'
                                                    ? 'M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z'
                                                    : 'M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z' }}"
                                                clip-rule="evenodd" />
                                        </svg>
                                    @endif
                                </div>
                            </th>
                        @endforeach

                        <th class="px-4 py-3 text-left font-semibold uppercase tracking-wider">Action</th>
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($this->tickets as $ticket)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition duration-200">
                            <td class="px-4 py-3 whitespace-nowrap font-semibold text-indigo-600 dark:text-indigo-400">
                                #{{ $ticket->ticket_number }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-gray-900 dark:text-gray-100">
                                {{ $ticket->user->name }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                {{ $ticket->faculty->name ?? '-' }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                @if ($ticket->assignment && $ticket->assignment->assignedTo)
                                    <div class="flex items-center gap-2">
                                        <div class="h-8 w-8 rounded-full bg-indigo-200 dark:bg-indigo-900 flex items-center justify-center text-xs font-bold text-indigo-900 dark:text-white">
                                            {{ substr($ticket->assignment->assignedTo->name, 0, 2) }}
                                        </div>
                                        <span>{{ $ticket->assignment->assignedTo->name }}</span>
                                    </div>
                                @else
                                    <span class="px-2 py-0.5 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-xs font-medium">
                                        Unassigned
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="px-2 py-0.5 rounded-full text-xs font-medium capitalize
                                    @if ($ticket->priority === 'high') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                    @elseif ($ticket->priority === 'medium') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                    @else bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 @endif">
                                    {{ $ticket->priority }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="px-2 py-0.5 rounded-full text-xs font-medium capitalize
                                    @switch($ticket->status)
                                        @case('submitted') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 @break
                                        @case('in_progress') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 @break
                                        @case('done') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 @break
                                        @case('rejected') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 @break
                                        @default bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200
                                    @endswitch">
                                    {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-gray-500 dark:text-gray-400">
                                {{ $ticket->created_at->format('M j, Y') }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <a href="{{ route('tickets.show', $ticket->id) }}" wire:navigate
                                    class="inline-flex items-center gap-1 text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <span>View</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400 text-sm">
                                <div class="flex flex-col items-center gap-3">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <p>No tickets found. Try changing filters or keywords.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($this->tickets->hasPages())
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
                {{ $this->tickets->links() }}
            </div>
        @endif
    </div>
</div>
