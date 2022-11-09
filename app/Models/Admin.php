<?php

namespace App\Models;

use App\Enums\GenderEnum;
use App\Models\Traits\ModelTrait;
use App\Models\Traits\HashableTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HashableTrait, ModelTrait;

    // <editor-fold desc="Region: STATE DEFINITION">
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $hidden = ['password'];
    protected $casts = [
        'gender' => GenderEnum::class
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

    public function getGender(): GenderEnum
    {
        return $this->gender;
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
