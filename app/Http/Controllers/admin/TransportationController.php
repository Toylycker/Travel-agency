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
        return Inertia::render('admin.transportations.index', compact('transportations'));
    }

    public function create()
    {
        return Inertia::render('admin.transportations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_cn' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'description_cn' => 'nullable|string',
        ]);

        $transportation = $this->transportationService->create($validated);

        return redirect()->route('admin.transportations.index')
            ->with('success', 'Transportation created successfully.');
    }

    public function show(Transportation $transportation)
    {
        return Inertia::render('admin.transportations.show', compact('transportation'));
    }

    public function edit(Transportation $transportation)
    {
        return Inertia::render('admin.transportations.edit', compact('transportation'));
    }

    public function update(Request $request, Transportation $transportation)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_cn' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'description_cn' => 'nullable|string',
        ]);

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