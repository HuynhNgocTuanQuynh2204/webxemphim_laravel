<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Country;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\Episode;
class IndexController extends Controller
{
    public function home()
    {
        $phimhot = Movie::where('phim_hot',1)->where('status',1)->orderBy('ngaycapnhap','DESC')->get();
        $phimhot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('ngaycapnhap','DESC')->take('5')->get();
        $category = Category::orderBy('id','DESC')->where('status',1)->get();
        $genre = Genre::orderBy('id','DESC')->get();
        $country = Country::orderBy('id','DESC')->get();
        $category_home = Category::with('movie')->orderBy('id','DESC')->where('status',1)->get();
        return view('pages.home',compact('category','genre','country','category_home','phimhot','phimhot_sidebar'));
    }
    
    public function category($slug)
    {
        $category = Category::orderBy('id','DESC')->where('status',1)->get();
        $phimhot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('ngaycapnhap','DESC')->take('5')->get();
        $genre = Genre::orderBy('id','DESC')->get();
        $country = Country::orderBy('id','DESC')->get();
        $cate_slug = Category::where('slug',$slug)->first();
        $movie = Movie::where('category_id',$cate_slug->id)->orderBy('ngaycapnhap','DESC')->paginate(40);
        return view('pages.category',compact('category','genre','country','cate_slug','movie','phimhot_sidebar'));
    }

    public function year($year)
    {
        $category = Category::orderBy('id','DESC')->where('status',1)->get();
        $phimhot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('ngaycapnhap','DESC')->take('5')->get();
        $genre = Genre::orderBy('id','DESC')->get();
        $country = Country::orderBy('id','DESC')->get();
        $year = $year;
        $movie = Movie::where('year',$year)->orderBy('ngaycapnhap','DESC')->paginate(40);
        return view('pages.year',compact('category','genre','country','year','movie','phimhot_sidebar'));
    }

    public function tag($tag)
    {
        $category = Category::orderBy('id','DESC')->where('status',1)->get();
        $phimhot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('ngaycapnhap','DESC')->take('5')->get();
        $genre = Genre::orderBy('id','DESC')->get();
        $country = Country::orderBy('id','DESC')->get();
        
        $tag = $tag;
        $movie = Movie::where('tags','LIKE','%'.$tag.'%')->orderBy('ngaycapnhap','DESC')->paginate(40);
        return view('pages.tag',compact('category','genre','country','tag','movie','phimhot_sidebar'));
    }

    public function genre($slug)
    {
        $category = Category::orderBy('id','DESC')->where('status',1)->get();
        $phimhot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('ngaycapnhap','DESC')->take('5')->get();
        $genre = Genre::orderBy('id','DESC')->get();
        $country = Country::orderBy('id','DESC')->get();
        $genre_slug = Genre::where('slug',$slug)->first();
        $movie = Movie::where('genre_id',$genre_slug->id)->orderBy('ngaycapnhap','DESC')->paginate(40);
        return view('pages.genre',compact('category','genre','country','genre_slug','movie','phimhot_sidebar'));
    }

    public function country($slug)
    {
        $category = Category::orderBy('id','DESC')->where('status',1)->get();
        $phimhot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('ngaycapnhap','DESC')->take('5')->get();
        $genre = Genre::orderBy('id','DESC')->get();
        $country = Country::orderBy('id','DESC')->get();
        $country_slug = Country::where('slug',$slug)->first();
        $movie = Movie::where('country_id',$country_slug->id)->orderBy('ngaycapnhap','DESC')->paginate(40);
        return view('pages.country',compact('category','genre','country','country_slug','movie','phimhot_sidebar'));
    }

    public function movie($slug)
    {
        $category = Category::orderBy('id','DESC')->where('status',1)->get();
        $phimhot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('ngaycapnhap','DESC')->take('5')->get();
        $genre = Genre::orderBy('id','DESC')->get();
        $country = Country::orderBy('id','DESC')->get();
        $movie = Movie::with('category','country','genre')->where('slug',$slug)->where('status',1)->first();
        $related = Movie::with('category','country','genre')->where('category_id',$movie->category->id)->orderBy(DB::raw('RAND()'))->whereNotIn('slug',[$slug])->get();
        return view('pages.movie',compact('category','genre','country','movie','related','phimhot_sidebar'));
    }

    public function watch()
    {
        return view('pages.watch');
    }

    public function episode()
    {
        return view('pages.episode');
    }
}
