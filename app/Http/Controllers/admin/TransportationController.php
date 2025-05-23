<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transportation;
use App\Services\TransportationService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TransportationController extends Controller
{
    public function __construct(protected TransportationService $transportationService)
    {
    }

    public function index()
    {
        $transportations = $this->transportationService->all();
        return Inertia::render('admin/Transportations/Index', compact('transportations'));
    }

    public function create()
    {
        return Inertia::render('admin/Transportations/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|in:bus,van,car',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255', 
            'year' => 'nullable|integer|min:1950|max:' . (date('Y') + 1),
            'seats' => 'nullable|integer|min:1',
            'license_plate' => 'nullable|string|max:255|unique:transportations,license_plate',
            'color' => 'nullable|string|max:255',
            'has_wifi' => 'boolean',
            'has_ac' => 'boolean',
            'has_tv' => 'boolean',
            'features' => 'nullable|array',
            'insurance_expiry' => 'nullable|date',
            'technical_inspection_expiry' => 'nullable|date',
            'is_active' => 'boolean'
        ]);

        // Convert features array to JSON string for storage
        if (isset($validated['features'])) {
            $validated['features'] = json_encode($validated['features']);
        }

        $this->transportationService->create($validated);

        return redirect()->back()
            ->with('success', 'Transportation created successfully.');
    }

    public function edit(Transportation $transportation)
    {
        return Inertia::render('admin/Transportations/Edit', [
            'transportation' => $transportation,
            'errors' => session()->get('errors') ? session()->get('errors')->getBag('default')->getMessages() : (object)[],
        ]);
    }

    public function update(Request $request, Transportation $transportation)
    {
        $validated = $request->validate([
            'type' => 'nullable|string|in:bus,van,car',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'year' => 'nullable|integer|min:1950|max:' . (date('Y') + 1),
            'seats' => 'nullable|integer|min:1',
            'license_plate' => 'nullable|string|max:255|unique:transportations,license_plate,' . $transportation->id,
            'color' => 'nullable|string|max:255',
            'has_wifi' => 'boolean',
            'has_ac' => 'boolean',
            'has_tv' => 'boolean',
            'features' => 'nullable|array',
            'insurance_expiry' => 'nullable|date',
            'technical_inspection_expiry' => 'nullable|date',
            'is_active' => 'boolean'
        ]);


        // Convert features array to JSON string for storage
        if (isset($validated['features'])) {
            $validated['features'] = json_encode($validated['features']);
        }

        $this->transportationService->update($transportation->id, $validated);

        return redirect()->back()
            ->with('success', 'Transportation updated successfully.');
    }

    public function destroy(Transportation $transportation)
    {
        $this->transportationService->delete($transportation->id);

        return redirect()->back()
            ->with('success', 'Transportation deleted successfully.');
    }
} 