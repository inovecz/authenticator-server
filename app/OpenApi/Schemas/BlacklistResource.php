<?php

namespace App\OpenApi\Schemas;

use OpenApi\Annotations as OA;

/**
 *
 * @OA\Schema(
 *      @OA\Xml(name="BlacklistResource"),
 *      @OA\Property(property="id", ref="#/components/schemas/ModelTrait/properties/id"),
 *      @OA\Property(property="type", type="string", enum={"IP","DOMAIN","EMAIL"}, example="DOMAIN", description="Blacklist type"),
 *      @OA\Property(property="value", type="string", example="snoopy.", description="The value to be processed against the entity"),
 *      @OA\Property(property="reason", type="string", example="Too many spammers...", description="Note"),
 *      @OA\Property(property="active", type="boolean", default=true, description="If true, current blacklist object will be processed"),
 *      @OA\Property(property="created_at", ref="#/components/schemas/ModelTrait/properties/created_at"),
 * )
 *
 * Class BlacklistResource
 *
 */
class BlacklistResource
{
}
