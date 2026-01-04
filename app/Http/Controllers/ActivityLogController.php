<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Menampilkan daftar semua log aktivitas.
     */
    public function index()
    {
        $logs = \App\Models\ActivityLog::with('user')
            ->latest()
            ->paginate(50);
            
        return view('settings.activity_logs.index', compact('logs'));
    }
}
