<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inspection;

class DashboardController extends Controller
{
    public function index()
    {
        // Tarik 5 projek terkini untuk dipaparkan di paparan utama
        $recentInspections = Inspection::latest()->take(5)->get();
        
        // Kira jumlah keseluruhan projek
        $totalInspections = Inspection::count();

        return view('dashboard', compact('recentInspections', 'totalInspections'));
    }
}