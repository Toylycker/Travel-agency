<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\DayResource;
use Intervention\Image\ImageManagerStatic as Gallery;
use App\Models\Day;
use App\Models\Hotel;
use App\Models\Image;
use App\Models\Note;
use App\Models\Place;
use App\Models\Price;
use App\Models\Tour;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use App\Services\TourService;
use Illuminate\Support\Facades\Validator;

class TourController extends Controller
{

    public function __construct(protected TourService $tourService)
    {
        Cache::forget('tours');
    }

    public function index()
    {
        $tours = Tour::with(['days' => function ($query) {
            $query->orderBy('id');
        }])->orderBy('id')->paginate(5)->withQueryString();
        $places = Place::all('name', 'id');
        $hotels = Hotel::all('name', 'id');
        $notes = Note::all('name', 'id');
        return Inertia::render('admin/Tours/index', ['tours' => $tours, 'places' => $places, 'hotels' => $hotels, 'notes' => $notes]);
    }

    public function create()
    {
        $places = Place::select(['id', 'name'])->get();
        $hotels = Hotel::select(['id', 'name'])->get();
        $notes = Note::select(['id', 'name'])->get();

        return Inertia::render('admin/Tours/Create', [
            'places' => $places,
            'hotels' => $hotels,
            'form_notes' => $notes, // Match prop name in Create.vue
        ]);
    }

    private function getPublicTourValidationRules(bool $isUpdate = false): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'name_cn' => 'nullable|string|max:255',
            'main_image' => ($isUpdate ? 'nullable' : 'required') . '|image|max:2048',
            'body' => 'required|string',
            'body_cn' => 'nullable|string',
            'map' => 'nullable|string',
            'total_days' => 'required|numeric|min:1',
            'prices' => 'required|string',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'discount_datetime_start' => 'nullable|date',
            'discount_datetime_end' => 'nullable|date|after_or_equal:discount_datetime_start',
            'viewed' => 'nullable|numeric|min:0',
            'recommended' => 'boolean',
            'active' => 'boolean',
            'sort_order' => 'nullable|integer',
            'days' => 'required|array|min:1',
            'days.*.day_number' => 'required|integer|min:1',
            'days.*.title' => 'required|string|max:255',
            'days.*.body' => 'required|string',
            'days.*.body_cn' => 'nullable|string',
            'days.*.places' => 'nullable|array',
            'days.*.places.*' => 'integer|exists:places,id',
            'days.*.hotels' => 'nullable|array',
            'days.*.hotels.*' => 'integer|exists:hotels,id',
            'detailedPrices' => 'required|array',
            'detailedPrices.*.name' => 'required|string',
            'detailedPrices.*.price' => 'required|numeric',
            'detailedPrices.*.name_cn' => 'nullable|string',
            'detailedPrices.*.price_cn' => 'nullable|numeric',
            'images' => ($isUpdate ? 'nullable' : 'required') . '|array',
            'images.*' => 'image|max:2048',
            'included' => 'nullable|array',
            'included.*' => 'integer|exists:notes,id',
            'non_included' => 'nullable|array',
            'non_included.*' => 'integer|exists:notes,id',
        ];
        return $rules;
    }

    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), $this->getPublicTourValidationRules())->validate();

        $serviceData = array_merge($validatedData, [
            'main_image_file' => $request->file('main_image'),
            'additional_images_files' => $request->file('images'),
            'isPublic' => true,
            'recommended' => $request->boolean('recommended'),
            'active' => $request->boolean('active', true),
        ]);

        try {
            $this->tourService->createNewTour($serviceData);
            return Redirect::back()->with('success', 'Public tour created successfully!');
        } catch (\Exception $e) {
            return Redirect::back()->withInput()->withErrors(['error' => 'Failed to create public tour: ' . $e->getMessage()]);
        }
    }

    public function edit(Tour $tour)
    {
        $places = Place::all('name', 'id');
        $hotels = Hotel::all('name', 'id');
        $notesData = Note::all('name', 'id');
        $days = $tour->days()->with(['places:id,name', 'hotels:id,name'])->orderBy('day_number')->get();
        $tour->load(['notes', 'prices', 'images']);

        $tourData = $tour->toArray();
        $tourData['main_image_url'] = $tour->main_image ? Storage::url('public/tours/' . $tour->main_image) : null;
        $tourData['additional_images_urls'] = $tour->images->map(function ($image) {
            return ['id' => $image->id, 'url' => Storage::url('public/tours/' . $image->name)];
        });
        
        return Inertia::render('admin/Tours/edit', [
            'tour' => $tourData,
            'places' => $places,
            'hotels' => $hotels,
            'notes' => $notesData,
            'days' => DayResource::collection($days),
            'included' => $tour->notes()->wherePivot('status', 'included')->pluck('notes.id'),
            'non_included' => $tour->notes()->wherePivot('status', 'non included')->pluck('notes.id'),
        ]);
    }

    public function update(Request $request, Tour $tour)
    {
        $validatedData = Validator::make($request->all(), $this->getPublicTourValidationRules(true))->validate();

        $serviceData = array_merge($validatedData, [
            'main_image_file' => $request->file('main_image'),
            'additional_images_files' => $request->file('images'),
            'isPublic' => true,
            'recommended' => $request->boolean('recommended'),
            'active' => $request->boolean('active'),
            'additional_images_sync_strategy' => 'sync'
        ]);

        try {
            $this->tourService->updateExistingTour($tour, $serviceData);
            return Redirect::back()->with('success', 'Public tour updated successfully!');
        } catch (\Exception $e) {
            return Redirect::back()->withInput()->withErrors(['error' => 'Failed to update public tour: ' . $e->getMessage()]);
        }
    }

    public function destroy(Tour $tour)
    {
        if ($tour->main_image && Storage::exists('public/tours/' . $tour->main_image)) {
            Storage::delete('public/tours/' . $tour->main_image);
        }
        foreach ($tour->images as $img) {
            if (Storage::exists('public/tours/' . $img->name)) {
                Storage::delete('public/tours/' . $img->name);
            }
        }
        $tour->delete();
        return Redirect::back()->with('success', 'Tour deleted successfully!');
    }

    public function putName($tour_id, Request $request)
    {
        $tour = Tour::findOrFail($tour_id);
        $this->tourService->updateAttribute($tour, 'name', $request->name);
        return redirect()->back()->with('success', 'Name updated.');
    }

    public function putName_cn($tour_id, Request $request)
    {
        $tour = Tour::findOrFail($tour_id);
        $this->tourService->updateAttribute($tour, 'name_cn', $request->name_cn);
        return redirect()->back()->with('success', 'Chinese name updated.');
    }

    public function putMainImage($tour_id, Request $request)
    {
        $request->validate(['main_image' => ['required', 'image']]);
        $tour = Tour::findOrFail($tour_id);
        if ($request->hasFile('main_image')) {
            $this->tourService->updateMainImage($tour, $request->file('main_image'));
            return redirect()->back()->with('success', 'Main image updated.');
        }
        return redirect()->back()->withErrors(['error' => 'No image provided.']);
    }

    public function putbody(Request $request, $tour_id)
    {
        $tour = Tour::findOrFail($tour_id);
        $this->tourService->updateAttribute($tour, 'body', $request->body);
        return redirect()->back()->with('success', 'Body updated.');
    }

    public function putbody_cn(Request $request, $tour_id)
    {
        $tour = Tour::findOrFail($tour_id);
        $this->tourService->updateAttribute($tour, 'body_cn', $request->body_cn);
        return redirect()->back()->with('success', 'Chinese body updated.');
    }

    public function putTourPrices(Request $request, $tour_id)
    {
        $tour = Tour::findOrFail($tour_id);
        $this->tourService->updateAttribute($tour, 'tour_prices', $request->tour_prices);
        return redirect()->back()->with('success', 'Tour prices text updated.');
    }

    public function putTotalDays(Request $request, $tour_id)
    {
        $tour = Tour::findOrFail($tour_id);
        $this->tourService->updateAttribute($tour, 'total_days', $request->total_days);
        return redirect()->back()->with('success', 'Total days updated.');
    }

    public function putViewed(Request $request, $tour_id)
    {
        $tour = Tour::findOrFail($tour_id);
        $this->tourService->updateAttribute($tour, 'viewed', $request->viewed);
        return redirect()->back()->with('success', 'View count updated.');
    }

    public function putRecommended(Request $request, $tour_id)
    {
        $tour = Tour::findOrFail($tour_id);
        $this->tourService->updateAttribute($tour, 'recommended', $request->boolean('recommended'));
        return redirect()->back()->with('success', 'Recommendation status updated.');
    }

    public function putImages(Request $request, $tour_id)
    {
        $request->validate(['images' => 'required|array', 'images.*' => 'image']);
        $tour = Tour::findOrFail($tour_id);
        if ($request->hasFile('images')) {
            $this->tourService->syncAdditionalImages($tour, $request->file('images'));
            return redirect()->back()->with('success', 'Additional images updated.');
        }
        return redirect()->back()->withErrors(['error' => 'No images provided.']);
    }

    public function putNotes(Request $request, $tour_id)
    {
        $tour = Tour::findOrFail($tour_id);
        $this->tourService->syncNotes($tour, $request->input('included'), $request->input('non_included'));
        return redirect()->back()->with('success', 'Notes updated.');
    }

    public function putPrices(Request $request, $tour_id)
    {
        $request->validate(['detailedPrices' => 'required|array']);
        $tour = Tour::findOrFail($tour_id);
        $this->tourService->syncPricesForPublicTour($tour, $request->input('detailedPrices'));
        return redirect()->back()->with('success', 'Detailed prices updated.');
    }

    public function putDays(Request $request, $tour_id)
    {
        $request->validate(['days' => 'required|array']);
        $tour = Tour::findOrFail($tour_id);
        $this->tourService->syncDaysForPublicTour($tour, $request->input('days'));
        return redirect()->back()->with('success', 'Days updated.');
    }

    public function putMap(Request $request, $tour_id){
        $tour = Tour::findOrFail($tour_id);
        $this->tourService->updateAttribute($tour, 'map', $request->map);
        return redirect()->back()->with('success', 'Map updated.');
    }
}
