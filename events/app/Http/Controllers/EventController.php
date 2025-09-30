<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'organizer' => 'required',
            'tickets.*.ticket_no' => 'required',
            'tickets.*.price' => 'required|numeric',
        ]);

        $event = Event::create($request->except('tickets'));

        foreach ($request->tickets as $ticket) {
            if ($ticket['ticket_no'] && $ticket['price']) {
                Ticket::create([
                    'event_id' => $event->id,
                    'ticket_no' => $ticket['ticket_no'],
                    'price' => $ticket['price'],
                ]);
            }
        }

        return redirect()->back()->with('success', 'Event saved successfully!');
    }
}
