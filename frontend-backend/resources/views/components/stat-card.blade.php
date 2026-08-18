@props(['icon' => '📊', 'label' => 'Label', 'value' => 0, 'color' => 'primary'])

<div class="bg-white shadow rounded-lg p-5 w-full border-t-4 border-{{ $color }}-500">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-sm font-medium text-gray-500">{{ $label }}</h3>
            <p class="text-2xl font-semibold text-gray-800 mt-1">{{ $value }}</p>
        </div>
        <div class="text-3xl text-{{ $color }}-500">
            {{ $icon }}
        </div>
    </div>
</div>
