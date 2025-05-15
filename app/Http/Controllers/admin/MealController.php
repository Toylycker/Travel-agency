<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meal;
use App\Services\MealService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MealController extends Controller
{
    public function __construct(protected MealService $mealService)
    {
    }

    public function index()
    {
        $meals = $this->mealService->all();
        return Inertia::render('admin/Meals/Index', compact('meals'));
    }

    public function create()
    {
        return Inertia::render('admin/Meals/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_cn' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'description_cn' => 'nullable|string',
            'type' => 'required|string|max:50',
            'cuisine' => 'nullable|string|max:100',
        ]);

        $meal = $this->mealService->create($validated);

        return redirect()->back()
            ->with('success', 'Meal created successfully.');
    }

    public function show(Meal $meal)
    {
        return Inertia::render('admin/Meals/Show', compact('meal'));
    }

    public function edit(Meal $meal)
    {
        return Inertia::render('admin/Meals/Edit', compact('meal'));
    }

    public function update(Request $request, Meal $meal)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_cn' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'description_cn' => 'nullable|string',
            'type' => 'required|string|max:50',
            'cuisine' => 'nullable|string|max:100',
        ]);

        $this->mealService->update($meal->id, $validated);

        return redirect()->back()
            ->with('success', 'Meal updated successfully.');
    }

    public function destroy(Meal $meal)
    {
        $this->mealService->delete($meal->id);

        return redirect()->back()
            ->with('success', 'Meal deleted successfully.');
    }
} 