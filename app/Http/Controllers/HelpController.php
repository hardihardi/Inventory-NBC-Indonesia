<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelpController extends Controller
{
    /**
     * Menampilkan Pusat Bantuan (Learning Center).
     */
    public function index()
    {
        return view('help.index');
    }
}
