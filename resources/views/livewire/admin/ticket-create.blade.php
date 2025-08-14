<div class="max-w-3xl mx-auto p-6 bg-white dark:bg-gray-900 rounded-xl shadow-lg">
    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Formulir Laporan</h2>

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
        <flux:field>
            <flux:input wire:model.defer="name" label="Nama" placeholder="Enter a your name" />
            @error('name')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </flux:field>

        <!-- Faculty -->
        <flux:select wire:model.defer="faculty_id" label="Status" placeholder="Select Status">
            <flux:select.option value="">Select status</flux:select.option>
            @foreach ($faculties as $faculty)
                <flux:select.option value="{{ $faculty->id }}">{{ $faculty->name }}</flux:select.option>
            @endforeach
            @error('faculty_id')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </flux:select>

        <flux:field>
            <flux:input wire:model.defer="no_hp" label="No HP" placeholder="Enter a your phone number" />
            @error('no_hp')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </flux:field>

        <!-- email -->
        <flux:field>
            <flux:input wire:model.defer="email" type="email" label="Email" placeholder="Enter your email" />
            @error('email')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </flux:field>


        <!-- Category -->
        <flux:select wire:model.defer="category" label="Kategori" placeholder="Select a category">
            <flux:select.option value=""> Select a Category </flux:select.option>
            @foreach ($categories as $value => $label)
                <flux:select.option value="{{ $value }}">{{ $label }}</flux:select.option>
            @endforeach
        </flux:select>








        <!-- Site Link -->

        <div>
            <flux:input wire:model.defer="site_link" type="url" label="Link Situs" placeholder="Enter Link" />
            @error('site_link')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <!-- Description -->
        <div>
            <flux:textarea wire:model.defer="description" label="Catatan" rows="4" />
            @error('description')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>


        <div>
            <flux:input wire:model="attachment" type="file" accept="image/*" />
            @error('attachment')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>



        <!-- Attachment small Preview -->
        @if ($attachment)
            <div class="mt-2">
                <span class="text-sm text-gray-600 dark:text-gray-400">Attachment Preview:</span>
            </div>
            {{-- Display a small preview of the attachment --}}
            <div class="mt-2">
                <img src="{{ $attachment->temporaryUrl() }}" class="max-w-xs rounded-md shadow-sm">
            </div>
        @endif

        <!-- Submit -->
        <div class="text-right">
            <button type="submit"
                class="inline-flex items-center px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow transition">
                📨 Submit Ticket
            </button>
        </div>
    </form>
</div>
