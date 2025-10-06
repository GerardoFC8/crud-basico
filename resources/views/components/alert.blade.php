<!-- resources/views/components/alert.blade.php -->
@props(['type' => 'info', 'message'])
<?php
    $classes = 'bg-blue-100 text-blue-800'; // Default to info
    if ($type === 'success') {
        $classes = 'bg-green-100 text-green-800';
    } elseif ($type === 'error') {
        $classes = 'bg-red-100 text-red-800';
    } elseif ($type === 'warning') {
        $classes = 'bg-yellow-100 text-yellow-800';
    }
?>
<div class="p-4 {{ $classes }}">
    {{ $message }}
</div>