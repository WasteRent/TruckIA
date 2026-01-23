<?php

namespace App\Models;

use App\Services\AuditFilterService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Models\Audit as BaseAudit;

class Audit extends BaseAudit
{

    public static function filter(array $filters)
    {
        $query = static::query();
        $filterService = new AuditFilterService();

        if (isset($filters['event']) && $filters['event'] != null) {
            $query->where('event', $filters['event']);
        }

        if (isset($filters['user_id']) && $filters['user_id'] != null) {
            $query->where('user_id', $filters['user_id']);
        }

        if (isset($filters['auditable_id']) && $filters['auditable_id'] != null) {
            $filterService->filterByInternalId($query, $filters['auditable_id']);
        }

        if (isset($filters['plate']) && $filters['plate'] != null) {
            $filterService->filterByPlate($query, $filters['plate']);
        }

        if (isset($filters['date_from']) && $filters['date_from'] != null) {
            $query->where('created_at', '>=', $filters['date_from']);
        }

        if (isset($filters['date_to']) && $filters['date_to'] != null) {
            $query->where('created_at', '<=', $filters['date_to']);
        }

        return $query;
    }
}
