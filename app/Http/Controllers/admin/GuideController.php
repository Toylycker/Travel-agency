<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guide;
use App\Services\GuideService;
use Illuminate\Http\Request;
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
            'name_cn' => 'nullable|string|max:255',
            'email' => 'required|email|unique:guides,email',
            'phone' => 'required|string|max:20',
            'languages' => 'required|string',
            'bio' => 'nullable|string',
            'bio_cn' => 'nullable|string',
            'certifications' => 'nullable|string',
            'availability' => 'nullable|string',
        ]);

        $guide = $this->guideService->create($validated);

        return redirect()->back()
            ->with('success', 'Guide created successfully.');
    }

    public function show(Guide $guide)
    {
        return Inertia::render('admin/Guides/Show', compact('guide'));
    }

    public function edit(Guide $guide)
    {
        return Inertia::render('admin/Guides/Edit', compact('guide'));
    }

    public function update(Request $request, Guide $guide)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_cn' => 'nullable|string|max:255',
            'email' => 'required|email|unique:guides,email,' . $guide->id,
            'phone' => 'required|string|max:20',
            'languages' => 'required|string',
            'bio' => 'nullable|string',
            'bio_cn' => 'nullable|string',
            'certifications' => 'nullable|string',
            'availability' => 'nullable|string',
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