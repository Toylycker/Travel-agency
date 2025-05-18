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
            'description' => 'nullable|string',
            'type' => 'required|string|in:breakfast,lunch,dinner,snack',
            'cuisine' => 'required|string|max:100',
            'calories' => 'nullable|numeric|min:0',
            'preparation_time' => 'nullable|integer|min:1',
            'is_vegetarian' => 'boolean',
            'is_vegan' => 'boolean',
            'is_halal' => 'boolean',
            'contains_nuts' => 'boolean',
            'contains_dairy' => 'boolean',
            'contains_gluten' => 'boolean',
            'allergens' => 'nullable|array',
            'allergens.*' => 'string',
            'is_active' => 'boolean'
        ]);

        $meal = $this->mealService->create($validated);

        return redirect()->back()
            ->with('success', 'Meal created successfully.');
    }

    public function edit(Meal $meal)
    {
        return Inertia::render('admin/Meals/Edit', compact('meal'));
    }

    public function update(Request $request, Meal $meal)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string|in:breakfast,lunch,dinner,snack',
            'cuisine' => 'required|string|max:100',
            'calories' => 'nullable|numeric|min:0',
            'preparation_time' => 'nullable|integer|min:1',
            'is_vegetarian' => 'boolean',
            'is_vegan' => 'boolean',
            'is_halal' => 'boolean',
            'contains_nuts' => 'boolean',
            'contains_dairy' => 'boolean',
            'contains_gluten' => 'boolean',
            'allergens' => 'nullable|array',
            'allergens.*' => 'string',
            'is_active' => 'boolean'
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