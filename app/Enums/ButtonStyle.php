<?php
declare(strict_types=1);
namespace App\Enums;

use App\Enums\Traits\EnumTrait;

enum ButtonStyle: string
{
    use EnumTrait;

    case PRIMARY = 'primary';
    case SECONDARY = 'secondary';
    case SUCCESS = 'success';
    case WARNING = 'warning';
    case DANGER = 'danger';
    case TEXT = 'text';

    public function getClass(): string
    {
        return match($this)
        {
            self::PRIMARY => 'text-white bg-blue-500 hover:bg-blue-600 rounded border border-blue-600 focus:ring-blue-500',
            self::SECONDARY => 'text-white bg-slate-500 hover:bg-slate-600 rounded border border-slate-600 focus:ring-slate-500',
            self::SUCCESS => 'text-white bg-emerald-500 hover:bg-emerald-600 rounded border border-emerald-600 focus:ring-emerald-500',
            self::WARNING => 'text-white bg-amber-500 hover:bg-amber-600 rounded border border-amber-600 focus:ring-amber-500',
            self::DANGER => 'text-white bg-red-500 hover:bg-red-600 rounded border border-red-600 focus:ring-red-500',
            self::TEXT => 'text-slate-500 hover:text-slate-400 underline'
        };
    }
}
