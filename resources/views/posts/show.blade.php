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
            <div class="col-md-6">
                @include('posts._partials.card')
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