@extends('layouts.app')
@inject('PostPresenter', '\App\Presenters\PostPresenter')

@section('style')
    <style>
        .hidden {
            display: none;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">#</div>
                    <div class="card-body">
                            <div class="form-group row">
                                <label for="description" class="col-sm-4 col-form-label text-md-right">Content</label>

                                <div class="col-md-6">
                                    <p>{!! $PostPresenter->content($post->content) !!}</p>
                                </div>
                            </div>

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
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $("#content").keyup(function (e) {
            let val = $(this).val();
            if (val.match(/^http([s]?):\/\/.*/)) {
                if (e.which == 13) {
                    axios.post('/api/embed', {
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        url: val
                    }).then(function (response) {
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
            } else {
                $("#preview").html('').addClass("hidden");
                $("#options").val('');
            }
        }).on('paste', function(e) {
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