<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Manage Faculty')" :subheading="__('Add, Edit, or Remove Faculties')">
        <div class="my-6 w-full space-y-6">

            {{-- Dropdown Selection --}}
            <flux:select wire:model="selectedFacultyId" label="Select Faculty" placeholder="Choose a faculty">
                <flux:select.option value="">-- Select Faculty --</flux:select.option>
                @foreach ($faculties as $faculty)
                    <flux:select.option value="{{ $faculty->id }}">{{ $faculty->name }}</flux:select.option>
                @endforeach
            </flux:select>

            {{-- Text Input for Editing or Adding --}}
            <flux:field>
                <flux:input wire:model.defer="facultyName"
                            label="Faculty Name"
                            id="facultyName"
                            value="{{ $selectedFacultyId ? $selectedFaculty->name : '' }}"
                            placeholder="Enter faculty name" />
                @error('facultyName')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </flux:field>

            {{-- Action Buttons --}}
            <div class="flex gap-4">
                <flux:button wire:click="saveFaculty" variant="primary" class="w-full" wire:loading.attr="disabled">
                    {{ $selectedFacultyId ? 'Update' : 'Create' }}
                </flux:button>

                <flux:button wire:click="confirmDelete" variant="primary" class="w-full"
                             wire:loading.attr="disabled">
                    Delete
                </flux:button>
            </div>
        </div>
    </x-settings.layout>

    {{-- Confirmation Modal --}}
    @if ($showConfirmDelete)
        <div class="fixed inset-0 bg-gray-800/60 flex items-center justify-center z-50">
            <div class="bg-white dark:bg-gray-900 p-6 rounded-xl shadow-xl max-w-sm w-full space-y-4">
                <p class="text-lg font-semibold text-gray-900 dark:text-white">Are you sure?</p>
                <p class="text-sm text-gray-700 dark:text-gray-300">This will permanently delete the selected faculty.</p>

                <div class="flex justify-end gap-2 mt-4">
                    <flux:button wire:click="$set('showConfirmDelete', false)" variant="ghost">Cancel</flux:button>
                    <flux:button wire:click="deleteFaculty" variant="primary">Confirm</flux:button>
                </div>
            </div>
        </div>
    @endif
</section>
