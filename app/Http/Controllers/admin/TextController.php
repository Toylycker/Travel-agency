<?php

namespace App\Http\Controllers\admin;

use Intervention\Image\ImageManagerStatic as Gallery;
use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Text;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TextController extends Controller
{
    function destroy(Text $text) {
        $text->delete();

        return redirect()->back();
    }

    function store(Request $request) {

        $request->validate([
            'title'=>'string|required',
            'text_number'=>'numeric|required',
            'body'=>'string|required',
            'textable_id'=>'numeric|required',
            'images'=>'array|nullable',
            'images.*'=>'nullable|Image',
        ]);
        $newText = Text::create(['title'=>$request->title, 'text_number'=>$request->text_number,'body'=>$request->body, 'textable_id'=>$request->textable_id, 'textable_type'=>"App\Models\Place" ]);
        if ($request->hasFile('images.*')) {
            foreach ($request->images as $image) {
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

        return redirect()->back();
    }
}
