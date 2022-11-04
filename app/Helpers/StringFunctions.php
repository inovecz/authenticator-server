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
        return $orderedUuid ? (string)Str::orderedUuid() : (string)Str::uuid();
    }
}


