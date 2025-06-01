<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Room;
use App\Services\RoomService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RoomController extends Controller
{
    public function __construct(protected RoomService $roomService)
    {
    }

    public function index(Request $request)
    {
        $rooms = $this->roomService->getModel()
            ->with('hotel:id,name') // Eager load hotel for sorting and display
            ->when($request->input('sort'), function ($query, $sort) use ($request) {
                $direction = $request->input('direction', 'asc');
                if ($sort === 'hotel') {
                    return $query->orderBy(Hotel::select('name')->whereColumn('hotels.id', 'rooms.hotel_id'), $direction);
                }
                return $query->orderBy($sort, $direction);
            })
            ->paginate($request->input('per_page', 10))
            ->withQueryString();

        return Inertia::render('admin/Rooms/Index', compact('rooms'));
    }

    public function create()
    {
        $hotels = Hotel::select('id', 'name')->get();
        return Inertia::render('admin/Rooms/Create', compact('hotels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_cn' => 'nullable|string|max:255',
            'body' => 'nullable|string',
            'body_cn' => 'nullable|string',
            'room_quan' => 'required|integer|min:1',
            'hotel_id' => 'required|exists:hotels,id',
            'price' => 'required|numeric|min:0',
            'discount_percent' => 'nullable|integer|min:0|max:100',
            'discount_datetime_start' => 'nullable|date',
            'discount_datetime_end' => 'nullable|date|after_or_equal:discount_datetime_start',
        ]);

        $this->roomService->create($validated);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Room created successfully.');
    }

    public function edit(Room $room)
    {
        $hotels = Hotel::select('id', 'name')->get();
        return Inertia::render('admin/Rooms/Edit', [
            'room' => $room,
            'hotels' => $hotels,
            'errors' => session()->get('errors') ? session()->get('errors')->getBag('default')->getMessages() : (object)[],
        ]);
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'name_cn' => 'nullable|string|max:255',
            'body' => 'nullable|string',
            'body_cn' => 'nullable|string',
            'room_quan' => 'sometimes|required|integer|min:1',
            'hotel_id' => 'sometimes|required|exists:hotels,id',
            'price' => 'sometimes|required|numeric|min:0',
            'discount_percent' => 'nullable|integer|min:0|max:100',
            'discount_datetime_start' => 'nullable|date',
            'discount_datetime_end' => 'nullable|date|after_or_equal:discount_datetime_start',
        ]);

        $this->roomService->update($room->id, $validated);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        $this->roomService->delete($room->id);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Room deleted successfully.');
    }
}