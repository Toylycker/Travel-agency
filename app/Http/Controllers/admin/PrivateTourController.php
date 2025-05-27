<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\Day;
use App\Models\Place;
use App\Models\Room;
use Illuminate\Support\Str;
use App\Models\Hotel;
use App\Models\Guide;
use App\Models\Transportation;
use Illuminate\Support\Facades\Storage;
use App\Models\Meal;
use App\Models\Cost;
use App\Models\Image;
use App\Models\Note;
use App\Models\Price;
use App\Models\CustomCost;
use Intervention\Image\ImageManagerStatic as Gallery;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PrivateTourController extends Controller
{
    public function create()
    {
        $places = Place::costsWithoutDays()->select(['id', 'name'])->get();

        // New logic for rooms grouped by hotel
        $hotels_for_room_selection = Hotel::with(['rooms' => function ($query) {
            $query->costsWithoutDays()->select(['id', 'hotel_id', 'name']); // Ensure room.costs is loaded
        }])
        ->select(['id', 'name']) // Hotel fields
        ->get()
        ->map(function ($hotel) {
            return [
                'type' => 'group', // For n-select to render as a non-selectable group label
                'label' => $hotel->name,
                'key' => 'hotel_group_' . $hotel->id, // Unique key for the group
                'children' => $hotel->rooms->map(function ($room) use ($hotel) { // Added 'use ($hotel)'
                    return [
                        'label' => $room->name, // Room name (hotel name is group label)
                        'value' => $room->id,    // Actual Room ID to be used as value
                        'costs' => $room->costs, // Attach room's costs here
                    ];
                })->filter(fn($room) => !empty($room['value']))
                ->values()
            ];
        })
        ->filter(fn($hotel_group) => $hotel_group['children']->isNotEmpty()) // Only hotels with rooms
        ->values();

        $guides = Guide::costsWithoutDays()->select(['id', 'name'])->get();
        $transportations = Transportation::costsWithoutDays()->select(['id', 'model as name'])->get();
        $meals = Meal::costsWithoutDays()->select(['id', 'name'])->get();
        $notes = Note::select(['id', 'name'])->get();
        $customCosts = CustomCost::costsWithoutDays()->select(['id', 'name'])->get();

        return Inertia::render('admin/PrivateTours/Create', [
            'places' => $places,
            'roomOptions' => $hotels_for_room_selection,
            'guides' => $guides,
            'transportations' => $transportations,
            'meals' => $meals,
            'form_notes' => $notes,
            'custom_costs' => $customCosts,
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
            // 'detailedPrices' => 'nullable|array',
            // 'detailedPrices.*.name' => 'required_with:detailedPrices|string|max:255',
            // 'detailedPrices.*.price' => 'required_with:detailedPrices|numeric|min:0',
            // 'detailedPrices.*.name_cn' => 'nullable|string|max:255',
            // 'detailedPrices.*.price_cn' => 'nullable|numeric|min:0',
            'days' => 'required|array|min:1',
            'days.*.day_number' => 'required|integer|min:1',
            'days.*.title' => 'required|string|max:255',
            'days.*.body' => 'nullable|string',
            'days.*.body_cn' => 'nullable|string',
            'days.*.cost_entries' => 'nullable|array',
            'days.*.cost_entries.*.cost_id' => 'required|integer|exists:costs,id',
            'days.*.cost_entries.*.quantity' => 'nullable|integer|min:1',
            'days.*.cost_entries.*.notes' => 'nullable|text',
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
                $newImage = $request->file('main_image');
                $resized = Gallery::make($newImage)
                    ->fit(1400, 800)
                    ->encode('jpg', 100);
                $newImageName = Str::random(10) . '.' . $newImage->getClientOriginalExtension();
                Storage::put('public/tours/' . $newImageName, (string) $resized);
                $tour->main_image = $newImageName;
            }

            $tour->save();

            if ($request->has('images')) {
                foreach ($request->file('images') as $imageFile) {
                    $resized = Gallery::make($imageFile)
                        ->fit(1280, 1024)
                        ->encode('jpg', 100);
                    $newImageName = Str::random(10) . '-' . $tour->id . '.' . $imageFile->getClientOriginalExtension();
                    Storage::put('public/tours/' . $newImageName, (string) $resized);
                    Image::create(['name' => $newImageName, 'imageable_id' => $tour->id, 'imageable_type' => 'App\Models\Tour']);
                }
            }
            
            if (isset($validatedData['included'])) {
                foreach ($request->included as $note) {
                    $tour->notes()->attach($note, ['status' => 'included']);
                }
            }
            if (isset($validatedData['non_included'])) {
                foreach ($request->non_included as $note) {
                    $tour->notes()->attach($note, ['status' => 'non included']);
                }
            }

            // if (isset($validatedData['detailedPrices'])) {
            //     foreach ($request->detailedPrices as $price) {
            //         Price::create(['name' => $price['name'], 'price' => $price['price'], 'name_cn' => $price['name_cn'], 'price_cn' => $price['price_cn'],'priceable_id' => $tour->id, 'priceable_type' => 'App\Models\Tour']);
            //     }
            // }

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
                        $day->costs()->attach($costEntry['cost_id'], ['quantity' => $costEntry['quantity'] ?? 1, 'notes' => $costEntry['notes'] ?? null]);
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