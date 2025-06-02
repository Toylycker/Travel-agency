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
    public function index(Request $request)
    {
        $query = Post::with(['texts.images', 'images', 'subjects']);
        
        // Handle sorting
        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);
        
        $posts = $query->paginate($request->get('perPage', 10))
            ->appends($request->query());
            
        $subjects = Subject::all(['name', 'id']);
        
        return Inertia::render('admin/Blog/index', [
            'posts' => $posts,
            'subjects' => $subjects,
            'filters' => $request->only(['sort_by', 'sort_order'])
        ]);
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
            'title' => 'string|required',
            'body' => 'string|required',
            'meta_title' => 'string|nullable',
            'meta_description' => 'string|nullable',
            'recommended' => 'boolean|nullable',
            'subject_ids' => 'array|nullable',
            'subject_ids.*' => 'exists:subjects,id',
            'images' => 'array|nullable',
            'images.*' => 'image|max:2048',
            'texts' => 'array|nullable',
            'texts.*.body' => 'string|required',
            'texts.*.images' => 'array|nullable',
            'texts.*.images.*' => 'image|max:2048',
        ]);

        // Create the post
        $post = Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'recommended' => $request->boolean('recommended'),
            'viewed' => 0,
        ]);

        // Sync subjects
        if ($request->has('subject_ids')) {
            $post->subjects()->sync($request->subject_ids);
        }

        // Handle post images
        if ($request->has('images')) {
            foreach ($request->images as $image) {
                $resized = Gallery::make($image)
                    ->fit(1400, 800)
                    ->encode('jpg', 100);
                $imageName = Str::random(10) . '-' . $post->id . '.' . $image->getClientOriginalExtension();
                Storage::put('public/posts/' . $imageName, (string) $resized);
                
                Image::create([
                    'name' => $imageName,
                    'url' => '/storage/posts/' . $imageName,
                    'imageable_id' => $post->id,
                    'imageable_type' => 'App\\Models\\Post'
                ]);
            }
        }

        // Handle texts and their images
        if ($request->has('texts')) {
            foreach ($request->texts as $textData) {
                $text = Text::create([
                    'body' => $textData['body'],
                    'textable_id' => $post->id,
                    'textable_type' => 'App\\Models\\Post'
                ]);

                // Handle text images
                if (isset($textData['images'])) {
                    foreach ($textData['images'] as $image) {
                        $resized = Gallery::make($image)
                            ->fit(1280, 1024)
                            ->encode('jpg', 100);
                        $imageName = Str::random(10) . '-' . $text->id . '.' . $image->getClientOriginalExtension();
                        Storage::put('public/texts/' . $imageName, (string) $resized);
                        
                        Image::create([
                            'name' => $imageName,
                            'url' => '/storage/texts/' . $imageName,
                            'imageable_id' => $text->id,
                            'imageable_type' => 'App\\Models\\Text'
                        ]);
                    }
                }
            }
        }

        return redirect()->back()->with('success', 'Post created successfully!');
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
        $request->validate([
            'title' => 'string|required',
            'body' => 'string|required',
            'meta_title' => 'string|nullable',
            'meta_description' => 'string|nullable',
            'recommended' => 'boolean|nullable',
            'subject_ids' => 'array|nullable',
            'subject_ids.*' => 'exists:subjects,id',
            'images' => 'array|nullable',
            'images.*' => 'image|max:2048',
            'existing_images' => 'array|nullable',
            'existing_images.*' => 'exists:images,id',
            'texts' => 'array|nullable',
            'texts.*.id' => 'nullable|exists:texts,id',
            'texts.*.body' => 'string|required',
            'texts.*.images' => 'array|nullable',
            'texts.*.images.*' => 'image|max:2048',
            'texts.*.existing_images' => 'array|nullable',
            'texts.*.existing_images.*' => 'exists:images,id',
        ]);

        // Update the post
        $post->update([
            'title' => $request->title,
            'body' => $request->body,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'recommended' => $request->boolean('recommended'),
        ]);

        // Sync subjects
        if ($request->has('subject_ids')) {
            $post->subjects()->sync($request->subject_ids);
        } else {
            $post->subjects()->detach();
        }

        // Handle post images
        $existingImageIds = $request->get('existing_images', []);
        
        // Delete images that are no longer needed
        $imagesToDelete = $post->images()->whereNotIn('id', $existingImageIds)->get();
        foreach ($imagesToDelete as $image) {
            Storage::delete('public/posts/' . $image->name);
            $image->delete();
        }

        // Add new post images
        if ($request->has('images')) {
            foreach ($request->images as $image) {
                $resized = Gallery::make($image)
                    ->fit(1400, 800)
                    ->encode('jpg', 100);
                $imageName = Str::random(10) . '-' . $post->id . '.' . $image->getClientOriginalExtension();
                Storage::put('public/posts/' . $imageName, (string) $resized);
                
                Image::create([
                    'name' => $imageName,
                    'url' => '/storage/posts/' . $imageName,
                    'imageable_id' => $post->id,
                    'imageable_type' => 'App\\Models\\Post'
                ]);
            }
        }

        // Handle texts
        if ($request->has('texts')) {
            $existingTextIds = collect($request->texts)->pluck('id')->filter();
            
            // Delete texts that are no longer in the request
            $textsToDelete = $post->texts()->whereNotIn('id', $existingTextIds)->get();
            foreach ($textsToDelete as $text) {
                // Delete text images
                foreach ($text->images as $image) {
                    Storage::delete('public/texts/' . $image->name);
                }
                $text->images()->delete();
                $text->delete();
            }

            foreach ($request->texts as $textData) {
                if (isset($textData['id']) && $textData['id']) {
                    // Update existing text
                    $text = Text::find($textData['id']);
                    $text->update(['body' => $textData['body']]);
                } else {
                    // Create new text
                    $text = Text::create([
                        'body' => $textData['body'],
                        'textable_id' => $post->id,
                        'textable_type' => 'App\\Models\\Post'
                    ]);
                }

                // Handle text images
                $existingTextImageIds = $textData['existing_images'] ?? [];
                
                // Delete text images that are no longer needed
                $textImagesToDelete = $text->images()->whereNotIn('id', $existingTextImageIds)->get();
                foreach ($textImagesToDelete as $image) {
                    Storage::delete('public/texts/' . $image->name);
                    $image->delete();
                }

                // Add new text images
                if (isset($textData['images'])) {
                    foreach ($textData['images'] as $image) {
                        $resized = Gallery::make($image)
                            ->fit(1280, 1024)
                            ->encode('jpg', 100);
                        $imageName = Str::random(10) . '-' . $text->id . '.' . $image->getClientOriginalExtension();
                        Storage::put('public/texts/' . $imageName, (string) $resized);
                        
                        Image::create([
                            'name' => $imageName,
                            'url' => '/storage/texts/' . $imageName,
                            'imageable_id' => $text->id,
                            'imageable_type' => 'App\\Models\\Text'
                        ]);
                    }
                }
            }
        } else {
            // If no texts are provided, delete all existing texts and their images
            foreach ($post->texts as $text) {
                foreach ($text->images as $image) {
                    Storage::delete('public/texts/' . $image->name);
                }
                $text->images()->delete();
                $text->delete();
            }
        }

        return redirect()->back()->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        // Delete all post images
        foreach ($post->images as $image) {
            Storage::delete('public/posts/' . $image->name);
            $image->delete();
        }

        // Delete all texts and their images
        foreach ($post->texts as $text) {
            foreach ($text->images as $image) {
                Storage::delete('public/texts/' . $image->name);
                $image->delete();
            }
            $text->delete();
        }

        // Delete the post
        $post->delete();

        return redirect()->back()->with('success', 'Post deleted successfully!');
    }
}
