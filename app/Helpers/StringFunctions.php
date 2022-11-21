<?php

declare(strict_types=1);

use Illuminate\Support\Str;

if (!function_exists('generate_hash')) {
    function generate_hash(bool $orderedUuid = true): string
    {
        return str_replace('-', '', generate_uuid($orderedUuid));
    }
}

if (!function_exists('generate_uuid')) {
    function generate_uuid(bool $orderedUuid = true): string
    {
        return $orderedUuid ? (string) Str::orderedUuid() : (string) Str::uuid();
    }
}

if (!function_exists('number_format_short')) {
    function number_format_short(int|float $n, int $precision = 1): string
    {
        if ($n < 900) {
            // 0 - 900
            $n_format = number_format($n, $precision);
            $suffix = '';
        } elseif ($n < 900000) {
            // 0.9k-850k
            $n_format = number_format($n / 1000, $precision);
            $suffix = 'K';
        } elseif ($n < 900000000) {
            // 0.9m-850m
            $n_format = number_format($n / 1000000, $precision);
            $suffix = 'M';
        } elseif ($n < 900000000000) {
            // 0.9b-850b
            $n_format = number_format($n / 1000000000, $precision);
            $suffix = 'B';
        } else {
            // 0.9t+
            $n_format = number_format($n / 1000000000000, $precision);
            $suffix = 'T';
        }

        if ($precision > 0) {
            $dotzero = '.'.str_repeat('0', $precision);
            $n_format = str_replace($dotzero, '', $n_format);
        }

        return $n_format.$suffix;
    }
}

if (!function_exists('dot_to_varname')) {
    function dot_to_varname(string $dotNotation): string
    {
        return Str::of($dotNotation)->replace('_', '^')->replace('.', '_')->camel()->replace('^', '_')->toString();
    }
}

if (!function_exists('varname_to_dot')) {
    function varname_to_dot(string $varname): string
    {
        return Str::of($varname)->replace('_', '^')->snake()->replace('_', '.')->replace('^', '_')->toString();
    }
}
