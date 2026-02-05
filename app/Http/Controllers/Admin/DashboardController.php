<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_properties' => Property::count(),
            'active_properties' => Property::where('is_active', true)->count(),
            'sale_count' => Property::where('listing_type', 'sale')->count(),
            'rent_count' => Property::where('listing_type', 'rent')->count(),
        ];
        $recentProperties = Property::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentProperties'));
    }
}
