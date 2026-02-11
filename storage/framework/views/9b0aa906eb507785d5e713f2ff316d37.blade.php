<?php extract((new \Illuminate\Support\Collection($attributes->getAttributes()))->mapWithKeys(function ($value, $key) { return [Illuminate\Support\Str::camel(str_replace([':', '.'], ' ', $key)) => $value]; })->all(), EXTR_SKIP); ?>
@props(['field','inlineLabelVerticalAlignment'])
<x-filament-forms::field-wrapper :field="$field" :inline-label-vertical-alignment="$inlineLabelVerticalAlignment" >
<x-slot name="labelPrefix" >{{ $labelPrefix }}</x-slot>
{{ $slot ?? "" }}
</x-filament-forms::field-wrapper>