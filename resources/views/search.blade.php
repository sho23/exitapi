@extends('layouts.app')
@section('title', '出口API')
@section('content')
<div id="wrap">
    <div class="container">
        <div class="page-header">
            <h5 class="text-center">検索結果</h5>
        </div>
        <div class="row">
            @if (!empty($spotList))
                @foreach ($spotList as $spot => $spotData)
                    <div class="col-md-4 col-sm-6 col-xs-12 mb-4">
                        <div class="card">
                            <div class="card-header text-center">{{ $spot }}</div>
                            @foreach ($spotData as $station => $exits)
            					<div class="card-body">
                                    <h5 class="card-title">{{ $station }}</h5>
                                    <ul class="list-group list-group-flush">
                                    @foreach ($exits as $exit)
                                        <li class="list-group-item">{{ $exit->track_name }} {{ $exit->exit_name }}</li>
                                    @endforeach
                                    </ul>
            					</div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @else
                <h4 class="mx-auto">データなし</h4>    
            @endif
        </div>
        <div class="mt-4 center-block text-center card offset-sm-4 col-sm-4">
            <div class="card-body text-center">
                <a href="{{ url('/') }}" class="card-link">路線一覧へ</a>
            </div>
        </div>
    </div>
</div>
@endsection