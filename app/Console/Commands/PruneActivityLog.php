<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ActivityLog;
use Carbon\Carbon;

class PruneActivityLog extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'activitylog:prune';

    /**
     * The console command description.
     */
    protected $description = 'Delete activity log entries older than the configured retention period (default 30 days).';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = env('ACTIVITY_LOG_RETENTION_DAYS', 30);
        $threshold = Carbon::now()->subDays($days);
        $deleted = ActivityLog::where('created_at', '<', $threshold)->delete();
        $this->info("Pruned {$deleted} activity log records older than {$days} days.");
        return 0;
    }
}
