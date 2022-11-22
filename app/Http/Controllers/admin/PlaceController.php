<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Support\Str;
use App\Models\Location;
use App\Models\Place;
use App\Models\Text;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Intervention\Image\ImageManagerStatic as Gallery;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $places = Place::with(['texts'=>function($query){
            $query->orderBy('id');
        } , 'images', 'location'])->orderBy('id')->paginate(15)->withQueryString();
        $locations = Location::all('name', 'id');
        return Inertia::render('admin/Places/index', ['places'=>$places, 'locations'=>$locations]);

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
            'location'=>'numeric|required',
            'body'=>'string|required',
            'viewed'=>'nullable',
            'recommended'=>'nullable',
            'images'=>'array|required',
            'images.*'=>'Image|required',
            'texts'=>'array',
        ]);

        // dd($request->texts[0]['images'][0]);

        $location = Location::findOrFail($request->location);
        $texts = $request->has('texts')?$request->texts:null;
        $place = Place::create(['name'=>$request->name, 'location_id'=>$location->id, 'body'=>$request->body, 'viewed'=>$request->viewed, 'recommended'=>$request->recommended]);

        if ($request->has('images')) {
            foreach ($request->images as $image) {
                $newImage = $image;
                $resized = Gallery::make($newImage)
                // ->resize( null, 700, function ($constraint) { $constraint->aspectRatio(); } )
                ->fit(1280, 1024)
                ->encode('jpg',100);
                $newImageName = Str::random(10) . '-' . $place->id . '.' . $newImage->getClientOriginalExtension();
                Storage::put('public/places/'. $newImageName, (string) $resized);
                Image::create(['name'=>$newImageName, 'imageable_id'=>$place->id, 'imageable_type'=>'App\Models\Place' ]);
            }
        }

        foreach ($texts as  $text) {
            $newText = Text::create(['title'=>$text['title'], 'text_number'=>$text['text_number'],'body'=>$text['body'], 'textable_id'=>$place->id, 'textable_type'=>'App\Models\Place' ]);
            foreach ($text['images'] as $image) {
                $newImage = $image;
                $resized = Gallery::make($newImage)
                // ->resize( null, 700, function ($constraint) { $constraint->aspectRatio(); } )
                ->fit(1280, 1024)
                ->encode('jpg',100);
                $newImageName = Str::random(10) . '-' . $newText->id . '.' . $newImage->getClientOriginalExtension();
                Storage::put('public/texts/'. $newImageName, (string) $resized);
                Image::create(['name'=>$newImageName, 'imageable_id'=>$newText->id, 'imageable_type'=>'App\Models\Text' ]);
            }
        }

        return Redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function show(Place $place)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function edit(Place $place)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Place $place)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function destroy(Place $place)
    {
        $place->delete();

        return Redirect()->back();
    }
}
