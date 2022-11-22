<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Image;
use App\Models\Location;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Intervention\Image\ImageManagerStatic as Gallery;
use Illuminate\Support\Str;


class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hotels = Hotel::with('rooms', 'images', 'location')->paginate(10)->withQueryString();
        $locations = Location::all();
        return Inertia::render('admin/Hotels/index', ['locations' =>$locations,'hotels'=>$hotels ]);
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
        $request->validate([
            'name'=>'string|required',
            'stars'=>'numeric|required',
            'location'=>'numeric|required',
            'body'=>'string|required',
            'viewed'=>'nullable',
            'recommended'=>'nullable',
            'main_image'=>'image|required',
            'images'=>'array|required',
            'images.*'=>'Image|required',
            'rooms'=>'array',
        ]);

        $location = Location::findOrFail($request->location);
        $hotel = Hotel::create(['name'=>$request->name, 'location_id'=>$location->id, 'body'=>$request->body, 'viewed'=>$request->viewed, 'recommended'=>$request->recommended, 'stars'=>$request->stars]);
        $rooms = $request->rooms;

        if ($request->has('main_image')) {
            $newImage = $request->file('main_image');
            $resized = Gallery::make($newImage)
            // ->resize( null, 700, function ($constraint) { $constraint->aspectRatio(); } )
            ->fit(800, 1400) //it should be long from up to bottom 
            ->encode('jpg',100);
            $newImageName = Str::random(10) . '-' . $hotel->id . '.' . $newImage->getClientOriginalExtension();
            Storage::put('public/hotels/'. $newImageName, (string) $resized);
            // $resized->storeAs('public/hotels/', $newImageName);
    
            $hotel->main_image = $newImageName;
            $hotel->update();
        }

        if ($request->has('images')) {
            foreach ($request->images as $image) {
                $newImage = $image;
                $resized = Gallery::make($newImage)
                // ->resize( null, 700, function ($constraint) { $constraint->aspectRatio(); } )
                ->fit(1280, 1024)
                ->encode('jpg',100);
                $newImageName = Str::random(10) . '-' . $hotel->id . '.' . $newImage->getClientOriginalExtension();
                Storage::put('public/hotels/'. $newImageName, (string) $resized);
                Image::create(['name'=>$newImageName, 'imageable_id'=>$hotel->id, 'imageable_type'=>'App\Models\Hotel' ]);
            }
        }

        foreach ($rooms as  $room) {
            $newroom = Room::create(['name'=> $room['name'], 'body'=> $room['body'], 'room_quan'=> $room['room_quan'], 'price'=> $room['price'], 'viewed'=>$room['viewed'], 'hotel_id'=>$hotel->id  ]);
        }

        return Redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function show(Hotel $hotel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function edit(Hotel $hotel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hotel $hotel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hotel $hotel)
    {
        $hotel->delete();
        return Redirect()->back();

    }
}
