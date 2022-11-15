<?php
declare(strict_types=1);
namespace App\Enums\Traits;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 * @OA\Property(property="gender", type="string", enum={"MALE","FEMALE","OTHER"}, readOnly="true"),
 * )
 * Class EnumTrait
 *
 * @package App\Enums\Traits
 */
trait EnumTrait
{
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function array(): array
    {
        return array_combine(self::values(), self::names());
    }

}
