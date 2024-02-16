<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Category;

class FaqsController extends Controller
{
    public function index()
    {
        $tickets = Ticket::where('visibility', 'public')->paginate(20);
        $categories = Category::all();

        return view('tickets.faq', compact('tickets', 'categories'));
    }
}
