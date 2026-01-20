<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user');

        // Filter by activity type
        if ($request->filled('activity')) {
            $query->where('activity', 'like', '%' . $request->activity . '%');
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $logs = $query->latest()->paginate(20)->withQueryString();

        return view('activity_logs.index', compact('logs'));
    }

    /**
     * Show log details (for AJAX/Modal)
     */
    public function show(ActivityLog $activity_log)
    {
        $activity_log->load('user');
        return response()->json([
            'success' => true,
            'data' => [
                'user' => $activity_log->user->name,
                'role' => $activity_log->user->role_label,
                'activity' => $activity_log->activity,
                'description' => $activity_log->description,
                'ip_address' => $activity_log->ip_address,
                'user_agent' => $activity_log->user_agent,
                'created_at' => $activity_log->created_at->format('d/m/Y H:i:s'),
                'properties' => $activity_log->properties,
            ]
        ]);
    }

    /**
     * Remove individual log
     */
    public function destroy(ActivityLog $activity_log)
    {
        $activity_log->delete();

        return redirect()->back()->with('success', 'Log berhasil dihapus.');
    }

    /**
     * Clear old logs (e.g., > 30 days)
     */
    public function clear(Request $request)
    {
        $days = $request->input('days', 30);
        $count = ActivityLog::where('created_at', '<', now()->subDays($days))->delete();

        return redirect()->back()->with('success', "$count log lama (lebih dari $days hari) berhasil dibersihkan.");
    }
}
