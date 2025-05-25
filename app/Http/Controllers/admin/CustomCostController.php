<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomCost;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomCostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customCosts = CustomCost::latest()->paginate(10);
        return Inertia::render('admin/CustomCosts/Index', [
            'customCosts' => $customCosts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('admin/CustomCosts/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        CustomCost::create($validated);

        return redirect()->route('admin.custom-costs.index')->with('success', 'Custom Cost created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomCost $customCost)
    {
        // Typically not used for admin CRUD if edit page shows all details
        return Inertia::render('admin/CustomCosts/Show', [
            'customCost' => $customCost->load('costs') // Example of loading related costs
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomCost $customCost)
    {
        return Inertia::render('admin/CustomCosts/Edit', [
            'customCost' => $customCost,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CustomCost $customCost)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $customCost->update($validated);

        return redirect()->route('admin.custom-costs.index')->with('success', 'Custom Cost updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomCost $customCost)
    {
        // Consider what happens to Costs associated with this CustomCost.
        // If Costs should also be deleted or disassociated, handle that logic here.
        // For example, $customCost->costs()->delete(); or detach them.
        // For now, just deleting the CustomCost item itself.
        $customCost->delete();

        return redirect()->route('admin.custom-costs.index')->with('success', 'Custom Cost deleted successfully.');
    }
}
