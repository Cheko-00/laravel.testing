<?php

namespace App\Enums;

enum TicketStatus: string
{
    case OPEN = 'open';
    case IN_PROGRESS = 'in_progress';
    case WAITING_CLIENT = 'waiting_client';
    case RESOLVED = 'resolved';
    case CLOSED = 'closed';


    public function label():string
    {
        return match ($this) {
            self::OPEN => 'Open',
            self::IN_PROGRESS => 'In Progress',
            self::WAITING_CLIENT => 'Waiting Client',
            self::RESOLVED => 'Resolved',
            self::CLOSED => 'Closed',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::OPEN => 'bg-success',
            self::IN_PROGRESS => 'bg-warning',
            self::WAITING_CLIENT => 'bg-danger',
            self::RESOLVED => 'bg-dark',
            self::CLOSED => 'bg-secondary',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn($case)=> [
            $case->value => $case->label(),
        ])->toArray();
    }
}
