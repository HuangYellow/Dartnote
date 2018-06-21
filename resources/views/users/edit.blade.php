@extends('layouts.app')

@section('content')
    <div class="container">
        @auth
            <div class="row justify-content-center">
                <div class="col-12 col-sm-10 col-md-10 col-lg-8 col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <span class="row justify-content-center">
                                <img class="rounded-circle" src="{{ gravatar($user->email, 150) }}">
                            </span>
                            <span class="row justify-content-center mt-2">
                                <a target="_blank" href="https://en.gravatar.com/">Powered by Gravatar</a>
                            </span>

                            <form id="create-form" method="POST" action="{{ route('users.update', auth()->nickname()) }}">
                                @csrf
                                @method('put')

                                <div class="form-group row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                        <label for="bio">
                                            @lang("Bio")
                                        </label>
                                        <textarea class="form-control{{ $errors->has('bio') ? ' is-invalid' : '' }} resize-none outline-0"
                                                      id="bio" name="bio" rows="2" placeholder="{{ __('What does you think?') }}"
                                                      autofocus>{{ old('bio', $user->bio) }}</textarea>

                                        @if ($errors->has('bio'))
                                            <span class="invalid-feedback">
                                            <strong>{{ $errors->first('bio') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-3">
                                        <label for="language">
                                            @lang("Language")
                                        </label>
                                        <select class="custom-select" id="language" name="language">
                                            <option value="zh_TW" {{ auth()->user()->language == 'zh_TW'? 'selected':'' }}>@lang("Traditional Chinese")</option>
                                            <option value="en" {{ auth()->user()->language == 'en'? 'selected':'' }}>@lang("English")</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-11 col-sm-11 col-md-11 col-lg-11 col-xl-11 offset-1 offset-sm-1 offset-md-1 col-lg-1 col-xl-1">
                                        <button type="submit" class="btn btn-outline-primary float-right">
                                            @lang('Update bio')
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endauth
    </div>
@endsection