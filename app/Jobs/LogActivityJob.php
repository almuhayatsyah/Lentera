<?php

namespace App\Jobs;

use App\Models\ActivityLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LogActivityJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        ActivityLog::create([
            'user_id' => $this->data['user_id'] ?? null,
            'activity' => $this->data['activity'] ?? null,
            'description' => $this->data['description'] ?? null,
            'properties' => $this->data['properties'] ?? [],
            'ip_address' => $this->data['ip_address'] ?? null,
            'user_agent' => $this->data['user_agent'] ?? null,
        ]);
    }
}
