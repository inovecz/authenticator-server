<?php
declare(strict_types=1);

namespace App\Models\Traits;

trait HashableTrait
{
    // <editor-fold desc="Region: BOOT">
    protected static function bootHashableTrait(): void
    {
        static::creating(static function ($model) {
            if(!$model->hash) {
                $hash = generate_hash();
                $model->setAttribute('hash', $hash);
            }
        });
    }
    // </editor-fold desc="Region: BOOT">

    // <editor-fold desc="Region: GETTERS">
    public function getRouteKeyName(): string
    {
        return 'hash';
    }

    public function getHash(): string
    {
        return $this->hash;
    }
    // </editor-fold desc="Region: GETTERS">
}
