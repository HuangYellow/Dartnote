@extends('layouts.app')
@inject('PostPresenter', '\App\Presenters\PostPresenter')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12" style="padding-bottom: 10px;">
                <div class="card">
                    <div class="card-header">Create Post</div>

                    <div class="card-body">
                        <form id="create-form" method="POST" action="{{ route('posts.store') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="content" class="col-sm-4 col-form-label text-md-right">Content</label>

                                <div class="col-md-6">
                                    <textarea class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}" name="content" id="content" cols="30" rows="10" autofocus>{{ old('content') }}</textarea>

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
            </div>
            <div class="col-md-12">
                <div class="list-group">
                    @foreach($posts as $post)
                        <div class="card">
                            <div class="card-header">#</div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="description" class="col-sm-4 col-form-label text-md-right">Content</label>

                                    <div class="col-md-6">
                                        <p>{!! $PostPresenter->content($post->content) !!}</p>
                                    </div>
                                </div>

                                @if (! empty($post->options))
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label text-md-right">preview</label>
                                        <div class="col-md-6">
                                            <a href="{{ $post->options['url'] }}" target="_blank" style="text-decoration: none;color: inherit;">
                                                <div class="card flex-md-row mb-4 box-shadow h-md-250">
                                                    <img class="card-img-left flex-auto d-none d-md-block"
                                                         data-src="holder.js/200x250?theme=thumb" alt="Thumbnail [200x250]" style="width: 200px; height: 250px;"
                                                         src="{{ $post->options['image'] }}" data-holder-rendered="true">
                                                    <div class="card-body d-flex flex-column align-items-start">
                                                        <h3 class="mb-0">
                                                            {{ $post->options['title'] }}
                                                        </h3>
                                                        <p class="card-text mb-auto">{{ $post->options['description'] }}</p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @endif

                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <a href="{{ route('posts.edit', $post->id) }}">Edit</a>
                                        <a href="#" onclick="event.preventDefault();document.getElementById('delete-form').submit();">
                                            Delete
                                        </a>

                                        <form id="delete-form" action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <a href="{{ route('posts.show', $post->id) }}">全頁閱讀</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $("#content").on('paste', function(e) {
            var data = e.originalEvent.clipboardData.getData('Text');
            if (data.match(/^http([s]?):\/\/.*/)) {
                axios.post('/api/embed', {
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    url: data
                })
                    .then(function (response) {
                        $("#preview").html(`
                        <label class="col-sm-4 col-form-label text-md-right">preview</label>
                            <div class="col-md-6">
                                <div class="card" style="width: 18rem;">
                                    <img id="preview_image" class="card-img-top" src="${response.data.image}" alt="Card image cap">
                                    <div class="card-body">
                                        <p id="preview_body" class="card-text">${response.data.title}</p>
                                    </div>
                                </div>
                            </div>`).removeClass("hidden");

                        $("#url").val(response.data.url);
                        $("#title").val(response.data.title);
                        $("#description").val(response.data.description);
                        $("#image").val(response.data.image);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }
        });
    </script>
@endsection