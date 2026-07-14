@props([
'radius' => null,
'bg' => null,
])

@php
$style = $radius ? "--glass-border-radius: {$radius};" : '';
@endphp

<div {{ $attributes->merge(['class' => 'glass-effect', 'style' => $style]) }}>

	@if($bg)
		{{-- Opcja 1: WebGL glass --}}
		<canvas class="glass-effect__canvas __glass" data-bg="{{ $bg }}"></canvas>
	@else
		{{-- Fallback: CSS glass --}}
		<div class="glass-effect__bend"></div>
		<div class="glass-effect__face"></div>
		<div class="glass-effect__edge"></div>
	@endif

	<div class="glass-effect__content">
		{{ $slot }}
	</div>
</div>