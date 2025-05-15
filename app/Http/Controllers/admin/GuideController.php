<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\GuideService;
use Illuminate\Http\Request;

class GuideController extends Controller
{
    protected $guideService;

    public function __construct(GuideService $guideService)
    {
        $this->guideService = $guideService;
    }

    public function index()
    {
        $guides = $this->guideService->all();
        return view('admin.guides.index', compact('guides'));
    }

    public function create()
    {
        return view('admin.guides.create');
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

        return redirect()->route('admin.guides.index')
            ->with('success', 'Guide created successfully.');
    }

    public function show($id)
    {
        $guide = $this->guideService->findOrFail($id);
        return view('admin.guides.show', compact('guide'));
    }

    public function edit($id)
    {
        $guide = $this->guideService->findOrFail($id);
        return view('admin.guides.edit', compact('guide'));
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

        return redirect()->route('admin.guides.index')
            ->with('success', 'Guide updated successfully.');
    }

    public function destroy($id)
    {
        $this->guideService->delete($id);

        return redirect()->route('admin.guides.index')
            ->with('success', 'Guide deleted successfully.');
    }
} 