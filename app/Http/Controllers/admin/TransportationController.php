<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\TransportationService;
use Illuminate\Http\Request;

class TransportationController extends Controller
{
    public function __construct(protected TransportationService $transportationService)
    {
    }

    public function index()
    {
        $transportations = $this->transportationService->all();
        return view('admin.transportations.index', compact('transportations'));
    }

    public function create()
    {
        return view('admin.transportations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_cn' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'description_cn' => 'nullable|string',
        ]);

        $transportation = $this->transportationService->create($validated);

        return redirect()->route('admin.transportations.index')
            ->with('success', 'Transportation created successfully.');
    }

    public function show($id)
    {
        $transportation = $this->transportationService->findOrFail($id);
        return view('admin.transportations.show', compact('transportation'));
    }

    public function edit($id)
    {
        $transportation = $this->transportationService->findOrFail($id);
        return view('admin.transportations.edit', compact('transportation'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_cn' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'description_cn' => 'nullable|string',
        ]);

        $this->transportationService->update($id, $validated);

        return redirect()->route('admin.transportations.index')
            ->with('success', 'Transportation updated successfully.');
    }

    public function destroy($id)
    {
        $this->transportationService->delete($id);

        return redirect()->route('admin.transportations.index')
            ->with('success', 'Transportation deleted successfully.');
    }
} 