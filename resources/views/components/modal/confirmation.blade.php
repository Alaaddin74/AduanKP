@props(['wireModel' => false, 'maxWidth' => 'sm'])

@php
    $maxWidth = [
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        '2xl' => 'max-w-2xl',
    ][$maxWidth];
@endphp

<div x-data="{ show: @entangle($wireModel) }"
     x-show="show"
     x-on:keydown.escape.window="show = false"
     class="fixed inset-0 bg-gray-800/60 flex items-center justify-center z-50"
     style="display: none;">
    <div class="{{ $maxWidth }} w-full p-6">
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-xl overflow-hidden">
            <div class="p-6 space-y-4">
                @if(isset($title))
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        {{ $title }}
                    </h3>
                @endif

                @if(isset($content))
                    <div class="text-sm text-gray-700 dark:text-gray-300">
                        {{ $content }}
                    </div>
                @endif
            </div>

            @if(isset($footer))
                <div class="bg-gray-50 dark:bg-gray-800 px-6 py-4 flex justify-end gap-2">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</div>
