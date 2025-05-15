<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CostService;
use Illuminate\Http\Request;

class CostController extends Controller
{
    public function __construct(protected CostService $costService)
    {
    }

    public function index()
    {
        $costs = $this->costService->all();
        return view('admin.costs.index', compact('costs'));
    }

    public function create()
    {
        return view('admin.costs.create');
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

        return redirect()->route('admin.costs.index')
            ->with('success', 'Cost created successfully.');
    }

    public function show($id)
    {
        $cost = $this->costService->findOrFail($id);
        return view('admin.costs.show', compact('cost'));
    }

    public function edit($id)
    {
        $cost = $this->costService->findOrFail($id);
        return view('admin.costs.edit', compact('cost'));
    }

    public function update(Request $request, $id)
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

        $this->costService->update($id, $validated);

        return redirect()->route('admin.costs.index')
            ->with('success', 'Cost updated successfully.');
    }

    public function destroy($id)
    {
        $this->costService->delete($id);

        return redirect()->route('admin.costs.index')
            ->with('success', 'Cost deleted successfully.');
    }
} 