<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use App\Enums\GenderEnum;
use Illuminate\Support\Str;
use App\Models\Traits\ModelTrait;
use App\Models\Traits\HashableTrait;
use App\Models\Traits\ResourceTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasOne;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail, JWTSubject
{
    use HasFactory, Notifiable, HashableTrait, ModelTrait, ResourceTrait;

    // <editor-fold desc="Region: STATE DEFINITION">
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $hidden = ['password'];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_attempt_at' => 'datetime',
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
    public function getName(): ?string
    {
        return $this->name;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function getGender(): GenderEnum
    {
        return $this->gender;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getLastAttemptAt(): ?Carbon
    {
        return $this->last_attempt_at;
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
        $fullnameString = $reverse ? $fullname->reverse()->implode(' ') : $fullname->implode(' ');
        return (str_replace(' ', '', $fullnameString) === '' || !$fullnameString) ? 'N/A' : $fullnameString;
    }
    // </editor-fold desc="Region: COMPUTED GETTERS">

    // <editor-fold desc="Region: JWT">
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    // </editor-fold desc="Region: JWT">
}
