<?php

namespace App\Http\Livewire\Modals;

use App\Enums\GenderEnum;
use App\Services\UserService;
use LivewireUI\Modal\ModalComponent;
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
        ];

        $validationData = $this->hash ? array_merge($data, ['hash', $this->hash]) : $data;
        \Validator::make($validationData, (new UpdateOrCreateUserRequest())->prepareRules($this->hash))->validate();
        $userService = new UserService();
        $user = $userService->updateOrCreate($data, $this->hash);
        $this->emit('userSaved', $user);
        $this->closeModal();
    }
}
