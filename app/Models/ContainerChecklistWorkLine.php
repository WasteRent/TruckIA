<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContainerChecklistWorkLine extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    public const TYPE_LABOR = 'labor';
    public const TYPE_PART = 'part';

    protected $guarded = [];

    protected $casts = [
        'time_in_hours' => 'decimal:2',
        'price' => 'decimal:2',
    ];

    public function containerChecklist()
    {
        return $this->belongsTo(ContainerChecklist::class);
    }

    public function isLabor(): bool
    {
        return $this->line_type === self::TYPE_LABOR;
    }

    public function isPart(): bool
    {
        return $this->line_type === self::TYPE_PART;
    }
}
