<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        return Inertia::render('admin.meals.index', compact('meals'));
    }

    public function create()
    {
        return Inertia::render('admin.meals.create');
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

    public function show($id)
    {
        $meal = $this->mealService->findOrFail($id);
        return Inertia::render('admin.meals.show', compact('meal'));
    }

    public function edit($id)
    {
        $meal = $this->mealService->findOrFail($id);
        return Inertia::render('admin.meals.edit', compact('meal'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_cn' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'description_cn' => 'nullable|string',
            'type' => 'required|string|max:50',
            'cuisine' => 'nullable|string|max:100',
        ]);

        $this->mealService->update($id, $validated);

        return redirect()->back()
            ->with('success', 'Meal updated successfully.');
    }

    public function destroy($id)
    {
        $this->mealService->delete($id);

        return redirect()->back()
            ->with('success', 'Meal deleted successfully.');
    }
} 