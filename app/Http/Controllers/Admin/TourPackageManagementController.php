<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TourPackage;
use App\Models\TourSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TourPackageManagementController extends Controller
{
    public function index()
    {
        $packages = TourPackage::withCount('schedules')->latest()->paginate(10);
        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.packages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'required',
            'itinerary'     => 'nullable',
            'price'         => 'required|integer|min:0',
            'duration_days' => 'required|integer|min:1',
            'meeting_point' => 'required|string',
            'thumbnail'     => 'nullable|image|max:2048',
        ]);

        $data = $request->except('thumbnail');
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('packages', 'public');
        }

        TourPackage::create($data);

        return redirect()->route('admin.packages.index')->with('success', 'Tour package created successfully.');
    }

    public function edit(TourPackage $package)
    {
        return view('admin.packages.edit', compact('package'));
    }

    public function update(Request $request, TourPackage $package)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'required',
            'itinerary'     => 'nullable',
            'price'         => 'required|integer|min:0',
            'duration_days' => 'required|integer|min:1',
            'meeting_point' => 'required|string',
            'thumbnail'     => 'nullable|image|max:2048',
            'is_active'     => 'boolean',
        ]);

        $data = $request->except('thumbnail');
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('packages', 'public');
        }

        $package->update($data);

        return redirect()->route('admin.packages.index')->with('success', 'Tour package updated successfully.');
    }

    public function destroy(TourPackage $package)
    {
        $package->delete();
        return redirect()->route('admin.packages.index')->with('success', 'Tour package deleted successfully.');
    }

    public function schedules(TourPackage $package)
    {
        $schedules = $package->schedules()->orderBy('departure_date')->paginate(10);
        return view('admin.packages.schedules', compact('package', 'schedules'));
    }

    public function storeSchedule(Request $request, TourPackage $package)
    {
        $request->validate([
            'departure_date' => 'required|date|after:today',
            'quota'          => 'required|integer|min:1',
        ]);

        TourSchedule::create([
            'tour_package_id' => $package->id,
            'departure_date'  => $request->departure_date,
            'quota'           => $request->quota,
            'booked'          => 0,
            'is_active'       => true,
        ]);

        return redirect()->route('admin.packages.schedules', $package->id)->with('success', 'Schedule added successfully.');
    }

    public function destroySchedule(TourSchedule $schedule)
    {
        $schedule->delete();
        return redirect()->back()->with('success', 'Schedule deleted successfully.');
    }
}