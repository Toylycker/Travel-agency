<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\Day;
use App\Models\Place;
use App\Models\Room;
use App\Models\Hotel;
use App\Models\Guide;
use App\Models\Transportation;
use App\Models\Meal;
use App\Models\Cost;
use App\Models\Note;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PrivateTourController extends Controller
{
    public function create()
    {
        $places = Place::with('costs')->select(['id', 'name'])->get();
        $rooms = Room::with(['costs', 'hotel:id,name'])->select(['id', 'name', 'hotel_id'])->get()->map(function($room){
            return [
                'id' => $room->id,
                'name' => ($room->hotel ? $room->hotel->name . ' - ' : '') . $room->name,
                'costs' => $room->costs
            ];
        });
        $guides = Guide::with('costs')->select(['id', 'name'])->get();
        $transportations = Transportation::with('costs')->select(['id', 'model as name'])->get();
        $meals = Meal::with('costs')->select(['id', 'name'])->get();
        $notes = Note::select(['id', 'name'])->get();

        return Inertia::render('admin/PrivateTours/Create', [
            'places' => $places,
            'rooms' => $rooms,
            'guides' => $guides,
            'transportations' => $transportations,
            'meals' => $meals,
            'form_notes' => $notes,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'name_cn' => 'nullable|string|max:255',
            'main_image' => 'nullable|image|max:2048',
            'body' => 'required|string',
            'body_cn' => 'nullable|string',
            'map' => 'nullable|string',
            'total_days' => 'required|integer|min:1',
            'prices' => 'nullable|string',
            'discount_percent' => 'nullable|integer|min:0|max:100',
            'discount_datetime_start' => 'nullable|date',
            'discount_datetime_end' => 'nullable|date|after_or_equal:discount_datetime_start',
            'viewed' => 'nullable|integer|min:0',
            'recommended' => 'boolean',
            'isPublic' => 'boolean',
            'active' => 'boolean',
            'sort_order' => 'nullable|integer',
            'images.*' => 'nullable|image|max:2048',
            'included' => 'nullable|array',
            'included.*' => 'integer|exists:notes,id',
            'non_included' => 'nullable|array',
            'non_included.*' => 'integer|exists:notes,id',
            'detailedPrices' => 'nullable|array',
            'detailedPrices.*.name' => 'required_with:detailedPrices|string|max:255',
            'detailedPrices.*.price' => 'required_with:detailedPrices|numeric|min:0',
            'detailedPrices.*.name_cn' => 'nullable|string|max:255',
            'detailedPrices.*.price_cn' => 'nullable|numeric|min:0',
            'days' => 'required|array|min:1',
            'days.*.day_number' => 'required|integer|min:1',
            'days.*.title' => 'required|string|max:255',
            'days.*.body' => 'nullable|string',
            'days.*.body_cn' => 'nullable|string',
            'days.*.cost_entries' => 'nullable|array',
            'days.*.cost_entries.*.cost_id' => 'required|integer|exists:costs,id',
            'days.*.cost_entries.*.notes' => 'nullable|string|max:1000',
        ])->validate();

        try {
            DB::beginTransaction();

            $tour = new Tour();
            $tour->name = $validatedData['name'];
            $tour->name_cn = $validatedData['name_cn'] ?? null;
            $tour->body = $validatedData['body'];
            $tour->body_cn = $validatedData['body_cn'] ?? null;
            $tour->map = $validatedData['map'] ?? null;
            $tour->total_days = $validatedData['total_days'];
            $tour->tour_prices = $validatedData['prices'] ?? '0';
            $tour->discount_percent = $validatedData['discount_percent'] ?? 0;
            $tour->discount_datetime_start = $validatedData['discount_datetime_start'] ?? null;
            $tour->discount_datetime_end = $validatedData['discount_datetime_end'] ?? null;
            $tour->viewed = $validatedData['viewed'] ?? 0;
            $tour->recommended = $validatedData['recommended'] ?? false;
            $tour->isPublic = $validatedData['isPublic'] ?? false;
            $tour->active = $validatedData['active'] ?? true;
            $tour->sort_order = $validatedData['sort_order'] ?? null;

            if ($request->hasFile('main_image')) {
                $tour->main_image = $request->file('main_image')->store('tour_images', 'public');
            }

            $tour->save();

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $path = $file->store('tour_images', 'public');
                }
            }
            
            if (isset($validatedData['included'])) {
            }
            if (isset($validatedData['non_included'])) {
            }

            if (isset($validatedData['detailedPrices'])) {
                foreach ($validatedData['detailedPrices'] as $priceData) {
                }
            }

            foreach ($validatedData['days'] as $dayData) {
                $day = new Day();
                $day->tour_id = $tour->id;
                $day->day_number = $dayData['day_number'];
                $day->title = $dayData['title'];
                $day->body = $dayData['body'] ?? null;
                $day->body_cn = $dayData['body_cn'] ?? null;
                $day->save();

                if (!empty($dayData['cost_entries'])) {
                    foreach ($dayData['cost_entries'] as $costEntry) {
                        $day->costs()->attach($costEntry['cost_id'], ['notes' => $costEntry['notes'] ?? null]);
                    }
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Private tour created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to create private tour: ' . $e->getMessage()]);
        }
    }
} 