<div class="max-w-3xl mx-auto p-6 bg-white dark:bg-gray-900 rounded-xl shadow-lg">
    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">📝 Submit a New Ticket</h2>

    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-2 rounded mb-4">
            ✅ {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-2 rounded mb-4">
            ⚠️ {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-5">
        <!-- Category -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Category</label>
            <select wire:model.defer="category"
                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm">
                <option value="">-- Select a Category --</option>
                @foreach ($categoryOptions as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
            @error('category')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Priority -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Priority</label>
            <flux:radio.group wire:model.defer="priority" label="Select Priority" variant="segmented">
                <flux:radio label="Low" value="low" />
                <flux:radio label="Medium" value="medium" />
                <flux:radio label="High" value="high" />
            </flux:radio.group>
            @error('priority')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Site Link -->
        <div>
            <flux:input wire:model.defer="site_link" type="url" label="Site Link (Optional)" />
            @error('site_link')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Faculty -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Faculty</label>
            <select wire:model.defer="faculty_id"
                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm">
                <option value="">-- Select Faculty --</option>
                @foreach ($faculties as $faculty)
                    <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
                @endforeach
            </select>
            @error('faculty_id')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Attachment -->
        {{-- <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Attachment (Optional)</label>
            <input type="file" wire:model="attachment"
                class="w-full text-sm rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white" />
            @error('attachment')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div> --}}
        <div>
            <flux:input wire:model="attachment" type="file" accept="image/*" />
            @error('attachment')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror

            @if ($attachment)
                attachment Preview:
                <img src="{{ $attachment->temporaryUrl() }}">
            @endif
        </div>

        <!-- Description -->
        <div>
            <flux:textarea wire:model.defer="description" label="Describe the issue" rows="4" />
            @error('description')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Submit -->
        <div class="text-right">
            <button type="submit"
                class="inline-flex items-center px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow transition">
                📨 Submit Ticket
            </button>
        </div>
    </form>
</div>
