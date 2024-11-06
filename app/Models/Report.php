<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Report extends Model
{
    use HasFactory;
    use HasUlids;

    /** @var array>int,string> */
    protected $fillable = [
        'url',
        'content_type',
        'status',
        'header_size',
        'request_size',
        'redirect_count',
        'http_version',
        'appconnect_time',
        'namelookup_time',
        'pretransfer_time',
        'redirect_time',
        'starttransfer_time',
        'total_time',
        'check_id',
        'started_at',
        'finshed_at',
    ];

    /** @return BelongsTo<Check> */
    public function check(): BelongsTo
    {
        return $this->belongsTo(
            related: Check::class,
            foreignKey: 'check_id'
        );
    }

    protected function casts(): array
    {
        return [
            'status' => 'integer',
            'header_size' => 'integer',
            'request_size' => 'integer',
            'redirect_count' => 'integer',
            'http_version' => 'integer',
            'appconnect_time' => 'integer',
            'connect_time' => 'integer',
            'namelookup_time' => 'integer',
            'pretransfer_time' => 'integer',
            'redirect_time' => 'integer',
            'starttransfer_time' => 'integer',
            'total_time' => 'integer',
            'started_at' => 'datetime',
            'finished_at' => 'datetime',
        ];
    }
}
