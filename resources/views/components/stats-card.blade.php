@props(['title', 'count', 'subtitle', 'color' => 'gray', 'icon' => ''])

@php
$bgFrom = "from-{$color}-50";
$bgTo = "to-{$color}-100";
$border = "border-{$color}-200";
$text = "text-{$color}-600";
$hover = "from-{$color}-400 to-{$color}-500";
$darkBg = "dark:from-{$color}-900/20 dark:to-{$color}-900/20";
$darkBorder = "dark:border-{$color}-700/50";
$darkText = "dark:text-{$color}-400";
@endphp

<div class="relative bg-gradient-to-br {{ $bgFrom }} {{ $bgTo }} {{ $darkBg }} border {{ $border }} {{ $darkBorder }} rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 group">
    <div class="absolute top-4 right-4 p-2 bg-{{ $color }}-100 dark:bg-{{ $color }}-800/50 rounded-lg">
        {{-- <x-dynamic-component :component="'icons.' . $icon" class="w-5 h-5 {{ $text }} {{ $darkText }}" /> --}}
    </div>
    <div class="{{ $text }} {{ $darkText }} text-sm font-semibold mb-2">{{ $title }}</div>
    <div class="text-3xl font-bold text-{{ $color }}-800 dark:text-{{ $color }}-200 mb-1">{{ $count }}</div>
    <div class="text-xs text-{{ $color }}-500 dark:text-{{ $color }}-400">{{ $subtitle }}</div>
    <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r {{ $hover }} rounded-b-xl transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
</div>
