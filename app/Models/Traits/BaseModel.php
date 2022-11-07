<?php
namespace App\Models\Traits;

use Carbon\Carbon;

trait BaseModel
{
    public function getId(): int
    {
        return $this->id;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->created_at;
    }

    public function getUpdated_at(): Carbon
    {
        return $this->updated_at;
    }
}
