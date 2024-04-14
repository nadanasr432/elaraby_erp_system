<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JournalEntryController extends Controller
{
    public function get_journal_entries()
    {
        return view('client.journal.index');
    }

    public function create_journal_entries()
    {
        return view('client.journal.create');
    }

    public function store(Request $request)
    {
        dd($request->all());
    }
}
