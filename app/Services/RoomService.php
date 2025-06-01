<?php

namespace App\Services;

use App\Models\Room;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class RoomService extends BaseService
{
    public function __construct(Room $room)
    {
        parent::__construct($room);
    }

    public function getPaginatedRooms(Request $request): LengthAwarePaginator
    {
        $query = $this->model->query()->with('hotel:id,name');

        // Filtering by hotel
        if ($request->filled('hotel_id')) {
            $query->where('hotel_id', $request->input('hotel_id'));
        }

        // Sorting
        if ($request->filled('sort')) {
            $sort = $request->input('sort');
            // Sanitize direction: default to 'asc', ensure it's 'asc' or 'desc'
            $directionInput = strtolower($request->input('direction', 'asc'));
            $direction = in_array($directionInput, ['asc', 'desc']) ? $directionInput : 'asc';

            if ($sort === 'hotel') {
                // Sort by related hotel's name using a subquery
                $query->orderBy(
                    Hotel::select('name')->whereColumn('hotels.id', 'rooms.hotel_id'),
                    $direction
                );
            } else {
                // Add table prefix to sort column to avoid ambiguity if other tables were joined
                // For simple cases like this, $this->model->getTable() . '.' . $sort might be safer
                // but direct $sort is usually fine if it's a column of the Room model.
                $query->orderBy($sort, $direction);
            }
        } else {
            // Default sort order if no sort parameter is provided
            $query->orderBy($this->model->getTable().'.id', 'desc'); // Example: default sort by room ID descending
        }

        return $query->paginate($request->input('per_page', 10))
            ->withQueryString(); // Appends query string parameters to pagination links
    }
} 