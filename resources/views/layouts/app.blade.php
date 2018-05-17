<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @yield('style')
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                        <li><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                    @else
                        <li>
                            <a class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                @lang('Create Post')
                            </a>
                        </li>

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('users.show', auth()->user()->nickname) }}">
                                    @lang('Profile')
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    @lang('Logout')
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>

                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">
                                            @lang('Create New Post')
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="create-form" method="POST" action="{{ route('posts.store') }}">
                                            @csrf

                                            <input type="hidden" id="url" name="options[url]">
                                            <input type="hidden" id="title" name="options[title]">
                                            <input type="hidden" id="description" name="options[description]">
                                            <input type="hidden" id="image" name="options[image]">

                                            <div class="form-group">
                                                <textarea class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}"
                                                          name="content" id="content" cols="30" rows="10"
                                                          autofocus>{{ old('content') }}</textarea>
                                            </div>

                                            <div id="preview" class="form-group row hidden"></div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button id="create-btn" type="button" class="btn btn-primary">Create</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
</div>

<!--content script-->
<script>
    $('#create-btn').on('click', function(e) {
        e.preventDefault();
        $("#create-form").submit();
    });

    $("#content").keyup(function () {
        let val = $(this).val();
        if (!val.length) {
            $("#preview").html('').addClass("hidden");
        }
    })
        .on('paste', function (e) {
            var data = e.originalEvent.clipboardData.getData('Text');
            var url = data.match(/\b(http([s]?)):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|]/ig);
            if (url) {
                axios.post('/api/embed', {
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    url: url[0]
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

@yield('script')
</body>
</html>
