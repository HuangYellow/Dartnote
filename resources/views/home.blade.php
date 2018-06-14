@extends('layouts.app')
@inject('PostPresenter', '\App\Presenters\PostPresenter')
@inject('ContentPresent', '\App\Presenters\ContentPresent')

@section('content')
<div class="container">
    @auth
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <form id="create-form" method="POST" action="{{ route('posts.store') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="content" class="col-1 col-form-label text-right">
                                    <img data-src="holder.js/75x75" class="rounded-circle" alt="75x75" style="width: 36px; height: 36px;" src="{{ auth()->gavatar() }}" data-holder-rendered="true">
                                </label>

                                <div class="col-11">
                                    <resizable-textarea>
                                        <textarea v-model="content" class="content form-control{{ $errors->has('content') ? ' is-invalid' : '' }} resize-none outline-0"
                                                  name="content" rows="2" placeholder="{{ __('What does you think?') }}"
                                                  autofocus>{{ old('content') }}</textarea>
                                    </resizable-textarea>

                                    @if ($errors->has('content'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('content') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            @include('components.preview')

                            @include('posts._partials.embed-fields')

                            <div class="form-group row mb-0">
                                <div class="col-11 offset-1">
                                    <button type="submit" class="btn btn-primary float-right">
                                        @lang('Create Post')
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endauth

    <div class="row mt-3 justify-content-center">
        <div class="col-6">
            <div class="infinite-scroll list-group">
                @foreach($posts as $post)
                    @include('posts._partials.card')
                @endforeach

                {{ $posts->links() }}
            </div>
        </div>
    </div>
</div>
@endsection