<div class="container mx-auto px-4 py-8 max-w-6xl">
    <div class="bg-white dark:bg-gray-900 shadow rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">Layanan Ticket</h2>

    <div class="flex gap-2">
        <!-- Back Button -->
        <a href="{{ route('tickets.show', $ticket->id) }}"
           class="bg-gray-500 hover:bg-gray-600 text-white text-sm px-4 py-2 rounded-md transition">
            ← Back to Ticket
        </a>

        <!-- Priority Box -->
        <div class="text-sm bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-300 px-4 py-2 rounded">
            Priority: {{ ucfirst($ticket->priority) }}
        </div>
    </div>
</div>


        <p class="text-gray-600 dark:text-gray-400 mb-4">Posted on {{ $ticket->created_at->format('d M Y, H:i') }}</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="text-sm text-gray-600 dark:text-gray-400">Name:</label>
                <p class="text-lg text-gray-800 dark:text-gray-100">{{ $ticket->user->name }}</p>

                <label class="text-sm text-gray-600 dark:text-gray-400 mt-4 block">No ID:</label>
                <p class="text-lg text-gray-800 dark:text-gray-100">{{ $ticket->ticket_number }}</p>

                <label class="text-sm text-gray-600 dark:text-gray-400 mt-4 block">Email:</label>
                <p class="text-lg text-gray-800 dark:text-gray-100">{{ $ticket->user->email }}</p>

                <label class="text-sm text-gray-600 dark:text-gray-400 mt-4 block">Entity:</label>
                <p class="text-lg text-gray-800 dark:text-gray-100">{{ $ticket->faculty->name ?? '-' }}</p>

                <label class="text-sm text-gray-600 dark:text-gray-400 mt-4 block">Link:</label>
                <p class="text-lg text-gray-800 dark:text-gray-100">{{ $ticket->site_link ?? '-' }}</p>

                <label class="text-sm text-gray-600 dark:text-gray-400 mt-4 block">Note:</label>
                <p class="text-lg text-gray-800 dark:text-gray-100 whitespace-pre-wrap">{{ $ticket->description }}</p>

                @if ($ticket->attachment)
                    <label class="text-sm text-gray-600 dark:text-gray-400 mt-4 block">Lampiran:</label>
                    <a href="{{ Storage::url($ticket->attachment) }}" target="_blank">
                        <img src="{{ Storage::url($ticket->attachment) }}" class="w-40 h-auto border rounded shadow mt-2" alt="Attachment Preview">
                    </a>
                @endif
            </div>

            <div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white border-b pb-2 mb-4">Working Result</h3>

                <label class="block text-sm text-gray-700 dark:text-gray-300 mb-2">Result:</label>
                <div class="flex items-center gap-4 mb-4">
                    <label class="inline-flex items-center">
                        <input type="radio" wire:model="status" value="done" class="form-radio text-green-600">
                        <span class="ml-2 text-gray-800 dark:text-gray-100">Done</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" wire:model="status" value="rejected" class="form-radio text-red-600">
                        <span class="ml-2 text-gray-800 dark:text-gray-100">Reject</span>
                    </label>
                </div>

                <label class="block text-sm text-gray-700 dark:text-gray-300 mb-2">Stuff Note:</label>
                <textarea wire:model="note" rows="6" class="w-full px-4 py-2 border rounded-md bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100"></textarea>

                <button wire:click="save"
                    class="mt-6 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md transition-colors">
                    Submit
                </button>



                @if (session()->has('success'))
                    <p class="mt-4 text-green-600 dark:text-green-400">{{ session('success') }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
