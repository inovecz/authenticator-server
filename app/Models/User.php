<?php
declare(strict_types=1);
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use App\Models\Traits\ModelTrait;
use App\Models\Traits\HashableTrait;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasProfilePhoto, TwoFactorAuthenticatable, HashableTrait, ModelTrait;

    // <editor-fold desc="Region: STATE DEFINITION">
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $hidden = ['password', 'remember_token', 'two_factor_recovery_codes', 'two_factor_secret',];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_attemp_at' => 'datetime'
    ];
    protected $appends = ['profile_photo_url'];
    // </editor-fold desc="Region: STATE DEFINITION">

    // <editor-fold desc="Region: GETTERS">
    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
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
        $fullname = collect([$this->getName($ascii), $this->getSurname($ascii)]);
        return $reverse ? $fullname->reverse()->implode(' ') : $fullname->implode(' ');
    }
    // </editor-fold desc="Region: COMPUTED GETTERS">
}
