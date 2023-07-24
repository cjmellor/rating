<div class="inline-flex relative gap-1 group">
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
            <i class="{{ $iconBg }} {{ $iconBgColor }} {{ $size }}"></i>

            <!-- Filled Star -->
            <div class="absolute top-0 left-0 whitespace-nowrap overflow-hidden w-[{{ $width }}%]">
                <i class="{{ $iconFg }} {{ $iconFgColor }} {{ $size }}"></i>
            </div>
        </div>
    @endfor

    @if($modelRated && $showSuccess)
        <div class="ml-6">
            <i class="fas fa-circle-check text-green-500 {{ $size }}"></i>
        </div>
    @endif

    @if($this->ratingCanBeChanged())
        <div class="ml-6 group-hover:block hidden">
            <a class="cursor-pointer" wire:click="undoRating">
                <i class="fas fa-circle-xmark {{ $size }} text-red-500 hover:text-red-600"></i>
            </a>
        </div>
    @endif
</div>
