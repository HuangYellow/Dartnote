@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <h1 class="display-4">All Tags</h1>
            </div>
        </div>

        <div class="infinite-scroll list-group">
            @foreach($tags as $tag)
                <a href="{{ route('tags.show', $tag->name) }}"
                   class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">{{ $tag->name }}</h5>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection