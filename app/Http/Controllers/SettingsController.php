<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Posyandu;
use App\Services\ActivityLogger;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    /**
     * Display the main settings dashboard with sub‑features.
     */
    public function index()
    {
        // Gather simple stats for display cards
        $stats = [
            'users' => User::count(),
            'posyandus' => Posyandu::count(),
            // other stats can be added later
        ];

        ActivityLogger::log('Buka Pengaturan', 'Admin membuka halaman pengaturan utama');

        return view('settings.index', compact('stats'));
    }

    /**
     * Prune old activity logs via Artisan command.
     */
    public function pruneActivityLog(Request $request)
    {
        // Only admin middleware protects this route
        Artisan::call('activitylog:prune');
        return back()->with('success', 'Log aktivitas berhasil dibersihkan.');
    }
}
