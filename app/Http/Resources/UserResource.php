<?php
declare(strict_types=1);
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var \App\Models\User $this */
        return [
            'hash' => $this->getHash(),
            'name' => $this->getName(),
            'surname' => $this->getSurname(),
            'gender' => $this->getGender(),
            'email' => $this->getEmail(),
            'created_at' => $this->getCreatedAt()
        ];
    }
}
