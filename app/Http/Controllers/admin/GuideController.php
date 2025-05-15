<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        return Inertia::render('admin.guides.index', compact('guides'));
    }

    public function create()
    {
        return Inertia::render('admin.guides.create');
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

    public function show($id)
    {
        $guide = $this->guideService->findOrFail($id);
        return Inertia::render('admin.guides.show', compact('guide'));
    }

    public function edit($id)
    {
        $guide = $this->guideService->findOrFail($id);
        return Inertia::render('admin.guides.edit', compact('guide'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_cn' => 'nullable|string|max:255',
            'email' => 'required|email|unique:guides,email,' . $id,
            'phone' => 'required|string|max:20',
            'languages' => 'required|string',
            'bio' => 'nullable|string',
            'bio_cn' => 'nullable|string',
            'certifications' => 'nullable|string',
            'availability' => 'nullable|string',
        ]);

        $this->guideService->update($id, $validated);

        return redirect()->back()
            ->with('success', 'Guide updated successfully.');
    }

    public function destroy($id)
    {
        $this->guideService->delete($id);

        return redirect()->back()
            ->with('success', 'Guide deleted successfully.');
    }
} 