<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $id
 * @property string $name
 * @property string $path
 * @property string $method
 * @property null|object $json
 * @property null|\Illuminate\Support\Collection $headers
 * @property null|\Illuminate\Support\Collection $parameters
 * @property string $credential_id
 * @property string $service_id
 * @property null|CarbonInterface $created_at
 * @property null|CarbonInterface $updated_at
 * @property null|Credential $credential
 * @property Service $service
 * @property Collection<Report> $reports
 */

final class Check extends Model
{
    use HasFactory;
    use HasUlids;

    /** @var array<int,string> */
    protected $fillable = [
        'name',
        'path',
        'method',
        'body',
        'headers',
        'parameters',
        'credential_id',
        'service_id',
    ];

    public function credential(): BelongsTo
    {
        return $this->belongsTo(
            related: Credential::class,
            foreignKey: 'credential_id',
        );
    }

    /** @return HasMany<Report> */
    public function reports(): HasMany
    {
        return $this->hasMany(
            related: Report::class,
            foreignKey: 'check_id',
        );
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(
            related: Service::class,
            foreignKey: 'service_id',
        );
    }

    public function checks(): HasMany
    {
        return $this->hasMany(
            related: Check::class,
            foreignKey: 'credential_id',
        );
    }
    /** @return array<string,class-string|string> */
    protected function casts(): array
    {
        return [
            'body' => 'json',
            'headers' => AsCollection::class,
            'parameters' => AsCollection::class,
        ];
    }
}
