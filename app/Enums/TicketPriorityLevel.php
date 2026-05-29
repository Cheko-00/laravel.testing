<?php

namespace App\Enums;

enum TicketPriorityLevel: string
{
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';
    case CRITICAL = 'critical';

    public function color(): string
    {
        return match ($this) {
            self::LOW => '#10B981',
            self::MEDIUM => '#F59E0B',
            self::HIGH => '#EF4444',
            self::CRITICAL => '#8B5CF6',
        };
    }

    public function slaHours(): int
    {
        return match ($this) {
            self::LOW => 72,
            self::MEDIUM => 48,
            self::HIGH => 24,
            self::CRITICAL => 4,
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::LOW => 'Low',
            self::MEDIUM => 'Medium',
            self::HIGH => 'High',
            self::CRITICAL => 'Critical',
        };
    }
    public function badgeClass(): string
    {
        return match ($this) {
            self::LOW => 'bg-success',
            self::MEDIUM => 'bg-warning',
            self::HIGH => 'bg-danger',
            self::CRITICAL => 'bg-dark',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn($case) => [
            $case->value => $case->label(),
        ])->toArray();
    }
}
