<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
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
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class TourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tours = Tour::with(['days'=>function($query){
            $query->orderBy('id');
        }])->orderBy('id')->paginate(5)->withQueryString();
        $places = Place::all('name', 'id');
        $hotels = Hotel::all('name', 'id');
        $notes = Note::all('name', 'id');
        return Inertia::render('admin/Tours/index', ['tours'=>$tours, 'places'=>$places, 'hotels'=>$hotels, 'notes'=>$notes]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name'=>'string|required',
                'main_image'=>'image|required',
                'body'=>'string|required',
                'total_days'=>'numeric|required',
                'prices'=>'string|required',
                'discount_percent'=>'numeric|nullable',
                'discount_datetime_start'=>'numeric|nullable|date_format',
                'discount_datetime_end'=>'numeric|nullable|date_format',
                'viewed'=>'numeric|nullable',
                'recommended'=>'nullable',
                'days'=>'array|required',
                'detailedPrices'=>'array|required',
                'images'=>'array|required',
                'images.*'=>'Image',
                'included'=>'array|nullable',
                'non_included'=>'array|nullable'
            ]);


            $tour = Tour::create([
                'name'=>$request->name,
                'main_image'=>'null',
                'body'=>$request->body,
                'total_days'=>$request->total_days,
                'prices'=>$request->prices,
                'discount_percent'=>$request->discount_percent,
                'discount_datetime_start'=>$request->discount_datetime_start,
                'discount_datetime_end'=>$request->discount_datetime_end,
                'viewed'=>$request->viewed?:0,
                'recommended'=>$request->recommended,
            ]);

                if ($request->has('main_image')) {
                    $newImage = $request->file('main_image');
                    $resized = Gallery::make($newImage)
                    // ->resize( null, 700, function ($constraint) { $constraint->aspectRatio(); } )
                    ->fit(1400, 800)
                    ->encode('jpg',100);
                    $newImageName = Str::random(10) . '-' . $tour->id . '.' . $newImage->getClientOriginalExtension();
                    Storage::put('public/tours/'. $newImageName, (string) $resized);
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
                $newDay->tour_id = $tour->id;
                $newDay->save();
                $newDay->places()->attach($day['places']);
                $newDay->hotels()->attach($day['hotels']);
            }

            if ($request->has('images')) {
                foreach ($request->images as $image) {
                    $newImage = $image;
                    $resized = Gallery::make($newImage)
                    // ->resize( null, 700, function ($constraint) { $constraint->aspectRatio(); } )
                    ->fit(1280, 1024)
                    ->encode('jpg',100);
                    $newImageName = Str::random(10) . '-' . $tour->id . '.' . $newImage->getClientOriginalExtension();
                    Storage::put('public/tours/'. $newImageName, (string) $resized);
                    Image::create(['name'=>$newImageName, 'imageable_id'=>$tour->id, 'imageable_type'=>'App\Models\Tour' ]);
                }
            }

            if ($request->has('detailedPrices')) {
                foreach ($request->detailedPrices as $price) {
                    Price::create(['name'=>$price['name'], 'price'=>$price['price'], 'priceable_id'=>$tour->id, 'priceable_type'=>'App\Models\Tour']);
                }
            }

            return Redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tour  $tour
     * @return \Illuminate\Http\Response
     */
    public function show(Tour $tour)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tour  $tour
     * @return \Illuminate\Http\Response
     */
    public function edit(Tour $tour)
    {
        $places = Place::all('name', 'id');
        $hotels = Hotel::all('name', 'id');
        $notes = Note::all('name', 'id');
        $tour->load(['notes', 'prices', 'days.places', 'days.hotels', 'included', 'non_included']);
        return Inertia::render('admin/Tours/edit', ['tour'=>$tour,
         'places'=>$places,
          'hotels'=>$hotels,
           'notes'=>$notes,
        //    'included'=>$tour->notes->wherePivot('status', 'included'),
        //    'non_included'=>$tour->notes->wherePivot('status', 'non_included'),
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tour  $tour
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tour $tour)
    {
        $tour->delete();

        return Redirect()->back();
    }
}
