<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\MealService;
use Illuminate\Http\Request;

class MealController extends Controller
{
    protected $mealService;

    public function __construct(MealService $mealService)
    {
        $this->mealService = $mealService;
    }

    public function index()
    {
        $meals = $this->mealService->all();
        return view('admin.meals.index', compact('meals'));
    }

    public function create()
    {
        return view('admin.meals.create');
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

        return redirect()->route('admin.meals.index')
            ->with('success', 'Meal created successfully.');
    }

    public function show($id)
    {
        $meal = $this->mealService->findOrFail($id);
        return view('admin.meals.show', compact('meal'));
    }

    public function edit($id)
    {
        $meal = $this->mealService->findOrFail($id);
        return view('admin.meals.edit', compact('meal'));
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

        return redirect()->route('admin.meals.index')
            ->with('success', 'Meal updated successfully.');
    }

    public function destroy($id)
    {
        $this->mealService->delete($id);

        return redirect()->route('admin.meals.index')
            ->with('success', 'Meal deleted successfully.');
    }
} 