<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use App\Models\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VerificationCode extends Model
{
    use ModelTrait;

    public const DEFAULT_VALIDITY_MINUTES = 15;

    // <editor-fold desc="Region: STATE_DEFINITION">
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $casts = [
        'valid_until' => 'datetime',
    ];
    // </editor-fold desc="Region: STATE_DEFINITION">

    // <editor-fold desc="Region: BOOT">
    protected static function boot()
    {
        parent::boot();
        static::creating(static function ($model) {
            if (!$model->valid_until) {
                $model->setAttribute('valid_until', now()->addMinutes(self::DEFAULT_VALIDITY_MINUTES + 1)->startOfMinute());
            }
            $model->setAttribute('code', fake()->numerify('######'));
        });
    }
    // </editor-fold desc="Region: BOOT">

    // <editor-fold desc="Region: RELATIONS">
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    // </editor-fold desc="Region: RELATIONS">

    // <editor-fold desc="Region: GETTERS">
    public function getCode(): string
    {
        return $this->code;
    }

    public function getValidUntil(): Carbon
    {
        return $this->valid_until;
    }
    // </editor-fold desc="Region: GETTERS">

    // <editor-fold desc="Region: COMPUTED GETTERS">
    public function isValid(): bool
    {
        return $this->getValidUntil()->gte(now());
    }
    // </editor-fold desc="Region: COMPUTED GETTERS">

    // <editor-fold desc="Region: SCOPES">
    public function scopeActive(Builder $builder): Builder
    {
        return $builder->where('valid_until', '>=', now());
    }

    public function scopeExpired(Builder $builder): Builder
    {
        return $builder->where('valid_until', '<', now());
    }
    // </editor-fold desc="Region: SCOPES">
}
