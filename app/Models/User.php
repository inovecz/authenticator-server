<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use App\Enums\GenderEnum;
use Illuminate\Support\Str;
use App\Models\Traits\ModelTrait;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Traits\HashableTrait;
use App\Models\Traits\ResourceTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HashableTrait, ModelTrait, ResourceTrait;

    // <editor-fold desc="Region: STATE DEFINITION">
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $hidden = ['password', 'remember_token', 'two_factor_recovery_codes', 'two_factor_secret',];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_attemp_at' => 'datetime',
        'gender' => GenderEnum::class,
    ];
    // </editor-fold desc="Region: STATE DEFINITION">

    // <editor-fold desc="Region: RELATIONS">\
    public function verificationCode(): HasOne
    {
        return $this->hasOne(VerificationCode::class)->orderByDesc('created_at');
    }
    // </editor-fold desc="Region: RELATIONS">

    // <editor-fold desc="Region: GETTERS">
    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getGender(): GenderEnum
    {
        return $this->gender;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getLastAttempAt(): ?Carbon
    {
        return $this->last_attemp_at;
    }

    public function getLoginCount(): int
    {
        return $this->login_count;
    }

    public function getAverageScore(): float
    {
        return $this->average_score;
    }

    // </editor-fold desc="Region: GETTERS">

    // <editor-fold desc="Region: COMPUTED GETTERS">
    public function getFullName(bool $reverse = false, bool $ascii = false): string
    {
        $fullname = collect([$this->getName(), $this->getSurname()]);
        if ($ascii) {
            $fullname->each(fn(string $string) => Str::ascii($string));
        }
        return $reverse ? $fullname->reverse()->implode(' ') : $fullname->implode(' ');
    }
    // </editor-fold desc="Region: COMPUTED GETTERS">
}
