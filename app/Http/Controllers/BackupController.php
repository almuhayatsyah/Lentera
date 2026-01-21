<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Services\ActivityLogger;

class BackupController extends Controller
{
    /**
     * Display backup & reset management page
     */
    public function index()
    {
        // Get database statistics
        $stats = [
            'users' => User::count(),
            'posyandus' => \App\Models\Posyandu::count(),
            'ibus' => \App\Models\Ibu::count(),
            'anaks' => \App\Models\Anak::count(),
            'kunjungans' => \App\Models\Kunjungan::count(),
            'database_size' => $this->getDatabaseSize(),
        ];

        return view('backup.index', compact('stats'));
    }

    /**
     * Generate and download database backup
     */
    public function backup()
    {
        try {
            $database = env('DB_DATABASE');
            $filename = 'backup_lentera_' . date('Y-m-d_His') . '.sql';
            
            // Get all tables
            $tables = DB::select('SHOW TABLES');
            $tableKey = 'Tables_in_' . $database;
            
            $sql = "-- LENTERA Database Backup\n";
            $sql .= "-- Generated: " . date('Y-m-d H:i:s') . "\n\n";
            $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

            foreach ($tables as $table) {
                $tableName = $table->$tableKey;
                
                // Get table structure
                $createTable = DB::select("SHOW CREATE TABLE `$tableName`")[0];
                $sql .= "\n-- Table structure for `$tableName`\n";
                $sql .= "DROP TABLE IF EXISTS `$tableName`;\n";
                $sql .= $createTable->{'Create Table'} . ";\n\n";
                
                // Get table data
                $rows = DB::table($tableName)->get();
                if ($rows->count() > 0) {
                    $sql .= "-- Data for table `$tableName`\n";
                    foreach ($rows as $row) {
                        $values = [];
                        foreach ((array)$row as $value) {
                            if (is_null($value)) {
                                $values[] = 'NULL';
                            } else {
                                $values[] = "'" . addslashes($value) . "'";
                            }
                        }
                        $sql .= "INSERT INTO `$tableName` VALUES (" . implode(', ', $values) . ");\n";
                    }
                    $sql .= "\n";
                }
            }

            $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

            ActivityLogger::log('Backup Database', 'Berhasil membuat backup database');

            return response($sql)
                ->header('Content-Type', 'text/sql')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat backup: ' . $e->getMessage());
        }
    }

    /**
     * Reset entire system (keep only Super Admin developer)
     */
    public function reset(Request $request)
    {
        // Validate password
        $request->validate([
            'password' => 'required'
        ]);

        // Verify admin password
        if (!Hash::check($request->password, Auth::user()->password)) {
            return back()->with('error', 'Password salah!');
        }

        try {
            DB::transaction(function () {
                // Delete all data
                DB::table('pelayanan')->delete();
                DB::table('pengukurans')->delete();
                DB::table('kunjungans')->delete();
                DB::table('anaks')->delete();
                DB::table('ibus')->delete();
                DB::table('posyandus')->delete();
                DB::table('activity_logs')->delete();
                
                // Delete all users except developer (email: developer@lentera.app)
                User::where('email', '!=', 'developer@lentera.app')->delete();
            });

            ActivityLogger::log('Reset Sistem', 'Sistem berhasil direset total. Hanya menyisakan developer account.');

            return redirect()->route('settings.backup')
                ->with('success', 'Sistem berhasil direset! Semua data dihapus kecuali akun developer.');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mereset sistem: ' . $e->getMessage());
        }
    }

    /**
     * Get database size in MB
     */
    private function getDatabaseSize()
    {
        try {
            $database = env('DB_DATABASE');
            $result = DB::select("
                SELECT 
                    SUM(data_length + index_length) / 1024 / 1024 AS size_mb
                FROM information_schema.tables
                WHERE table_schema = ?
            ", [$database]);
            
            return round($result[0]->size_mb ?? 0, 2);
        } catch (\Exception $e) {
            return 0;
        }
    }
}
