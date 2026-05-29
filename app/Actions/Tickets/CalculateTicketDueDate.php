<?php

namespace App\Actions\Tickets;

use App\Enums\TicketPriorityLevel;
use Carbon\Carbon;

class CalculateTicketDueDate
{
    public function execute(TicketPriorityLevel $priority, ?Carbon $baseDate = null): Carbon
    {
        $base = $baseDate ?? now();

        return $base->copy()->addHours($priority->slaHours());
    }
}
