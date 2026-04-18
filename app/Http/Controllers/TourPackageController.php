<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TourPackage;

class TourPackageController extends Controller
{
    public function index(Request $request)
    {
        $query = TourPackage::where('is_active', true)
            ->withCount('schedules');

        // Filter by search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by duration
        if ($request->filled('duration')) {
            $query->where('duration_days', $request->duration);
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sort
        $sort = $request->get('sort', 'latest');
        match($sort) {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'duration'   => $query->orderBy('duration_days', 'asc'),
            default      => $query->latest(),
        };

        $packages = $query->paginate(6)->withQueryString();

        return view('tours.index', compact('packages'));
    }

    public function show($slug)
    {
        $package = TourPackage::where('slug', $slug)
        ->where('is_active', true)
        ->with(['schedules' => function($q) {
            $q->where('is_active', true)
              ->where('departure_date', '>=', today())
              ->orderBy('departure_date');
        }])
        ->firstOrFail();

        return view('tours.show', compact('package'));
    }
}
