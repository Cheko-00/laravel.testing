<?php

namespace App\Actions\Tickets;

use App\Models\Ticket;

class GenerateTicketNumber
{
    public function execute(): string
    {
        $lastTicket = Ticket::withTrashed()->latest('id')->first();
        $nextId = $lastTicket ? $lastTicket->id + 1 : 1;

        return 'TKT-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);
    }
}
