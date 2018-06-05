<div class="col-md-6">
    <div class="card" style="margin-bottom: 2px;">
        <div class="card-body">
            <form method="POST" action="{{ route('comments.store', $post->id) }}">
                @csrf

                <div class="form-group row">
                    <label for="content" class="col-md-1 col-form-label text-md-right">
                        <img data-src="holder.js/75x75" class="rounded-circle" alt="75x75"
                             style="width: 36px; height: 36px;"
                             src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%2275%22%20height%3D%2275%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2075%2075%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_1638c9b279a%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A10pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_1638c9b279a%22%3E%3Crect%20width%3D%2275%22%20height%3D%2275%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2219.34375%22%20y%3D%2242.15%22%3E75x75%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E"
                             data-holder-rendered="true">
                    </label>

                    <div class="col-md-11">
                        <resizable-textarea>
                                        <textarea
                                                class="description form-control{{ $errors->has('content') ? ' is-invalid' : '' }} resize-none outline-0"
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

                <div class="preview form-group row hidden">
                    <div class="col-md-8 offset-1">
                        <div class="card">
                            <img class="preview_image card-img-top" src="#" alt="no image" style="max-width: 492px;max-height: 256px;">
                            <div class="card-body">
                                <p class="preview_body card-text"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-1"></div>
                    <div class="col-md-11">
                        <button type="submit" class="btn btn-primary float-right">
                            @lang('Create Comment')
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
