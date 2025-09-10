<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Equipment;
use App\Models\Facility;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'projects' => Project::count(),
            'equipment' => Equipment::count(),
            'facilities' => Facility::count(),
            'active_projects' => Project::where('Status', 'Active')->count()
        ];

        $recent_projects = Project::with('facility')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'recent_projects'));
    }
}
