<?php extract((new \Illuminate\Support\Collection($attributes->getAttributes()))->mapWithKeys(function ($value, $key) { return [Illuminate\Support\Str::camel(str_replace([':', '.'], ' ', $key)) => $value]; })->all(), EXTR_SKIP); ?>
@props(['field','labelTag'])
<x-filament-forms::field-wrapper :field="$field" :label-tag="$labelTag" >

{{ $slot ?? "" }}
</x-filament-forms::field-wrapper>