<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Support\Str;
use App\Models\Post;
use App\Models\Subject;
use App\Models\Text;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Gallery;
use Inertia\Inertia;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with(['texts', 'images', 'subjects'])
        ->paginate(10)
        ->withQueryString();
        $subjects = Subject::all('name', 'id');
        return Inertia::render(
            'admin/Blog/index',
            ['posts' => $posts, 'subjects' => $subjects]
        );
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
            'title'=>'string|required',
            'main_image'=>'Image|required',
            'subjects'=>'array|required',
            'body'=>'string|required',
            'viewed'=>'nullable',
            'recommended'=>'nullable',
            'images'=>'array|required',
            'images.*'=>'Image|required',
            'texts'=>'array',
        ]);


        $subjects = $request->subjects;
        $texts = $request->has('texts')?$request->texts:null;
        $post = Post::create(['title'=>$request->title, 
        'body'=>$request->body, 
        'viewed'=>$request->viewed, 
        // 'recommended'=>$request->recommended
    ]);
        $post->subjects()->sync($subjects);

        if ($request->has('main_image')) {
            $newImage = $request->file('main_image');
            $resized = Gallery::make($newImage)
            // ->resize( null, 700, function ($constraint) { $constraint->aspectRatio(); } )
            ->fit(1400, 800)
            ->encode('jpg',100);
            $newImageName = Str::random(10) . '-' . $post->id . '.' . $newImage->getClientOriginalExtension();
            Storage::put('public/blog/'. $newImageName, (string) $resized);
            // $resized->storeAs('public/posts/', $newImageName);
    
            $post->main_image = $newImageName;
            $post->update();
        }
        if ($request->has('images')) {
            foreach ($request->images as $image) {
                $newImage = $image;
                $resized = Gallery::make($newImage)
                // ->resize( null, 700, function ($constraint) { $constraint->aspectRatio(); } )
                ->fit(1400, 800)
                ->encode('jpg',100);
                $newImageName = Str::random(10) . '-' . $post->id . '.' . $newImage->getClientOriginalExtension();
                Storage::put('public/blog/'. $newImageName, (string) $resized);
                Image::create(['name'=>$newImageName, 'imageable_id'=>$post->id, 'imageable_type'=>'App\Models\post' ]);
            }
        }

        foreach ($texts as  $text) {
            $newText = Text::create(['title'=>$text['title'], 'text_number'=>$text['text_number'],'body'=>$text['body'], 'textable_id'=>$post->id, 'textable_type'=>'App\Models\Post' ]);
            if (array_key_exists('images', $text)) {
                # code...
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
        }

        return Redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        // dd($post);
        // return $request;
        $post->delete();

        return Redirect()->back();
    }
}
