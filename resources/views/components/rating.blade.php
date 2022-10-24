<div class="before:content-['{{ str($outerStars)->replace(' ', '_') }}'] inline-block relative {{ $textSize }} font-[{{ $family }}]">
    <div class="before:content-['{{ str($innerStars)->replace(' ', '_') }}'] {{ $color }} absolute top-0 left-0 whitespace-nowrap overflow-hidden w-[{{ $score }}%]"></div>
</div>
