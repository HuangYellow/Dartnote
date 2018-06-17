<div class="col-12">
    <div class="card mb-4">
        <div class="card-body">
            <form method="POST" action="{{ route('comments.store', $post->id) }}">
                @csrf
                <div class="form-group row">
                    <div class="col-12">
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
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary float-right">
                            @lang('Create Comment')
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
