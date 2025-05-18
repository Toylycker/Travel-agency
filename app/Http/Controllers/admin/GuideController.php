<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guide;
use App\Services\GuideService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class GuideController extends Controller
{
    public function __construct(protected GuideService $guideService)
    {
    }

    public function index()
    {
        $guides = $this->guideService->all();
        return Inertia::render('admin/Guides/Index', compact('guides'));
    }

    public function create()
    {
        return Inertia::render('admin/Guides/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'nullable|email|unique:guides,email',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string',
            'years_of_experience' => 'nullable|integer|min:0',
            'languages' => 'nullable|array',
            'license_number' => 'nullable|string|max:255',
            'license_expiry' => 'nullable|date',
            'is_active' => 'boolean'
        ]);

        $this->guideService->create($validated);

        return redirect()->back()
        ->with('success', 'Guide created successfully.');
    }

    public function edit(Guide $guide)
    {
        return Inertia::render('admin/Guides/Edit', compact('guide'));
    }

    public function update(Request $request, Guide $guide)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'nullable|email|unique:guides,email,' . $guide->id,
            'phone' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'years_of_experience' => 'nullable|integer|min:0',
            'languages' => 'nullable|array',
            'license_number' => 'nullable|string|max:255',
            'license_expiry' => 'nullable|date',
            'is_active' => 'boolean'
        ]);

        $this->guideService->update($guide->id, $validated);

        return redirect()->back()
            ->with('success', 'Guide updated successfully.');
    }

    public function destroy(Guide $guide)
    {
        $this->guideService->delete($guide->id);

        return redirect()->back()
            ->with('success', 'Guide deleted successfully.');
    }
} 