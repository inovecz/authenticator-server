<?php
declare(strict_types=1);
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Traits\BaseModel;
use App\Models\Traits\HashableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HashableTrait, BaseModel;

    // <editor-fold desc="Region: STATE DEFINITION">
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $hidden = ['password', 'remember_token',];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
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
    // </editor-fold desc="Region: GETTERS">

    // <editor-fold desc="Region: COMPUTED GETTERS">
    public function getFullName(bool $reverse = false, bool $ascii = false): string
    {
        $fullname = collect([$this->getName($ascii), $this->getSurname($ascii)]);
        return $reverse ? $fullname->reverse()->implode(' ') : $fullname->implode(' ');
    }
    // </editor-fold desc="Region: COMPUTED GETTERS">
}
