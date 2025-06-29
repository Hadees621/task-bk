<?php
namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LeadController extends Controller
{
    // public function index(Request $request)
    // {
    //     $perPage = $request->get('perPage', 10);

    //     $leads = Lead::orderBy('id', 'desc')
    //         ->cursorPaginate($perPage);

    //     return response()->json($leads);
    // }

    public function index(Request $request)
    {
        $page    = $request->get('page', 1);
        $perPage = $request->get('perPage', 10);

        // Generate cache key based on API params
        $cacheKey = "leads_api_page:{$page}:perPage:{$perPage}";

        // Use remember with array conversion for Redis serialization
        $leads = Cache::remember($cacheKey, 60, function () use ($perPage, $page) {
            return Lead::orderBy('id', 'desc')
                ->paginate($perPage, ['*'], 'page', $page)
                ->toArray();
        });

        Cache::put('test_key', ['name' => 'Saad', 'role' => 'dev'], 60);

        return response()->json($leads);
    }

    // POST /api/leads
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name'    => 'required|string|max:255',
            'email'        => 'nullable|email|max:255',
            'phone_number' => 'nullable|string|max:50',
            'source'       => 'nullable|string|max:50',
            'status'       => 'required|string|in:new,contacted,qualified,converted,lost',
            'assigned_to'  => 'nullable|integer',
            'company_name' => 'nullable|string|max:255',
            'lead_score'   => 'nullable|integer',
            'notes'        => 'nullable|string',
        ]);

        $lead = Lead::create($validated);

        return response()->json([
            'message' => 'Lead created successfully',
            'lead'    => $lead,
        ], 201);
    }

    public function search(Request $request)
    {
        $query = $request->get('q', '');

        if (empty($query)) {
            return response()->json([
                'data'    => [],
                'message' => 'Search query is empty',
            ], 400);
        }

        $results = Lead::search($query)->get(500);

        return response()->json([
            'data' => $results,
        ]);
    }
}
