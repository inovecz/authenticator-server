<?php

namespace App\Http\Livewire\Modals;

use App\Enums\GenderEnum;
use App\Services\UserService;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UpdateOrCreateUserRequest;

class UserSave extends ModalComponent
{
    public ?array $user = null;

    public ?string $hash = null;
    public ?string $name = null;
    public ?string $surname = null;
    public string $gender;
    public ?string $email = null;
    public ?string $phone = null;
    public ?string $password = null;
    public ?string $passwordConfirmation = null;

    public function mount(?array $user = null): void
    {
        $this->gender = GenderEnum::OTHER->value;
        $this->user = $user;
        if ($user) {
            $this->hash = $user['hash'];
            $this->name = $user['name'];
            $this->surname = $user['surname'];
            $this->gender = $user['gender'];
            $this->email = $user['email'];
            $this->phone = $user['phone'];
            $this->password = null;
            $this->passwordConfirmation = null;
        }
    }

    public function render()
    {
        return view('livewire.modals.user-save');
    }

    public function cancel(): void
    {
        $this->closeModal();
    }

    public function submit(): void
    {
        $data = [
            'name' => $this->name,
            'surname' => $this->surname,
            'gender' => GenderEnum::from($this->gender),
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => $this->password,
            'password_confirmation' => $this->passwordConfirmation,
        ];

        $updatingWithoutPasswordChange = $this->hash && (!$this->password || $this->password === '');

        if ($updatingWithoutPasswordChange) {
            unset($data['password'], $data['password_confirmation']);
        }

        $validationData = $this->hash ? array_merge($data, ['hash', $this->hash]) : $data;
        Validator::make($validationData, (new UpdateOrCreateUserRequest())->prepareRules($this->hash))->validate();
        unset($data['password_confirmation']);
        if (!$updatingWithoutPasswordChange) {
            $data['password'] = Hash::make($data['password']);
        }
        $userService = new UserService();
        $user = $userService->updateOrCreate($data, $this->hash);
        $this->emit('userSaved', $user);
        $this->closeModal();
    }
}
