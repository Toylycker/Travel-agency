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

class TourController extends Controller
{
    

    public function __construct()
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

    
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'string|required',
                'name_cn' => 'string|nullable',
                'main_image' => 'image|required',
                'body' => 'string|required',
                'body_cn' => 'string|nullable',
                'map' => 'string|nullable',
                'total_days' => 'numeric|required',
                'prices' => 'string|required',
                'discount_percent' => 'numeric|nullable',
                'discount_datetime_start' => 'numeric|nullable|date_format',
                'discount_datetime_end' => 'numeric|nullable|date_format',
                'viewed' => 'numeric|nullable',
                'recommended' => 'nullable',
                'days' => 'array|required',
                'detailedPrices' => 'array|required',
                'images' => 'array|required',
                'images.*' => 'Image',
                'included' => 'array|nullable',
                'non_included' => 'array|nullable'
            ]
        );

        DB::transaction(function () use ($request) {
            $tour = Tour::create([
                'name' => $request->name,
                'name_cn' => $request->name_cn,
                'main_image' => 'null',
                'body' => $request->body,
                'body_cn' => $request->body_cn,
                'map' => $request->map,
                'total_days' => $request->total_days,
                'tour_prices' => $request->prices,
                'discount_percent' => $request->discount_percent ?: 0,
                'discount_datetime_start' => $request->discount_datetime_start,
                'discount_datetime_end' => $request->discount_datetime_end,
                'viewed' => $request->viewed ?: 0,
                'recommended' => $request->recommended,
            ]);
    
            if ($request->has('main_image')) {
                $newImage = $request->file('main_image');
                $resized = Gallery::make($newImage)
                    // ->resize( null, 700, function ($constraint) { $constraint->aspectRatio(); } )
                    ->fit(1400, 800)
                    ->encode('jpg', 100);
                $newImageName = Str::random(10) . '-' . $tour->id . '.' . $newImage->getClientOriginalExtension();
                Storage::put('public/tours/' . $newImageName, (string) $resized);
                // $resized->storeAs('public/tours/', $newImageName);
    
                $tour->main_image = $newImageName;
                $tour->update();
            }
    
    
            if ($request->has('included')) {
                foreach ($request->included as $note) {
                    $tour->notes()->attach($note, ['status' => 'included']);
                }
            }
    
            if ($request->has('non_included')) {
                foreach ($request->non_included as $note) {
                    $tour->notes()->attach($note, ['status' => 'non included']);
                }
            }
    
            foreach ($request->days as $day) {
                $newDay = new Day();
                $newDay->day_number = $day['day_number'];
                $newDay->title = $day['title'];
                $newDay->body = $day['body'];
                $newDay->body_cn = $day['body_cn'];
                $newDay->tour_id = $tour->id;
                $newDay->save();
                if (collect($day['places'])->count()>=1) {
                    $newDay->places()->attach($day['places']);
                }
                // if (collect($day['hotels'])->count()>=1) {
    
                //     $newDay->hotels()->attach($day['hotels']);
                // }
            }
    
            if ($request->has('images')) {
                foreach ($request->images as $image) {
                    $newImage = $image;
                    $resized = Gallery::make($newImage)
                        // ->resize( null, 700, function ($constraint) { $constraint->aspectRatio(); } )
                        ->fit(1280, 1024)
                        ->encode('jpg', 100);
                    $newImageName = Str::random(10) . '-' . $tour->id . '.' . $newImage->getClientOriginalExtension();
                    Storage::put('public/tours/' . $newImageName, (string) $resized);
                    Image::create(['name' => $newImageName, 'imageable_id' => $tour->id, 'imageable_type' => 'App\Models\Tour']);
                }
            }
    
            if ($request->has('detailedPrices')) {
                foreach ($request->detailedPrices as $price) {
                    Price::create(['name' => $price['name'], 'price' => $price['price'], 'name_cn' => $price['name_cn'], 'price_cn' => $price['price_cn'],'priceable_id' => $tour->id, 'priceable_type' => 'App\Models\Tour']);
                }
            }
        });

        return Redirect()->back();
    }

    

    
    public function edit(Tour $tour)
    {
        $places = Place::all('name', 'id');
        $hotels = Hotel::all('name', 'id');
        $notes = Note::all('name', 'id');
        $days = Day::where('tour_id', $tour->id)->with(['places:id', 'hotels'])->get();
        $tour->load(['notes', 'prices', 'days.hotels', 'included', 'non_included', 'images']);
        return Inertia::render('admin/Tours/edit', [
            'tour' => $tour,
            'places' => $places,
            'hotels' => $hotels,
            'notes' => $notes,
            'days' => DayResource::collection($days),
            'included' => $tour->included->pluck('id'),
            'non_included' => $tour->non_included->pluck('id'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tour  $tour
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tour $tour)
    {
        dd($request->collect());
    }

    public function destroy(Tour $tour)
    {
        $tour->delete();

        return Redirect()->back();
    }

    public function putName($tour_id, Request $request)
    {
        $tour = Tour::findOrFail($tour_id);
        $tour->name = $request->name;
        $tour->update();
        return redirect()->back();
    }

    public function putName_cn($tour_id, Request $request)
    {
        $tour = Tour::findOrFail($tour_id);
        $tour->name_cn = $request->name_cn;
        $tour->update();
        return redirect()->back();
    }

    public function putMainImage($tour_id, Request $request)
    {
        $tour = Tour::findOrFail($tour_id);
        $request->validate([
            'main_image' => ['required', 'image'],
        ]);

        if ($request->main_image) {
            Storage::delete('public/tours/' . $tour->main_image);
            $newImage = $request->file('main_image');
            $resized = Gallery::make($newImage)
                // ->resize( null, 700, function ($constraint) { $constraint->aspectRatio(); } )
                ->fit(1400, 800)
                ->encode('jpg', 100);
            $newImageName = Str::random(10) . '-' . $tour->id . '.' . $newImage->getClientOriginalExtension();
            Storage::put('public/tours/' . $newImageName, (string) $resized);
            // $resized->storeAs('public/tours/', $newImageName);

            $tour->main_image = $newImageName;
            $tour->update();
        } else {
            return 'false';
        }
        return redirect()->back();
    }

    public function putbody(Request $request, $tour_id)
    {

        $tour = Tour::findOrFail($tour_id);
        $tour->body = $request->body;
        $tour->update();
        return redirect()->back();
    }

    public function putbody_cn(Request $request, $tour_id)
    {

        $tour = Tour::findOrFail($tour_id);
        $tour->body_cn = $request->body_cn;
        $tour->update();
        return redirect()->back();
    }

    public function putTourPrices(Request $request, $tour_id)
    {
        $tour = Tour::findOrFail($tour_id);
        $tour->tour_prices = $request->tour_prices;
        $tour->update();
        return redirect()->back();
    }

    public function putTotalDays(Request $request, $tour_id)
    {
        $tour = Tour::findOrFail($tour_id);

        $tour->total_days = $request->total_days;
        $tour->update();
        return redirect()->back();
    }

    public function putViewed(Request $request, $tour_id)
    {
        $tour = Tour::findOrFail($tour_id);
        $tour->viewed = $request->viewed;
        $tour->update();
        return redirect()->back();
    }

    public function putRecommended(Request $request, $tour_id)
    {
        $tour = Tour::findOrFail($tour_id);
        // return $tour->recommended;
        $tour->recommended = $request->recommended;
        $tour->update();
        return redirect()->back();
    }

    public function putImages(Request $request, $tour_id)
    {
        $tour = Tour::findOrFail($tour_id);

        if ($request->has('images')) {
            $files =  $tour->images->pluck('name');
            foreach ($files as $file_name) {
                Storage::delete('public/tours/' . $file_name);
            }
            $tour->images()->delete();
            foreach ($request->images as $image) {
                $newImage = $image;
                $resized = Gallery::make($newImage)
                    // ->resize( null, 700, function ($constraint) { $constraint->aspectRatio(); } )
                    ->fit(1280, 1024)
                    ->encode('jpg', 100);
                $newImageName = Str::random(10) . '-' . $tour->id . '.' . $newImage->getClientOriginalExtension();
                Storage::put('public/tours/' . $newImageName, (string) $resized);
                Image::create(['name' => $newImageName, 'imageable_id' => $tour->id, 'imageable_type' => 'App\Models\Tour']);
            }
        }else{return "could not save";}

        return redirect()->back();
    }

    public function putNotes(Request $request, $tour_id)
    {
        $included = $request->included;
        $non_included = $request->non_included;
        $tour = Tour::findOrFail($tour_id);
        $tour->included()->syncWithPivotValues($request->included, ['status' => 'included']);
        $tour->non_included()->syncWithPivotValues($request->non_included, ['status' => 'non included']);
        return redirect()->back();
    }

    public function putPrices(Request $request, $tour_id)
    {
        
        $tour = Tour::findOrFail($tour_id);
        if ($request->has('detailedPrices')) {
            DB::transaction(function () use ($request, $tour) {
                $tour->prices()->delete();
                foreach ($request->detailedPrices as $price) {
                    Price::create(['name' => $price['name'],'name_cn' => $price['name_cn'], 'price' => $price['price'], 'priceable_id' => $tour->id, 'priceable_type' => 'App\Models\Tour']);
                }
            });
        }else{return 'false';}

        return redirect()->back();
    }

    public function putDays(Request $request, $tour_id)
    {
        $tour = Tour::findOrFail($tour_id);
        DB::transaction(function () use ($tour, $request) {
            $tour->days()->delete();
            foreach ($request->days as $day) {
                $newDay = new Day();
                $newDay->day_number = $day['day_number'];
                $newDay->title = $day['title'];
                $newDay->body = $day['body'];
                $newDay->body_cn = array_key_exists( 'body_cn', $day)?$day['body_cn']:null;
                $newDay->tour_id = $tour->id;
                $newDay->save();
                if (collect($day['places'])->count()>=1) {
                    $newDay->places()->attach($day['places']?:[]);
                }
                if (collect($day['hotels'])->count()>=1) {
    
                    $newDay->hotels()->attach($day['hotels']);
                }
            }
        });

        return redirect()->back();
    }

    public function putMap(Request $request, $tour_id){
        $tour = Tour::findOrFail($tour_id);
        $tour->map = $request->map;
        $tour->update();

        return redirect()->back();

    }
}
