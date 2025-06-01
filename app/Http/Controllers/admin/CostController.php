<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cost;
use App\Models\Transportation;
use App\Models\Accommodation;
use App\Models\Activity;
use App\Models\Meal;
use App\Models\Hotel;
use App\Models\Guide;
use App\Models\Room;
use App\Services\CostService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CostController extends Controller
{
    public function __construct(protected CostService $costService){}

    public function index()
    {
        $costs = $this->costService->all();
        return Inertia::render('admin/Costs/Index', compact('costs'));
    }

    public function create(Request $request)
    {
        $preselectedCostableType = $request->query('costable_type');
        $preselectedCostableId = $request->query('costable_id');
        
        // Only load costable items if we don't have predefined ones
        $costableItems = $preselectedCostableType && $preselectedCostableId ? [] : Cost::getCostableItems();

        $costableTypes = collect(Cost::getCostableTypes())->map(fn($label, $value) => [
            'label' => $label,
            'value' => $value
        ])->values();

        return Inertia::render('admin/Costs/Create', compact(
            'costableItems', 
            'costableTypes',
            'preselectedCostableType',
            'preselectedCostableId'
        ));
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

        $this->costService->create($validated);

        return redirect()->back()
            ->with('success', 'Cost created successfully.');
    }

    public function edit(Cost $cost)
    {
        // Only load costable items if we don't have predefined ones
        $costableItems = $cost->costable_type && $cost->costable_id ? [] : Cost::getCostableItems();

        $costableTypes = collect(Cost::getCostableTypes())->map(fn($label, $value) => [
            'label' => $label,
            'value' => $value
        ])->values();

        return Inertia::render('admin/Costs/Edit', compact('cost', 'costableItems', 'costableTypes'));
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