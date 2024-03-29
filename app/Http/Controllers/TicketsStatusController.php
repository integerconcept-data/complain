<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Mailers\AppMailer;
//use App\Http\Controllers\SMSController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LogController as Log;

class TicketsStatusController extends Controller
{
    public function close(Log $log, $ticket_id, AppMailer $mailer)
    {
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();

        $ticket->status = 'Closed';

        $action = "Closed Ticket";
        $description = "Closed Ticket with ID: ". $ticket_id ;
        $userId = Auth::user()->id;

        $ticket->save();

        $log->store($action, $description, $userId);

        $ticketOwner = $ticket->user;

        $mailer->sendTicketStatusNotification($ticketOwner, $ticket);

        return redirect()->back()->with("status", "The ticket has been closed.");
    }

}
