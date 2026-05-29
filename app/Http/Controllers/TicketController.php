<?php

namespace App\Http\Controllers;

use App\Actions\Tickets\CreateTicket;
use App\Enums\TicketPriorityLevel;
use App\Enums\TicketStatus;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Category;
use App\Models\Team;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function __construct(private CreateTicket $createTicket) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Ticket::query();
        if ($request->filled('status')) {
            $status = TicketStatus::tryFrom($request->status);
            if ($status) {
                $query->where('status', $status->value);
            }
        }

        $tickets = $query->paginate(10);
        $statusOptions = TicketStatus::options();

        return view('tickets.index', compact('tickets', 'statusOptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::with(['children' => function ($q) {
                        $q->where('is_active', true)->orderBy('name');
                    }])->whereNull('parent_id')->where('is_active', true)->orderBy('name')->get();

        $teams = Team::all();
        $priorities = TicketPriorityLevel::cases();
        $defaultDueDate = now()
            ->addHours(TicketPriorityLevel::MEDIUM->slaHours())
            ->format('Y-m-d\TH:i');

        return view('tickets.create', compact(
            'categories',
            'teams',
            'priorities',
            'defaultDueDate'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request)
    {
        $ticket = $this->createTicket->execute($request->validated());

        return redirect()->route('tickets.show', $ticket)->with('success', "Ticket {$ticket->ticket_number} created successfully!");
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
            $ticket->load(['category.parent', 'team', 'createdBy', 'assignedTo']);

            return view('tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
