<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    //
    public function index(Request $request)
    {
        $tickets = Ticket::with(['user', 'faculty'])
            ->latest()
            ->paginate(10);

        return view('admin.dashboard', compact('tickets'));
    }
}
