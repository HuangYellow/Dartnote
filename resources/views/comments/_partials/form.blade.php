<div class="col-md-6">
    <div class="card" style="margin-bottom: 2px;">
        <div class="card-body">
            <form method="POST" action="{{ route('comments.store', $post->id) }}">
                @csrf

                <div class="form-group row">
                    <label for="content" class="col-md-1 col-form-label text-md-right">
                        <img data-src="holder.js/75x75" class="rounded-circle" alt="75x75"
                             style="width: 36px; height: 36px;"
                             src="{{ auth()->gavatar() }}"
                             data-holder-rendered="true">
                    </label>

                    <div class="col-md-11">
                        <resizable-textarea>
                            <textarea
                                    class="content form-control{{ $errors->has('content') ? ' is-invalid' : '' }} resize-none outline-0"
                                    name="description" rows="2"
                                    placeholder="{{ __('What does you think?') }}"
                                    autofocus>{{ old('description') }}</textarea>
                        </resizable-textarea>

                        @if ($errors->has('description'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                @include('posts._partials.embed-fields')

                @include('components.preview')

                <div class="form-group row mb-0">
                    <div class="col-md-11 offset-1">
                        <button type="submit" class="btn btn-primary float-right">
                            @lang('Create Comment')
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
