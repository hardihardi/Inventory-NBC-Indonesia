<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class SystemController extends Controller
{
    public function index()
    {
        return view('settings.system.index');
    }

    public function clearCache()
    {
        try {
            Artisan::call('optimize:clear');
            return back()->with('success', 'System cache cleared successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to clear cache: ' . $e->getMessage());
        }
    }

    public function backupDatabase()
    {
        // Simple MySQL Dump Logic
        $dbName = env('DB_DATABASE');
        $dbUser = env('DB_USERNAME');
        $dbPass = env('DB_PASSWORD');
        $dbHost = env('DB_HOST', '127.0.0.1');

        $filename = 'backup-' . date('Y-m-d-His') . '.sql';
        // Note: This relies on mysqldump being in the system PATH. 
        // In Laragon, it usually IS in the path.
        // For security, do not display password in command if possible, but for simple Windows dev env...
        
        // Use temp file
        $tempPath = storage_path('app/backups/' . $filename);
        if (!file_exists(dirname($tempPath))) {
            mkdir(dirname($tempPath), 0755, true);
        }

        // Construct command
        $command = "mysqldump --user={$dbUser} --password={$dbPass} --host={$dbHost} {$dbName} > \"{$tempPath}\"";

        try {
            // Using exec for simple Windows support where Process might fail with path issues
            // Warning: storing password in command line is not secure for production shared servers.
            exec($command, $output, $returnVar);

            if ($returnVar !== 0) {
                 throw new \Exception("mysqldump exited with error code {$returnVar}");
            }

            return response()->download($tempPath)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            return back()->with('error', 'Backup failed: ' . $e->getMessage());
        }
    }
}
