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
        <form action="{{ action('SpotsController@store') }}" method="POST">
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
                            <label for="name">場所名</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{old('name')}}" placeholder="東京ドーム">
                        </div>
                        <div class="card-body text-center">
                            <button type="submit" class="btn btn-primary">登録</button>
                        </div>
					</div>
				</div>
            </div>
        </form>
    </div>
</div>
@endsection