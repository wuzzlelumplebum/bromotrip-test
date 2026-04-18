<?php

if (!function_exists('idr')) {
    function idr($amount)
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}