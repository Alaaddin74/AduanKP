<div class="container mx-auto px-2 py-4">
    @if ($ticket)
        <!-- Page Header -->
        <div class="mb-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Ticket Details</h1>
                    <p class="mt-1 text-xs text-gray-600 dark:text-gray-400">Ticket #{{ $ticket->ticket_number }}</p>
                </div>
                <button wire:click="goBack"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-1 px-2 rounded-lg transition-colors duration-200 flex items-center">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back
                </button>
            </div>
        </div>

        <!-- Main Content -->
        <div class="bg-white dark:bg-gray-900 shadow-lg rounded-lg overflow-hidden">
            <!-- Header Section -->
            <div class="bg-gray-50 dark:bg-gray-800 px-4 py-2 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                            @if ($ticket->priority === 'high') bg-red-100 text-red-800
                            @elseif($ticket->priority === 'medium') bg-yellow-100 text-yellow-800
                            @else bg-green-100 text-green-800 @endif">
                            {{ ucfirst($ticket->priority) }} Priority
                        </span>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                            @if ($ticket->status === 'open') bg-blue-100 text-blue-800
                            @elseif($ticket->status === 'in_progress') bg-yellow-100 text-yellow-800
                            @elseif($ticket->status === 'resolved') bg-green-100 text-green-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                        </span>
                    </div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">
                        Created: {{ $ticket->created_at->format('d M Y, H:i') }}
                    </div>
                </div>
            </div>

            <!-- Content Section -->
            <div class="px-4 py-4">
                <!-- Basic Information -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    @foreach ([
                        'Ticket Number' => $ticket->ticket_number,
                        'Category' => $ticket->category,
                        'Faculty' => $ticket->faculty ? $ticket->faculty->name : 'Not Specified',
                        'User  Email' => $ticket->user ? $ticket->user->email : 'Not Available',
                        'User  Name' => $ticket->user ? $ticket->user->name : 'Not Available',
                        'Ticket Date' => $ticket->created_at->format('d M Y'),
                    ] as $label => $value)
                        <div class="bg-gray-50 dark:bg-gray-800 p-2 rounded-lg">
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">{{ $label }}</label>
                            <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $value }}</p>
                        </div>
                    @endforeach
                </div>

                <!-- Description -->
                @if ($ticket->description)
                    <div class="mb-4">
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                        <div class="bg-gray-50 dark:bg-gray-800 p-2 rounded-lg">
                            <p class="text-gray-900 dark:text-gray-100 whitespace-pre-wrap">{{ $ticket->description }}</p>
                        </div>
                    </div>
                @endif

                <!-- Assignment Actions -->
                <div class="flex flex-col md:flex-row items-center justify-between w-full mt-4 gap-2">
                    <div class="w-full md:w-1/2">
                        <label for="admin_id" class="block text-xs font-medium text-gray-800 dark:text-gray-200 mb-1">Assign To</label>
                        <div class="relative">
                            <select wire:model.defer="selectedAdminId" id="admin_id"
                                class="block w-full appearance-none rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-2 py-1 text-xs text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                                <option value="">-- Select Admin --</option>
                                @foreach ($admins as $admin)
                                    <option value="{{ $admin->id }}">{{ $admin->name }} ({{ $admin->email }})</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2 text-gray-400 dark:text-gray-500">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-2 mt-2 md:mt-0">
                        <flux:button wire:click="assignToAdmin" variant="primary" color="emerald">
                            Assign
                        </flux:button>
                    </div>
                </div>

                <!-- Flash Messages -->
                @if (session()->has('success'))
                    <div class="bg-green-100 dark:bg-green-900 border border-green-400 text-green-700 dark:text-green-200 px-2 py-1 rounded mb-2 mt-2">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session()->has('error'))
                    <div class="bg-red-100 dark:bg-red-900 border border-red-400 text-red-700 dark:text-red-200 px-2 py-1 rounded mb-2 mt-2">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Assignment Info -->
                @if ($ticket->assignment)
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mt-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Assignment Information</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-blue-50 dark:bg-blue-900 p-2 rounded-lg">
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Assigned To</label>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ $ticket->assignment->assignedTo?->name ?? 'Not Assigned' }}
                                </p>
                            </div>

                            <div class="bg-blue-50 dark:bg-blue-900 p-2 rounded-lg">
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Assigned Date</label>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ $ticket->assignment->assigned_at?->format('d M Y, H:i') ?? 'Not Set' }}
                                </p>
                            </div>

                            <div class="bg-blue-50 dark:bg-blue-900 p-2 rounded-lg">
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Finished Date</label>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ $ticket->assignment->finished_at?->format('d M Y, H:i') ?? 'Not Finished' }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end">
                                <a href="{{ route('admin.tickets.edit', $ticket->id) }}"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition">
                                    Edit Ticket
                                </a>
                            </div>
                @else
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                        <div class="text-center py-4">
                            <svg class="w-8 h-8 text-gray-400 dark:text-gray-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="text-md font-medium text-gray-900 dark:text-white mb-1">No Assignment Yet</h3>
                            <p class="text-gray-500 dark:text-gray-400">This ticket has not been assigned to anyone yet.</p>
                        </div>
                    </div>

                @endif

            </div>
        </div>
    @else
        <!-- Ticket Not Found -->
        <div class="text-center py-8">
            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">Ticket Not Found</h2>
            <p class="text-gray-600 dark:text-gray-400 mb-4">The ticket you're looking for doesn't exist or has been deleted.</p>
            <button wire:click="goBack"
                class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-1 px-2 rounded-lg transition-colors duration-200">
                Back
            </button>
        </div>
    @endif
</div>
