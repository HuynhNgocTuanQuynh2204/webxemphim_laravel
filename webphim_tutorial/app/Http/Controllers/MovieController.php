<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Country;
use Carbon\Carbon;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list =Movie::with('category','genre','country')->orderBy('id','DESC')->get();
        return view('admincp.movie.index',compact('list'));
    }

    public function updateTopview(Request $request) {
        $data = $request->all();
        $cate = Movie::find($data['id']);
        if ($cate) {
            $cate->topview = $data['value'];
            $cate->save();
        }
        return response()->json(['success' => true]);
    }
    
    public function update_year(Request $request) {
        $data = $request->all();
        $movie = Movie::find($data['id_phim']);
        if ($movie) {
            $movie->year = $data['year'];
            $movie->save();
        }
        return response()->json(['success' => true]);
    }
    

    public function update_topview(Request $request){
        $data = $request->all();
        $movie = Movie::find($data['id_phim']);
        $movie->topview = $data['topview'];
        $movie->save();
    }

    public function filter_topview(Request $request){
        $data = $request->all();
        $movie = Movie::where('topview',$data['value'])->orderBy('ngaycapnhap','DESC')->take(5)->get();
        $output ='';
        foreach($movie as $key => $mov){
            if($mov ->resolution == 0){
                $text = 'HD';
            }else if($mov ->resolution == 1){
                $text = 'SD';
            }else if($mov ->resolution == 2){
                $text = 'HDCam';
            }else if($mov ->resolution == 3){
                $text = 'FHD';
            }else if($mov ->resolution == 4){
                $text = 'Cam';
            }else {
                $text = 'FullHD';
            }
        $output.= '<div class="item">
            <a href="' . url('phim/' . $mov->slug) . '" title="' . $mov->title . '">
                <div class="item-link">
                    <img src="' . url('uploads/movie/' . $mov->image) . '" class="lazy post-thumb" alt="' . $mov->title . '" title="' . $mov->title . '" />
                    <span class="is_trailer">' . $text . '</span>
                </div>
                <p class="title">' . $mov->title . '</p>
            </a>
            <div class="viewsCount" style="color: #9d9d9d;">3.2K lượt xem</div>
            <div style="float: left;">
                <span class="user-rate-image post-large-rate stars-large-vang" style="display: block;">
                    <span style="width: 0%;"></span>
                </span>
            </div>
        </div>';

       }
       echo $output;
    }

    public function filter_default(Request $request){
        $data = $request->all();
        $movie = Movie::where('topview',0)->orderBy('ngaycapnhap','DESC')->take(5)->get();
        $output ='';
        foreach($movie as $key => $mov){
            if($mov ->resolution == 0){
                $text = 'HD';
            }else if($mov ->resolution == 1){
                $text = 'SD';
            }else if($mov ->resolution == 2){
                $text = 'HDCam';
            }else if($mov ->resolution == 3){
                $text = 'FHD';
            }else if($mov ->resolution == 4){
                $text = 'Cam';
            }else {
                $text = 'FullHD';
            }
        $output.= '<div class="item">
            <a href="' . url('phim/' . $mov->slug) . '" title="' . $mov->title . '">
                <div class="item-link">
                    <img src="' . url('uploads/movie/' . $mov->image) . '" class="lazy post-thumb" alt="' . $mov->title . '" title="' . $mov->title . '" />
                    <span class="is_trailer">' . $text . '</span>
                </div>
                <p class="title">' . $mov->title . '</p>
            </a>
            <div class="viewsCount" style="color: #9d9d9d;">3.2K lượt xem</div>
            <div style="float: left;">
                <span class="user-rate-image post-large-rate stars-large-vang" style="display: block;">
                    <span style="width: 0%;"></span>
                </span>
            </div>
        </div>';

       }
       echo $output;
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::pluck('title','id');
        $genre = Genre::pluck('title','id');
        $country = Country::pluck('title','id');
        return view('admincp.movie.form',compact('genre','country','category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $data = $request->all();
       $movie = new Movie();
       $movie->title = $data['title'];
       $movie->tags = $data['tags'];
       $movie->thoiluong = $data['thoiluong'];
       $movie->phim_hot = $data['phim_hot'];
       $movie->resolution = $data['resolution'];
       $movie->phude = $data['phude'];
       $movie->name_eng = $data['name_eng'];
       $movie->slug =$data['slug'];
       $movie->description = $data['description'];
       $movie->status = $data['status'];
       $movie->category_id = $data['category_id'];
       $movie->genre_id = $data['genre_id'];
       $movie->country_id = $data['country_id'];
       $movie->ngaytao = Carbon::now('Asia/Ho_Chi_Minh');
       $movie->ngaycapnhap = Carbon::now('Asia/Ho_Chi_Minh');

       //themhinhanh

       $get_image = $request->file('image');

       $path ='uploads/movie/';

       
       if($get_image)
       {
        $get_name_image = $get_image->getClientOriginalName();
        $name_image = current(explode('.',$get_name_image));
        $new_image = $name_image.rand(0,9999).'.'.$get_image->getClientOriginalExtension();
        $get_image->move($path,$new_image);
        $movie->image = $new_image;
       }
       $movie->save();
       return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::pluck('title','id');
        $genre = Genre::pluck('title','id');
        $country = Country::pluck('title','id');
        $movie = Movie::find($id);
        return view('admincp.movie.form',compact('genre','country','category','movie'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $movie = Movie::find($id);
        $movie->title = $data['title'];
        $movie->tags = $data['tags'];
        $movie->thoiluong = $data['thoiluong'];
        $movie->phim_hot = $data['phim_hot'];
        $movie->resolution = $data['resolution'];
        $movie->phude = $data['phude'];
        $movie->name_eng = $data['name_eng'];
        $movie->slug =$data['slug'];
        $movie->description = $data['description'];
        $movie->status = $data['status'];
        $movie->category_id = $data['category_id'];
        $movie->genre_id = $data['genre_id'];
        $movie->country_id = $data['country_id'];
        $movie->ngaycapnhap = Carbon::now('Asia/Ho_Chi_Minh');
        //themhinhanh
 
        $get_image = $request->file('image');
 
        $path ='uploads/movie/';
 
        
        if($get_image)
        {
            if(file_exists('uploads/movie/'.$movie->image)){
                    unlink('uploads/movie/'.$movie->image);
            }else{
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,9999).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path,$new_image);
            $movie->image = $new_image;
            }
        }
        $movie->save();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $movie = Movie::find($id);
      if(file_exists('uploads/movie/'.$movie->image)){
        unlink('uploads/movie/'.$movie->image);
      }
      $movie->delete();
       return redirect()->back();
    }
}
