<div class="card">
    <div class="card-header">Create Post</div>

    <div class="card-body">
        <form id="create-form" method="POST" action="{{ route('posts.store') }}">
            @csrf

            <div class="form-group row">
                <label for="content" class="col-sm-4 col-form-label text-md-right">Content</label>

                <div class="col-md-6">
                                    <textarea class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}"
                                              name="content" id="content" cols="30" rows="10"
                                              autofocus>{{ old('content') }}</textarea>

                    @if ($errors->has('content'))
                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('content') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>

            <div id="preview" class="form-group row hidden"></div>

            <input type="hidden" id="url" name="options[url]">
            <input type="hidden" id="title" name="options[title]">
            <input type="hidden" id="description" name="options[description]">
            <input type="hidden" id="image" name="options[image]">

            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        Create
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>