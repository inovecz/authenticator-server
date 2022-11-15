<?php
declare(strict_types=1);
namespace App\Models\Traits;

use Carbon\Carbon;
use OpenApi\Annotations as OA;

/**
 * @property int $id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */

/**
 * @OA\Schema(
 * @OA\Property(property="created_at", type="string", format="date-time", description="Initial creation timestamp", readOnly="true"),
 * @OA\Property(property="updated_at", type="string", format="date-time", description="Last update timestamp", readOnly="true"),
 * )
 * Class ModelTrait
 *
 * @package App\Models\Traits
 */
trait ModelTrait {
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
