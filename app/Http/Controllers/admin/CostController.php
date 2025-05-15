<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cost;
use App\Services\CostService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CostController extends Controller
{
    public function __construct(protected CostService $costService)
    {
    }

    public function index()
    {
        $costs = $this->costService->all();
        return Inertia::render('admin/Costs/Index', compact('costs'));
    }

    public function create()
    {
        return Inertia::render('admin/Costs/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cost' => 'required|numeric|min:0',
            'number_of_people' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'costable_id' => 'required|integer',
            'costable_type' => 'required|string',
        ]);

        $cost = $this->costService->create($validated);

        return redirect()->back()
            ->with('success', 'Cost created successfully.');
    }

    public function show(Cost $cost)
    {
        return Inertia::render('admin/Costs/Show', compact('cost'));
    }

    public function edit(Cost $cost)
    {
        return Inertia::render('admin/Costs/Edit', compact('cost'));
    }

    public function update(Request $request, Cost $cost)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cost' => 'required|numeric|min:0',
            'number_of_people' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'costable_id' => 'required|integer',
            'costable_type' => 'required|string',
        ]);

        $this->costService->update($cost->id, $validated);

        return redirect()->back()
            ->with('success', 'Cost updated successfully.');
    }

    public function destroy(Cost $cost)
    {
        $this->costService->delete($cost->id);

        return redirect()->back()
            ->with('success', 'Cost deleted successfully.');
    }
} 