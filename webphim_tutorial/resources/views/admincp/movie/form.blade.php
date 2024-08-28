@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <a href="{{route('movie.index')}}" class="btn btn-primary">Liệt kê phim</a>
                <div class="card-header">Quản lý phim</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(!isset($movie))
                        {!! Form::open(['route' => 'movie.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                    @else
                        {!! Form::open(['route' => ['movie.update', $movie->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
                    @endif

                    <div class="form-group">
                        {!! Form::label('Tên phim', 'Tên phim', []) !!}
                        {!! Form::text('title', isset($movie) ? $movie->title : '', ['class'=>'form-control', 'placeholder'=>'Nhập vào dữ liệu...', 'id'=>'slug', 'onkeyup'=>'ChangeToSlug()']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('Thời lượng phim', 'Thời lượng phim', []) !!}
                        {!! Form::text('thoiluong', isset($movie) ? $movie->thoiluong : '', ['class'=>'form-control', 'placeholder'=>'Nhập vào dữ liệu...']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('Tên tiếng anh', 'Tên tiếng anh', []) !!}
                        {!! Form::text('name_eng', isset($movie) ? $movie->name_eng : '', ['class'=>'form-control', 'placeholder'=>'Nhập vào dữ liệu...']) !!}
                    </div>
                    
                    <div class="form-group">
                        {!! Form::label('Đường dẫn', 'Đường dẫn', []) !!}
                        {!! Form::text('slug', isset($movie) ? $movie->slug : '', ['class'=>'form-control', 'placeholder'=>'Nhập vào dữ liệu...', 'id'=>'convert_slug']) !!}
                    </div>
                    
                    <div class="form-group">
                        {!! Form::label('Mô tả phim', 'Mô tả phim', []) !!}
                        {!! Form::textarea('description', isset($movie) ? $movie->description : '', ['style'=>'resize:none', 'class'=>'form-control', 'placeholder'=>'Nhập vào dữ liệu...', 'id'=>'description']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('Từ khóa', 'Từ khóa', []) !!}
                        {!! Form::textarea('tags', isset($movie) ? $movie->tags : '', ['style'=>'resize:none', 'class'=>'form-control', 'placeholder'=>'Nhập vào dữ liệu...']) !!}
                    </div>
                    
                    <div class="form-group">
                        {!! Form::label('Trạng thái', 'Trạng thái', []) !!}
                        {!! Form::select('status', ['1' => 'Hiển thị', '0' => 'Không'], isset($movie) ? $movie->status : null, ['class'=>'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('Định dạng', 'Định dạng', []) !!}
                        {!! Form::select('resolution', ['0' => 'HD', '1' => 'SD', '2' => 'HDCam', '3' => 'FHD', '4' => 'Cam', '5' => 'FullHD'], isset($movie) ? $movie->resolution : null, ['class'=>'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('Phụ đề', 'Phụ đề', []) !!}
                        {!! Form::select('phude', ['0' => 'Phụ đề', '1' => 'Thuyết minh'], isset($movie) ? $movie->phude : null, ['class'=>'form-control']) !!}
                    </div>
                    
                    <div class="form-group">
                        {!! Form::label('Danh mục', 'Danh mục', []) !!}
                        {!! Form::select('category_id', $category, isset($movie) ? $movie->category_id : null, ['class'=>'form-control']) !!}
                    </div>
                    
                    <div class="form-group">
                        {!! Form::label('Quốc gia', 'Quốc gia', []) !!}
                        {!! Form::select('country_id', $country, isset($movie) ? $movie->country_id : null, ['class'=>'form-control']) !!}
                    </div>
                    
                    <div class="form-group">
                        {!! Form::label('Phim hot', 'Phim hot', []) !!}
                        {!! Form::select('phim_hot',['1' => 'Có', '0' => 'Không'], isset($movie) ? $movie->phim_hot : null, ['class'=>'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('Thể loại', 'Thể loại', []) !!}
                        {!! Form::select('genre_id', $genre, isset($movie) ? $movie->genre_id : null, ['class'=>'form-control']) !!}
                    </div>
                    
                    <div class="form-group">
                        {!! Form::label('Hình ảnh', 'Hình ảnh', []) !!}
                        {!! Form::file('image', ['class'=>'form-control-file']) !!}
                        @if (isset($movie) && $movie->image)
                            <img src="{{asset('uploads/movie/'.$movie->image)}}" width="20%">
                        @endif
                    </div>

                    @if(!isset($movie))
                        {!! Form::submit('Thêm dữ liệu', ['class'=>'btn btn-success']) !!}
                    @else
                        {!! Form::submit('Cập nhật dữ liệu', ['class'=>'btn btn-success']) !!}
                    @endif

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
