<section class="w-full">
    @include('partials.settings-heading')
    <x-settings.layout :heading="__('Assign Fakultas')" :subheading="__('Assign Fakultas to Users')">
       <div>
    @if (session()->has('message'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-2">
            {{ session('message') }}
        </div>
    @endif

    <select wire:model="faculty" class="form-select">
        <option value="">-- Select Faculty --</option>
        @foreach ($faculties as $fac)
            <option value="{{ $fac }}">{{ $fac }}</option>
        @endforeach
    </select>

    <button
        wire:click="save"
        class="bg-blue-500 text-white px-4 py-2 mt-3 rounded hover:bg-blue-600">
        Save
    </button>
</div>

    </x-settings.layout>
