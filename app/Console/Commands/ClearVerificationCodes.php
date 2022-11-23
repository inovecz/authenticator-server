<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\VerificationCode;

class ClearVerificationCodes extends Command
{
    protected $signature = 'inove_scheduled:clear_verification_codes';
    protected $description = 'Clear all verification codes with expired validation';

    public function handle(): int
    {
        VerificationCode::expired()->delete();
        return Command::SUCCESS;
    }
}
