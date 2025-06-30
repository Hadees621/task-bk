<?php
namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class LeadController extends Controller
{

    public function index(Request $request)
    {
        $start = microtime(true);

        $page = max((int) $request->get('page', 1), 1);
        $perPage = max(min((int) $request->get('perPage', 10), 100), 1);

        $cacheKey = "leads:index:page:{$page}:perPage:{$perPage}";
        $cacheTTL = 300;

        $usedCache = false;
        
        if (Cache::has($cacheKey)) {
            Log::info("📦 CACHE USED → Key: $cacheKey");
            $usedCache = true;
        } else {
            Log::info("🧠 DATABASE USED → Key: $cacheKey");
        }

        $leads = Cache::remember($cacheKey, $cacheTTL, function () use ($page, $perPage) {
            return Lead::orderBy('id', 'desc')
                ->paginate($perPage, ['*'], 'page', $page)
                ->toArray();
        });

        $duration = number_format((microtime(true) - $start) * 1000, 2);

        Log::info("⏱️ TIME TAKEN → {$duration} ms | Source: " . ($usedCache ? 'CACHE' : 'DB'));

        return response()->json($leads);
    }

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

        // 🔄 Invalidate first few paginated cache pages
        for ($i = 1; $i <= 5; $i++) {
            Cache::forget("leads:index:page:$i:perPage:10");
        }

        Log::info("🧹 Cache invalidated for first 5 lead list pages");

        return response()->json([
            'message' => 'Lead created successfully',
            'lead' => $lead,
        ], 201);
    }

    public function search(Request $request)
    {
        $query = trim($request->get('q', ''));

        if (empty($query)) {
            return response()->json([
                'data' => [],
                'message' => 'Search query is empty',
            ], 400);
        }

        // Generate safe cache key
        $cacheKey = 'leads:search:q:' . md5($query);
        $cacheTTL = 60; // 1 minute

        // Fetch from cache or run search
        $results = Cache::remember($cacheKey, $cacheTTL, function () use ($query) {
            Log::info("🔍 DB SEARCH for query: $query");
            return Lead::search($query)->take(500)->get();
        });

        Log::info("📦 SEARCH CACHE USED for: $query");

        return response()->json(['data' => $results]);
    }

}
