<?php

namespace App\Actions\Tickets;

use App\Enums\TicketPriorityLevel;
use App\Enums\TicketStatus;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class CreateTicket
{
    /**
     * Create a new class instance.
     */
  public function __construct(
        private GenerateTicketNumber $generateTicketNumber,
        private CalculateTicketDueDate $calculateDueDate
    ) {}
    public function execute(array $data): Ticket
    {
        $priority = TicketPriorityLevel::from($data['priority_level']);

        $dueDate = $data['due_at']
            ?? $this->calculateDueDate->execute($priority);

        return Ticket::create([
            'ticket_number'   => $this->generateTicketNumber->execute(),
            'title'           => $data['title'],
            'description'     => $data['description'],
            'status'          => TicketStatus::OPEN->value,
            'priority_level'  => $priority->value,
            'category_id'    => $data['resolved_category_id'],  
            'team_id'         => $data['team_id'] ?? null,
            'created_by'      => Auth::id(),
            'assigned_to'     => $data['assigned_to'] ?? null,
            'parent_id'       => $data['parent_id'] ?? null,
            'due_at'          => $dueDate,
        ]);
    }
}
