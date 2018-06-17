@extends('layouts.app')
@inject('PostPresenter', '\App\Presenters\PostPresenter')
@inject('ContentPresent', '\App\Presenters\ContentPresent')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                @include('posts._partials.card', [
                    'type' => 'post',
                ])
            </div>
        </div>

        @auth
            <div class="row mt-3 justify-content-center">
                @include('comments._partials.form')
            </div>
        @endauth

        <div class="row justify-content-center">
            <div class="col-12">
                <div class="infinite-scroll list-group">
                    @foreach($comments as $index => $comment)
                        @include('posts._partials.comments')
                    @endforeach

                    {{ $comments->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection