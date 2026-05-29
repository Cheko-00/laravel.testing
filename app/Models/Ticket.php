<?php

namespace App\Models;

use App\Enums\TicketPriorityLevel;
use App\Enums\TicketStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['ticket_number', 'title', 'description', 'status', 'priority_level', 'category_id', 'team_id', 'created_by', 'assigned_to', 'due_at', 'resolved_at', 'closed_at', 'deleted_at'])]
class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'status' => TicketStatus::class,
        'priority_level' => TicketPriorityLevel::class,
        'ticket_number' => 'string',
        'due_at' => 'datetime',
        'resolved_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
