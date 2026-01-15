<?php

namespace App\Services;

use App\Models\RepairOrder;

class RepairOrderExportService
{
    public function buildOrderRow(RepairOrder $order): array
    {
        $operations = $this->formatOperations($order);
        $parts = $this->formatParts($order);
        $costs = $this->calculateCosts($order);

        return [
            $order->id,
            $order->created_at,
            $order->vehicle->plate,
            $order->vehicle->chassis,
            $order->vehicle->equipment,
            $order->garage?->name,
            $order->state?->name,
            strip_tags($order->internal_notes),
            $operations,
            $parts,
            $order->assignedUser?->name ?? '',
            $order->relatedIncident?->user->name ?? '',
            number_format($costs['repairHours'], 2),
            number_format($costs['repairCost'], 2) . '€',
            number_format($costs['partsCost'], 2) . '€',
            number_format($costs['totalCost'], 2) . '€'
        ];
    }

    private function formatOperations(RepairOrder $order): string
    {
        return $order->operations->map(function ($op) {
            return $op->operation_name . ($op->operation_description ? ': ' . $op->operation_description : '');
        })->join('; ') ?: '';
    }

    private function formatParts(RepairOrder $order): string
    {
        return $order->parts->map(function ($part) {
            $reference = $part->reference ?: '';
            $manufacturer = $part->manufacturer ?: '';
            $description = $part->description ?: '';
            $name = $part->name ?: '';
            $quantity = $part->quantity ?: '';
            
            $partInfo = [];
            if ($reference) $partInfo[] = 'Ref: ' . $reference;
            if ($manufacturer) $partInfo[] = 'Marca: ' . $manufacturer;
            if ($description) $partInfo[] = 'Descripción: ' . $description;
            if ($name) $partInfo[] = '(' . $name . ')';
            if ($quantity) $partInfo[] = 'x' . $quantity;
            
            return implode('; ', $partInfo);
        })->join(' | ') ?: '';
    }

    private function calculateCosts(RepairOrder $order): array
    {
        return [
            'repairHours' => $order->operations->sum('real_time_in_hours'),
            'repairCost' => $order->operations->sum('amount'),
            'partsCost' => $order->parts->sum('total_price'),
            'totalCost' => $order->getTotalAmount(),
        ];
    }
}

