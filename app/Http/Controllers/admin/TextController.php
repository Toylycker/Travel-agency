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
            'title_cn'=>'string|nullable',
            'text_number'=>'numeric|required',
            'body'=>'string|required',
            'body_cn'=>'string|nullable',
            'textable_id'=>'numeric|required',
            'images'=>'array|nullable',
            'images.*'=>'nullable|Image',
        ]);
        $newText = Text::create(['title'=>$request->title, 'title_cn'=>$request->title_cn, 'text_number'=>$request->text_number,'body'=>$request->body,'body_cn'=>$request->body_cn, 'textable_id'=>$request->textable_id, 'textable_type'=>"App\Models\Place" ]);
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

    function update(Request $request, Text $text) {
        
        $request->validate([
            'text.title'=>'string|required',
            'text.title_cn'=>'string|nullable',
            'text.text_number'=>'numeric|required',
            'text.body'=>'string|required',
            'text.body_cn'=>'string|nullable',
            'text.textable_id'=>'numeric|required',
            'text.images'=>'array|nullable',
            'text.images.*'=>'nullable|Image',
        ]);
        
        $text->update(['title'=>$request->text['title'], 'title_cn'=>$request->text['title_cn'], 'text_number'=>$request->text['text_number'],'body'=>$request->text['body'],'body_cn'=>$request->text['body_cn'], 'textable_id'=>$request->text['textable_id'], 'textable_type'=>"App\Models\Place" ]);
        if ($request->hasFile('text.images.*')) {
            $text->load('images')->images->map(function ($image){
                Storage::delete('public/texts/' . $image->name);
            });
            foreach ($request->text['images'] as $image) {
                $newImage = $image;
                $resized = Gallery::make($newImage)
                // ->resize( null, 700, function ($constraint) { $constraint->aspectRatio(); } )
                ->fit(1280, 1024)
                ->encode('jpg',100);
                $newImageName = Str::random(10) . '-' . $text->id . '.' . $newImage->getClientOriginalExtension();
                Storage::put('public/texts/'. $newImageName, (string) $resized);
                Image::create(['name'=>$newImageName, 'imageable_id'=>$text->id, 'imageable_type'=>'App\Models\Text' ]);
            }
        }

        return redirect()->back();
    }
}
