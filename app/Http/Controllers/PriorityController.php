<?php

namespace App\Http\Controllers;

use App\Enums\TicketPriorityLevel;
use App\Http\Requests\StorePriorityRequest;
use App\Http\Requests\UpdatePriorityRequest;
use App\Models\Priority;

class PriorityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $levels = TicketPriorityLevel::cases();
        return view('priority-levels.index', compact('levels'));
    }
}
