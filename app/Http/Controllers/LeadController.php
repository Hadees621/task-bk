<?php
namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class LeadController extends Controller
{

    public function index(Request $request)
    {
        $page     = max((int) $request->get('page', 1), 1);
        $perPage  = max(min((int) $request->get('perPage', 10), 100), 1);
        $cacheKey = "leads:index:page:{$page}:perPage:{$perPage}";
        $cacheTTL = 300;

        if (Cache::has($cacheKey)) {
            Log::info("✅ CACHE HIT: $cacheKey");
        } else {
            Log::info("❌ CACHE MISS: $cacheKey");
        }

        $leads = Cache::remember($cacheKey, $cacheTTL, function () use ($page, $perPage) {
            Log::info("🧠 Fetching from DB for page: $page");
            return Lead::orderBy('id', 'desc')
                ->paginate($perPage, ['*'], 'page', $page)
                ->toArray();
        });

        return response()->json($leads);
    }

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
