<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('perPage', 10);

        $leads = Lead::orderBy('id', 'desc') // or created_at
            ->cursorPaginate($perPage);

        return response()->json($leads);
    }


    // public function index(Request $request)
    // {
    //     $perPage = $request->get('perPage', 10); // optional
    //     $leads = Lead::orderBy('id')->cursorPaginate($perPage);

    //     return response()->json($leads);
    // }


    // public function index(Request $request)
    // {
    //     $perPage = $request->get('perPage', 20);

    //     $leads = Lead::orderBy('id', 'desc')
    //         ->paginate($perPage);

    //     return response()->json($leads);
    // }

    // POST /api/leads
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone_number' => 'nullable|string|max:50',
            'source' => 'nullable|string|max:50',
            'status' => 'required|string|in:new,contacted,qualified,converted,lost',
            'assigned_to' => 'nullable|integer',
            'company_name' => 'nullable|string|max:255',
            'lead_score' => 'nullable|integer',
            'notes' => 'nullable|string',
        ]);

        $lead = Lead::create($validated);

        return response()->json([
            'message' => 'Lead created successfully',
            'lead' => $lead,
        ], 201);
    }
}
