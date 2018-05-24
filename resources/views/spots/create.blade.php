@extends('layouts.app')
@section('title', 'AB診断')
@section('content')
<div id="wrap">
    <div class="container">
        <div class="card mb-4 text-center" style="width: 100%;">
            <div class="card-body">
                <h3 class="card-title">スポット新規登録</h5>
            </div>
        </div>
        {!! Form::open(['route' => ['spots.store'], 'method' => 'post']) !!}

            <div class="row">
                <div class="card mb-2 mx-2" style="width: 100%;">
					<div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="form-group">
                            {{Form::select('track', $trackList, null, ['class' => 'parent'])}}
                        </div>
                        <div class="form-group">
                            {{Form::select('station', $stationList, null, ['class' => 'children'])}}
                        </div>
                        <div class="form-group">
                            {{Form::select('exit', $exitList, null, ['class' => 'childchildren'])}}
                        </div>
                        <div class="form-group">
                            <label for="name">場所名</label>
                            <input type="text" class="form-control" name="name" id="spots" value="{{old('name')}}" placeholder="東京ドーム">
                        </div>
                        <div class="form-group">
                            <label for="address">住所</label>
                            <input type="text" class="form-control" name="address" value="{{old('address')}}" placeholder="渋谷区1-1-1">
                        </div>
                        <div class="card-body text-center">
                            <button type="submit" class="btn btn-primary">登録</button>
                        </div>
					</div>
				</div>
            </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection