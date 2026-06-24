<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Services\VisitorTrackingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function __construct(
        private readonly VisitorTrackingService $tracking,
    ) {}

    public function identify(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'session_id' => 'nullable|string|max:255',
            'referrer_url' => 'nullable|string|max:2048',
            'landing_page' => 'nullable|string|max:2048',
            'utm_source' => 'nullable|string|max:255',
            'utm_medium' => 'nullable|string|max:255',
            'utm_campaign' => 'nullable|string|max:255',
        ]);

        $lead = $this->tracking->identifyOrCreate($request);

        return response()->json([
            'session_id' => $lead->session_id,
            'lead_id' => $lead->id,
        ]);
    }

    public function pageview(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'session_id' => 'required|string|max:255',
            'url' => 'required|string|max:2048',
            'page_title' => 'nullable|string|max:255',
            'action_type' => 'nullable|string|max:50',
            'metadata' => 'nullable|array',
        ]);

        $lead = Lead::where('session_id', $validated['session_id'])->first();

        if (! $lead) {
            return response()->json(['error' => 'Session not found'], 404);
        }

        $this->tracking->recordPageActivity($lead, $validated);

        return response()->json(['success' => true]);
    }

    public function heartbeat(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'session_id' => 'required|string|max:255',
            'seconds' => 'required|integer|min:1|max:300',
        ]);

        $lead = Lead::where('session_id', $validated['session_id'])->first();

        if (! $lead) {
            return response()->json(['error' => 'Session not found'], 404);
        }

        $this->tracking->heartbeat($lead, $validated['seconds']);

        return response()->json(['success' => true]);
    }

    public function identifyContact(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'session_id' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'message' => 'nullable|string',
            'service_interest' => 'nullable|string|max:255',
        ]);

        $lead = Lead::where('session_id', $validated['session_id'])->first();

        if (! $lead) {
            return response()->json(['error' => 'Session not found'], 404);
        }

        $this->tracking->associateContact($lead, $validated);

        return response()->json(['success' => true]);
    }
}
