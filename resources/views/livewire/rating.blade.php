<div class="inline-flex relative gap-1">
    @for ($i = 1; $i <= $starRating; $i++)
        @php
            $width = $this->getStarWidth($i)
        @endphp
        <div
            class="inline-block relative {{ $static ? '' : 'cursor-pointer' }}"
            wire:mouseover="{{ $static ? '' : '$set(\'hoverValue\', ' . $i . ')' }}"
            wire:mouseout="{{ $static ? '' : '$set(\'hoverValue\', 0)' }}"
            wire:click="{{ $static ? '' : 'setRating(' . $i . ')' }}"
        >
            <!-- Outlined Star -->
            <i class="{{ $iconBg }} {{ $color }} {{ $size }}"></i>

            <!-- Filled Star -->
            <div class="absolute top-0 left-0 whitespace-nowrap overflow-hidden w-[{{ $width }}%]">
                <i class="{{ $iconFg }} {{ $color }} {{ $size }}"></i>
            </div>
        </div>
    @endfor
</div>
