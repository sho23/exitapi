@extends('layouts.app')
@section('title', '出口API')
@section('content')
<div id="wrap">
    <div class="container">
        <div class="page-header">
            <h5 class="text-center">{{ $trackName }}</h5>
        </div>
        <div class="row">
                @foreach ($stations as $station)
                    <div class="card col-md-4 col-sm-6 col-xs-12">
    					<div class="card-body text-center">
                            <a href="{{ action('ExitsController@index', $station->id) }}" class="card-link">{{ $station->name }}</a>
    					</div>
    				</div>
                @endforeach
        </div>
        <div class="mt-4 center-block text-center card offset-sm-4 col-sm-4">
            <div class="card-body text-center">
                <a href="{{ url('/') }}" class="card-link">路線一覧へ</a>
            </div>
        </div>
    </div>
</div>
@endsection