<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <livewire:admin.ticket-table />
    </div>
    <livewire:admin.ticket-table />
</x-layouts.app>
