<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
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
    
    public function index()
    {
        $places = Place::with(['texts' => function ($query) {
            $query->orderBy('id');
        }, 'images', 'location', 'categories'])->orderBy('id')->paginate(15)->withQueryString();
        $locations = Location::all('name', 'id');
        $categories = Category::all('name', 'id');
        return Inertia::render('admin/Places/index', ['places' => $places, 'locations' => $locations, 'categories' => $categories]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'string|required',
            'location' => 'numeric|required',
            'categories' => 'array|required',
            'categories.*' => 'numeric|required',
            'body' => 'string|required',
            'map' => 'string|nullable',
            'viewed' => 'nullable',
            'recommended' => 'nullable',
            'images' => 'array|required',
            'images.*' => 'Image|required',
            'texts' => 'array',
        ]);


        // dd($request->texts[0]['images'][0]);

        $location = Location::findOrFail($request->location);
        $categories = Category::wherein('id', $request->categories);
        $texts = $request->has('texts') ? $request->texts : null;
        $place = Place::create(['name' => $request->name, 'location_id' => $location->id, 'body' => $request->body, 'map' => $request->map, 'viewed' => $request->viewed, 'recommended' => $request->recommended]);
        $place->categories()->attach($categories->pluck('id'));

        if ($request->has('images')) {
            foreach ($request->images as $image) {
                $newImage = $image;
                $resized = Gallery::make($newImage)
                    // ->resize( null, 700, function ($constraint) { $constraint->aspectRatio(); } )
                    ->fit(1280, 1024)
                    ->encode('jpg', 100);
                $newImageName = Str::random(10) . '-' . $place->id . '.' . $newImage->getClientOriginalExtension();
                Storage::put('public/places/' . $newImageName, (string) $resized);
                Image::create(['name' => $newImageName, 'imageable_id' => $place->id, 'imageable_type' => 'App\Models\Place']);
            }
        }

        if ($texts) {
            foreach ($texts as  $text) {
                $newText = Text::create(['title' => $text['title'], 'text_number' => $text['text_number'], 'body' => $text['body'], 'textable_id' => $place->id, 'textable_type' => 'App\Models\Place']);
                if (array_key_exists('images', $text)) {
                    foreach ($text['images'] as $image) {
                        $newImage = $image;
                        $resized = Gallery::make($newImage)
                            // ->resize( null, 700, function ($constraint) { $constraint->aspectRatio(); } )
                            ->fit(1280, 1024)
                            ->encode('jpg', 100);
                        $newImageName = Str::random(10) . '-' . $newText->id . '.' . $newImage->getClientOriginalExtension();
                        Storage::put('public/texts/' . $newImageName, (string) $resized);
                        Image::create(['name' => $newImageName, 'imageable_id' => $newText->id, 'imageable_type' => 'App\Models\Text']);
                    }
                }
            }
        }


        return Redirect()->back();
    }

    public function update(Request $request, Place $place)
    {
        $request->validate([
            'name' => 'string|required',
            'name_cn' => 'string|nullable',
            'location_id' => 'numeric|required',
            'categories' => 'array|required',
            'categories.*' => 'numeric|required',
            'body' => 'string|required',
            'body_cn' => 'string|nullable',
            'map' => 'string|nullable',
            'viewed' => 'nullable',
            'recommended' => 'nullable',
            'images' => 'array|nullable',
            'images.*' => 'Image|nullable',
        ]);

        $location = Location::findOrFail($request->location_id);
        $categories = Category::wherein('id', $request->categories);
        $place->update(['name' => $request->name, 'name_cn' => $request->name_cn, 'location_id' => $location->id, 'body' => $request->body, 'body_cn' => $request->body_cn, 'map' => $request->map, 'viewed' => $request->viewed, 'recommended' => $request->recommended == 'true' ? 1 : 0]);

        $place->categories()->sync($categories->pluck('id'));

        if ($request->hasFile('images')) {
            foreach ($request->images as $image) {
                $newImage = $image;
                $resized = Gallery::make($newImage)
                    // ->resize( null, 700, function ($constraint) { $constraint->aspectRatio(); } )
                    ->fit(1280, 1024)
                    ->encode('jpg', 100);
                $newImageName = Str::random(10) . '-' . $place->id . '.' . $newImage->getClientOriginalExtension();
                Storage::put('public/places/' . $newImageName, (string) $resized);
                Image::create(['name' => $newImageName, 'imageable_id' => $place->id, 'imageable_type' => 'App\Models\Place']);
            }
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function destroy(Place $place)
    {
        $place->texts()->delete();
        $place->images()->delete();
        $place->delete();


        return Redirect()->back();
    }
}
