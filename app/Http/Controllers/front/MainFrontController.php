<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Place;
use App\Models\Post;
use App\Models\Subject;
use App\Models\Tour;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MainFrontController extends Controller
{
    public function index()
    {
        return Inertia::render('front/Welcome');
    }

    public function places(Request $request)
    {
        $request->validate([
            'search'=>'nullable|string|max:10',
            'category' =>'nullable|string|max:15'
        ]);
        $search = ($request->search)?$request->search:null;
        $category = ($request->category)?Category::where('name', $request->category)->first():null;

        $places = Place::when($category, function ($query,$category){
            $query->whereHas('categories', function ($query) use ($category){
                $query->where('name', $category->name);
            });
        })
        ->when($search, function ($query, $search){
            $query->where('name', 'like', '%' . $search . '%');
        });
        return Inertia::render('front/Places', [
            'places'=> $places->paginate( 10, ['id', 'name', 'body'])->withQueryString(),
            'title' => 'The Best PLace In The World',
            'search' => $search,
            'category' => $category?$category->name:null,
            'categories'=>Category::get(),
            'show' => $places->count()>0?true:false,
            'potentialSearchResultLength' =>$places->count()
        ]);
    }

    public function tours()
    {
        $tours = Tour::with(['days'=> function($query){
            $query->withCount('places');
        }, 'days.places'])->paginate(4)->withQueryString();
        return Inertia::render('front/Tours', compact('tours'));
    }

    public function blog(Request $request)
    {
        $request->validate([
            'search'=>'nullable|string|max:10',
            'subject' =>'nullable|max:15'
        ]);

        // return $request;

        $search = ($request->search)?$request->search:null;
        $subject = ($request->subject)?Subject::findOrFail($request->subject):null;

        $posts = Post::when($subject, function ($query,$subject){
            $query->whereHas('subjects', function ($query) use ($subject){
                $query->where('name', $subject->name);
            });
        })
        ->when($search, function ($query, $search){
            $query->where(function ($query)use ($search){
                $query->where('title', 'like', '%' . $search . '%');
                $query->orWhere('body', 'like', '%' . $search . '%');
            });
        })
        ->paginate( 10, ['id', 'title', 'body'])->withQueryString();

        $subjects=Subject::when($subject, function ($query,$subject){
            $query->whereNot('id', $subject->id);
        })->get();

        return Inertia::render('front/Blog', [
            'posts'=> $posts,
            'search' => $search,
            'subject' => $subject,
            'subjects'=>$subjects,
            'show' =>$posts->count()>0?true:false
        ]);
    }

    public function hotels()
    {
        return Inertia::render('front/Hotels');
    }

    public function contact()
    {
        return Inertia::render('front/ContactUs');
    }

    public function resultlength(Request $request){
        $request->validate([
            'search'=>'nullable|string|max:10',
            'category' =>'nullable|string|max:15'
        ]);
        $search = ($request->search)?$request->search:null;
        $category = ($request->category)?Category::where('name', $request->category)->first():null;

        $places = Place::when($category, function ($query,$category){
            $query->whereHas('categories', function ($query) use ($category){
                $query->where('name', $category->name);
            });
        })
        ->when($search, function ($query, $search){
            $query->where('name', 'like', '%' . $search . '%');
        })->count();
        
        return Inertia::render('front/Places', [
            'potentialSearchResultLength' =>$places
        ]);

    }
}
