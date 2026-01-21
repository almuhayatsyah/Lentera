<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ActivityLogger
{
    public static function log(string $activity, ?string $description = null, array $properties = [])
    {
        // Dispatch async job for logging to avoid blocking request
        \App\Jobs\LogActivityJob::dispatch([
            'user_id' => Auth::id(),
            'activity' => $activity,
            'description' => $description,
            'properties' => $properties,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
        return; // job will handle insertion
    }
}
