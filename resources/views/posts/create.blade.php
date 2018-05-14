@extends('layouts.app')

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