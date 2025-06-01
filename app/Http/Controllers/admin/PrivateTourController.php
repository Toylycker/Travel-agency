<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\Day;
use App\Models\Place;
use Illuminate\Support\Str;
use App\Models\Hotel;
use App\Models\Guide;
use App\Models\Transportation;
use Illuminate\Support\Facades\Storage;
use App\Models\Meal;
use App\Models\Image;
use App\Models\Note;
use App\Models\CustomCost;
use Intervention\Image\ImageManagerStatic as Gallery;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Services\TourService;

class PrivateTourController extends Controller
{

    public function __construct(protected TourService $tourService){}

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
        $transportations = Transportation::costsWithoutDays()->get();
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

    public function edit(Tour $tour)
    {
        $tour->load([
            'days.costs' => function ($query) {
                $query->with('costable')->without('days');
            },
            'notes',
            'images'
        ]);

        // Prepare main image URL
        $tour->main_image_url = $tour->main_image ? Storage::url('public/tours/' . $tour->main_image) : null;

        // Prepare additional images URLs
        $tour->additional_images_urls = $tour->images->map(function ($image) {
            return ['id' => $image->id, 'url' => Storage::url('public/tours/' . $image->name)];
        });

        $places = Place::costsWithoutDays()->select(['id', 'name'])->get();
        $hotels_for_room_selection = Hotel::with(['rooms' => function ($query) {
            $query->costsWithoutDays()->select(['id', 'hotel_id', 'name']);
        }])
        ->select(['id', 'name'])
        ->get()
        ->map(function ($hotel) {
            return [
                'type' => 'group',
                'label' => $hotel->name,
                'key' => 'hotel_group_' . $hotel->id,
                'children' => $hotel->rooms->map(function ($room) use ($hotel) {
                    return [
                        'label' => $room->name,
                        'value' => $room->id,
                        'costs' => $room->costs,
                    ];
                })->filter(fn($room) => !empty($room['value']))
                ->values()
            ];
        })
        ->filter(fn($hotel_group) => $hotel_group['children']->isNotEmpty())
        ->values();
        $guides = Guide::costsWithoutDays()->select(['id', 'name'])->get();
        $transportations = Transportation::costsWithoutDays()->get();
        $meals = Meal::costsWithoutDays()->select(['id', 'name'])->get();
        $notes = Note::select(['id', 'name'])->get();
        $customCosts = CustomCost::costsWithoutDays()->select(['id', 'name'])->get();

        return Inertia::render('admin/PrivateTours/Edit', [
            'tour' => $tour,
            'places' => $places,
            'roomOptions' => $hotels_for_room_selection,
            'guides' => $guides,
            'transportations' => $transportations,
            'meals' => $meals,
            'form_notes' => $notes,
            'custom_costs' => $customCosts,
        ]);
    }

    private function getPrivateTourValidationRules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'name_cn' => 'nullable|string|max:255',
            'main_image' => 'nullable|image', // For file input
            'body' => 'required|string',
            'body_cn' => 'nullable|string',
            'map' => 'nullable|string',
            'total_days' => 'required|integer|min:1',
            'prices' => 'nullable|string', // This is tour_prices text
            'discount_percent' => 'nullable|integer|min:0|max:100',
            'discount_datetime_start' => 'nullable|date',
            'discount_datetime_end' => 'nullable|date|after_or_equal:discount_datetime_start',
            'viewed' => 'nullable|integer|min:0',
            'recommended' => 'boolean',
            'active' => 'boolean',
            'sort_order' => 'nullable|integer',
            'images.*' => 'nullable|image', // For file inputs
            'included' => 'nullable|array',
            'included.*' => 'integer|exists:notes,id',
            'non_included' => 'nullable|array',
            'non_included.*' => 'integer|exists:notes,id',
            'days' => 'required|array|min:1',
            'days.*.id' => 'nullable|integer|exists:days,id', // For existing days in update
            'days.*.day_number' => 'required|integer|min:1',
            'days.*.title' => 'required|string|max:255',
            'days.*.body' => 'nullable|string',
            'days.*.body_cn' => 'nullable|string',
            'days.*.cost_entries' => 'nullable|array',
            'days.*.cost_entries.*.cost_id' => 'required|integer|exists:costs,id',
            'days.*.cost_entries.*.quantity' => 'nullable|integer|min:1',
            'days.*.cost_entries.*.notes' => 'nullable|string',
        ];
    }

    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), $this->getPrivateTourValidationRules())->validate();

        $serviceData = array_merge($validatedData, [
            'main_image_file' => $request->file('main_image'),
            'additional_images_files' => $request->file('images'),
            'is_public' => false, // Explicitly set for private tours
        ]);

        try {
            $this->tourService->createNewTour($serviceData);
            return redirect()->back()->with('success', 'Private tour created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to create private tour: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, Tour $tour)
    {
        $validatedData = Validator::make($request->all(), $this->getPrivateTourValidationRules())->validate();
        
        $serviceData = array_merge($validatedData, [
            'main_image_file' => $request->file('main_image'),
            'additional_images_files' => $request->file('images'),
            'is_public' => false, // Ensure it remains a private tour
            // For additional images, PrivateTourController's original logic appended images.
            // TourService defaults to append. If sync (replace all) is needed, pass strategy:
            // 'additional_images_sync_strategy' => 'sync'
        ]);

        try {
            $this->tourService->updateExistingTour($tour, $serviceData);
            return redirect()->back()->with('success', 'Private tour updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to update private tour: ' . $e->getMessage()]);
        }
    }
} 