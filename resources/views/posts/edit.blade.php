@extends('layouts.app')
@inject('PostPresenter', '\App\Presenters\PostPresenter')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Post</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('posts.update', $post->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="form-group row">
                                <label for="content" class="col-sm-4 col-form-label text-md-right">Content</label>

                                <div class="col-md-6">
                                    <textarea class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}" name="content" id="content" cols="30" rows="10" autofocus>{!! old('content', e($post->content)) !!}</textarea>

                                    @if ($errors->has('content'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('content') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Edit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
