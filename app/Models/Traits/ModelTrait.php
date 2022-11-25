<?php

declare(strict_types=1);

namespace App\Models\Traits;

use Carbon\Carbon;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      @OA\Xml(name="ModelTrait"),
 *      @OA\Property(property="id", type="integer", example=1, description="Identificator of the current object", readOnly="true"),
 *      @OA\Property(property="created_at", type="string", format="date-time", example="2022-10-10T00:00:00", description="Initial creation timestamp", readOnly="true"),
 *      @OA\Property(property="updated_at", type="string", format="date-time", example="2022-10-10T00:00:00", description="Last update timestamp", readOnly="true"),
 * )
 *
 * Class ModelTrait
 *
 */
trait ModelTrait
{
    public function getId(): int
    {
        return $this->id;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): Carbon
    {
        return $this->updated_at;
    }
}
