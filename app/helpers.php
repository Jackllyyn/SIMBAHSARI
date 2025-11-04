<?php

if (!function_exists('format_kg')) {
    /**
     * Format angka ke kg (contoh: 1.50 → 1.5, 2.00 → 2)
     */
    function format_kg($value)
    {
        $formatted = number_format((float)$value, 2, '.', '');
        return rtrim(rtrim($formatted, '0'), '.');
    }
}