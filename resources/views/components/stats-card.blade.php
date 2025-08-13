@props([
    'title',
    'count',
    'subtitle',
    'color' => 'gray',
    'icon' => ''
])

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

<div class="relative bg-gradient-to-br {{ $bgFrom }} {{ $bgTo }} {{ $darkBg }} border {{ $border }} {{ $darkBorder }} rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 group hover:-translate-y-1">
    @if($icon)
    <div class="absolute top-4 right-4 p-2 bg-{{ $color }}-200 dark:bg-{{ $color }}-800/50 rounded-lg">
        <!-- Simple SVG icon fallback -->
        <svg class="w-5 h-5 {{ $text }} {{ $darkText }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            @if($icon === 'document')<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>@endif
            @if($icon === 'inbox')<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>@endif
            @if($icon === 'clock')<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>@endif
            @if($icon === 'check-circle')<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>@endif
            @if($icon === 'x-circle')<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>@endif
            @if($icon === 'calendar')<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>@endif
            @if($icon === 'trending-up')<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>@endif
            @if($icon === 'lightning-bolt')<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>@endif
            @if($icon === 'chart-pie')<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>@endif
            @if($icon === 'user-group')<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>@endif
            @if($icon === 'clock-alert')<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>@endif
            @if($icon === 'exclamation-triangle')<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>@endif
        </svg>
    </div>
    @endif

    <div class="space-y-1">
        <h3 class="{{ $text }} {{ $darkText }} text-sm font-semibold">{{ $title }}</h3>
        <p class="text-3xl font-bold text-{{ $color }}-800 dark:text-{{ $color }}-200">{{ $count }}</p>
        <p class="text-xs text-{{ $color }}-500 dark:text-{{ $color }}-400">{{ $subtitle }}</p>
    </div>

    <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r {{ $hover }} rounded-b-xl transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
</div>
