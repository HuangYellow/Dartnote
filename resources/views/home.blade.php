@extends('layouts.app')
@inject('PostPresenter', '\App\Presenters\PostPresenter')
@inject('ContentPresent', '\App\Presenters\ContentPresent')

@section('content')
<div class="container">
    @auth
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-10 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <form id="create-form" method="POST" action="{{ route('posts.store') }}">
                            @csrf

                            <div class="form-group row">
                                <div class="col-12">
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
                                <div class="col-4">
                                    <div class="form-check">
                                        <input name="private" type="checkbox" class="form-check-input" id="exampleCheck1">
                                        <label class="form-check-label" for="exampleCheck1">@lang('Private')</label>
                                    </div>
                                </div>
                                <div class="col-8">
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
        <div class="col-12 col-sm-10 col-md-10 col-lg-6">
            <div class="infinite-scroll list-group">
                @foreach($posts as $post)
                    @include('posts._partials.card', [
                    'type' => 'post',
                    'readmore' => true
                    ])
                @endforeach

                {{ $posts->links() }}
            </div>
        </div>
    </div>
</div>
@endsection