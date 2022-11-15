<?php
declare(strict_types=1);
namespace App\Http\Resources;

use OpenApi\Annotations as OA;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 *
 * @OA\Schema(
 * @OA\Xml(name="UserResource"),
 * @OA\Property(property="hash", type="string", example="97b2160d0a3f4b2c9afbdf423c0047f5"),
 * @OA\Property(property="name", type="string", maxLength=64, example="John"),
 * @OA\Property(property="surname", type="string", maxLength=64, example="Doe"),
 * @OA\Property(property="gender", ref="#/components/schemas/EnumTrait/properties/gender")),
 * @OA\Property(property="email", type="string", readOnly="true", format="email", description="User unique email address", example="user@gmail.com"),
 * @OA\Property(property="created_at", ref="#/components/schemas/ModelTrait/properties/created_at"),
 * )
 *
 * Class UserResource
 *
 */
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
