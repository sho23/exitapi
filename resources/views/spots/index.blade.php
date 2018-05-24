@extends('layouts.app')
@section('title', '出口API')
@section('content')
<div id="wrap">
    <div class="container">
        <div class="page-header">
            <h5 class="text-center">{{ $exit->name }}</h5>
        </div>
        <div class="row">
                @foreach ($spots as $spot)
                    <div class="card col-md-4 col-sm-6 col-xs-12">
    					<div class="card-body text-center">
                            {{ $spot->name }}
    					</div>
    				</div>
                @endforeach
        </div>
        <div class="mt-4 center-block text-center card offset-sm-4 col-sm-4">
            <div class="card-body text-center">
                <a href="{{ action('ExitsController@index', $exit->station_id) }}" class="card-link">出口一覧へ</a>
            </div>
        </div>
    </div>
</div>
@endsection