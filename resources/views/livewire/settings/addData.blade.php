<section class="w-full">
    @include('partials.settings-heading')



    <!-- Occupation Management -->
    <x-settings.layout :heading="__('Manage Occupation')" :subheading="__('Add, Edit, or Remove Data')">
        <div class="my-6 w-full space-y-6">
            {{-- Occupation Dropdown --}}
            <flux:select wire:model.live="selectedFacultyId" label="Select Occupation" >
                <flux:select.option value="">Select Occupation to edit</flux:select.option>
                @foreach ($faculties as $faculty)
                    <flux:select.option value="{{ $faculty->id }}">{{ $faculty->name }}</flux:select.option>
                @endforeach
            </flux:select>

            {{-- Faculty Input --}}
            <flux:field>
                <flux:input wire:model="facultyName"
                            label="Occupation Name"
                            placeholder="Enter Occupation name" />
                @error('facultyName')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </flux:field>

            {{-- Faculty Action Buttons --}}
            <div class="flex gap-4">
                <flux:button wire:click="saveFaculty" variant="primary" class="w-full" wire:loading.attr="disabled">
                    {{ $selectedFacultyId ? 'Update' : 'Create' }}
                </flux:button>

                @if($selectedFacultyId)
                    <flux:button wire:click="confirmFacultyDelete" variant="danger" class="w-full"
                                wire:loading.attr="disabled">
                        Delete
                    </flux:button>
                @endif
            </div>
        </div>
    {{-- </x-settings.layout>

    <!-- Category Management -->
    <x-settings.layout :heading="__('Manage Categories')" :subheading="__('Add, Edit, or Remove Categories')" class="mt-8"> --}}
        <div class="my-6 w-full space-y-6">
            {{-- Category Dropdown --}}
            <flux:select wire:model.live="selectedCategoryId" label="Select Category" placeholder="Choose a category">
                <flux:select.option value="">Select Category to edit</flux:select.option>
                @foreach ($categories as $category)
                    <flux:select.option value="{{ $category->id }}">{{ $category->name }}</flux:select.option>
                @endforeach
            </flux:select>

            {{-- Category Input --}}
            <flux:field>
                <flux:input wire:model="categoryName"
                            label="Category Name"
                            placeholder="Enter category name" />
                @error('categoryName')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </flux:field>

            {{-- Category Action Buttons --}}
            <div class="flex gap-4">
                <flux:button wire:click="saveCategory" variant="primary" class="w-full" wire:loading.attr="disabled">
                    {{ $selectedCategoryId ? 'Update' : 'Create' }}
                </flux:button>

                @if($selectedCategoryId)
                    <flux:button wire:click="confirmCategoryDelete" variant="danger" class="w-full"
                                wire:loading.attr="disabled">
                        Delete
                    </flux:button>
                @endif
            </div>
        </div>
        <!-- Flash Messages -->
    @if (session()->has('faculty_message'))
        <div x-data="{ show: true }"
             x-show="show"
             x-transition
             x-init="setTimeout(() => show = false, 3000)"
             class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg">
            {{ session('faculty_message') }}
        </div>
    @endif

    @if (session()->has('category_message'))
        <div x-data="{ show: true }"
             x-show="show"
             x-transition
             x-init="setTimeout(() => show = false, 3000)"
             class="fixed bottom-16 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg">
            {{ session('category_message') }}
        </div>
    @endif
    </x-settings.layout>

    {{-- Faculty Confirmation Modal --}}
    @if ($showFacultyConfirmDelete)
        <div class="fixed inset-0 bg-gray-800/60 flex items-center justify-center z-50">
            <div class="bg-white dark:bg-gray-900 p-6 rounded-xl shadow-xl max-w-sm w-full space-y-4">
                <p class="text-lg font-semibold text-gray-900 dark:text-white">Are you sure?</p>
                <p class="text-sm text-gray-700 dark:text-gray-300">This will permanently delete the selected faculty.</p>

                <div class="flex justify-end gap-2 mt-4">
                    <flux:button wire:click="$set('showFacultyConfirmDelete', false)" variant="ghost">Cancel</flux:button>
                    <flux:button wire:click="deleteFaculty" variant="primary">Confirm</flux:button>
                </div>
            </div>
        </div>
    @endif

    {{-- Category Confirmation Modal --}}
    @if ($showCategoryConfirmDelete)
        <div class="fixed inset-0 bg-gray-800/60 flex items-center justify-center z-50">
            <div class="bg-white dark:bg-gray-900 p-6 rounded-xl shadow-xl max-w-sm w-full space-y-4">
                <p class="text-lg font-semibold text-gray-900 dark:text-white">Are you sure?</p>
                <p class="text-sm text-gray-700 dark:text-gray-300">This will permanently delete the selected category.</p>

                <div class="flex justify-end gap-2 mt-4">
                    <flux:button wire:click="$set('showCategoryConfirmDelete', false)" variant="ghost">Cancel</flux:button>
                    <flux:button wire:click="deleteCategory" variant="primary">Confirm</flux:button>
                </div>
            </div>
        </div>
    @endif
</section>
