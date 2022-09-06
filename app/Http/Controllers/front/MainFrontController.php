<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Place;
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
        })->paginate( 10, ['id', 'name', 'body'])->withQueryString();
        return Inertia::render('front/Places', [
            'places'=> $places,
            'title' => 'The Best PLace In The World',
            'search' => $search,
            'category' => $category?$category->name:null,
            'categories'=>Category::get()
        ]);
    }

    public function tours()
    {
        $tours = Tour::with(['days'=> function($query){
            $query->withCount('places');
        }, 'days.places'])->paginate(4)->withQueryString();
        return Inertia::render('front/Tours', compact('tours'));
    }

    public function blog()
    {
        return Inertia::render('front/Blog');
    }

    public function hotels()
    {
        return Inertia::render('front/Hotels');
    }

    public function contact()
    {
        return Inertia::render('front/ContactUs');
    }
}
