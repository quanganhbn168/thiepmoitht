@props([
    'header' => null,
    'title' => null,
])

@include('layouts.dashboard', [
    'slot' => $slot,
    'header' => $header,
    'title' => $title,
])
