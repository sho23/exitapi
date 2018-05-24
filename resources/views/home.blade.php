@extends('layouts.app')
@section('title', '出口API')
@section('content')
<div id="wrap">
    <div class="container">
        <div class="search col-sm-4 my-2 offset-sm-8">
            <form action="{{ action('HomeController@search') }}" method="GET" class="form-inline">
                <div class="form-group">
                      <label for="tags">Spot: </label>
                    <input type="text" name="q" class="form-control mx-sm-3" id="tags">
                </div>
                 <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        <div class="page-header">
            <h5 class="text-center">路線一覧</h5>
        </div>
        <div class="row">
                @foreach ($tracks as $track)
                    <div class="card col-md-4 col-sm-6 col-xs-12">
                        <div class="card-body text-center">
                            <a href="{{ url('/stations', ['post_id' => $track->id]) }}" class="card-link">{{ $track->name }}</a>
                        </div>
                    </div>
                @endforeach
        </div>
    </div>
</div>
@endsection