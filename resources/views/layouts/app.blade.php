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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

    <style>
        .hidden {
            display: none;
        }
        .outline-0 {
            outline: 0;
        }
        .resize-none {
            resize: none;
        }
    </style>

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
                        <li>
                            <a class="nav-link" href="{{ route('login') }}">
                                @lang("Login")
                            </a>
                        </li>
                        <li>
                            <a class="nav-link" href="{{ route('register') }}">
                                @lang("Register")
                            </a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('users.show', auth()->user()->nickname) }}">
                                    @lang('Profile')
                                </a>
                                <a class="dropdown-item" href="{{ route('users.achievements', auth()->user()->nickname) }}">
                                    @lang('Achievements')
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
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Congrats!</strong> @lang(session()->get('success'))
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif


    <main class="py-4">
        @yield('content')
    </main>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js"></script>

<script>
    Vue.component('resizable-textarea', {
        methods: {
            resizeTextarea (event) {
                event.target.style.height = 'auto'
                event.target.style.height = (event.target.scrollHeight) + 'px'
            },
        },
        mounted () {
            this.$nextTick(() => {
                this.$el.setAttribute('style', 'height:' + (this.$el.scrollHeight) + 'px;overflow-y:hidden;')
            });

            this.$el.addEventListener('input', this.resizeTextarea);
        },
        beforeDestroy () {
            this.$el.removeEventListener('input', this.resizeTextarea);
        },
        render () {
            return this.$slots.default[0];
        },
    });

    var app = new Vue({
        el: "#app",
        data: {
            content : ''
        },
    });

    $(".like").on('click', function(e) {
        let $this = $(this);
        let id = $this.data('id');
        let type = $this.data('type');

        axios.post('/api/like', {
            id: id,
            type: type
        })
            .then(function (response) {
                let that = $this;
                let count = parseInt(that.find('span').text());
                let status = response.data.status;
                if (status === 'like') {
                    that.html("<i class=\"text-danger fas fa-heart fa-lg swatch-red\"></i> <span style='font-size: 1.33333em'>"+ (count + 1) +"</span>");
                }

                if (status === 'unlike') {
                    that.html("<i class=\"far fa-heart fa-lg\"></i> <span style='font-size: 1.33333em'>"+ (count - 1) +"</span>");
                }
            })
            .catch(function (error) {
                console.log(error);
            });
    });

    $('ul.pagination').hide();

    $(function() {
        $('.infinite-scroll').jscroll({
            autoTrigger: true,
            loadingHtml: '<h1>Loading</h1>',
            padding: 0,
            nextSelector: '.pagination li.active + li a',
            contentSelector: 'div.infinite-scroll',
            callback: function() {
                $('ul.pagination').remove();
            }
        });
    });

    $(".content").keyup(function () {
        let val = $(this).val();
        if (!val.length) {
            $(".preview").addClass("hidden");
            $(".preview_image").attr('src', '#');
            $(".preview_title").text('');
            $(".preview_description").text('');
            $("input[name='options[url]']").val('');
            $("input[name='options[title]']").val('');
            $("input[name='options[description]']").val('');
            $("input[name='options[image]']").val('');
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
                        $(".preview_image").attr('src', response.data.image);
                        $(".preview_title").text(response.data.title);
                        $(".preview_description").text(response.data.description.substring(0, 60));
                        $(".preview").removeClass("hidden");

                        $("input[name='options[url]']").val(response.data.url);
                        $("input[name='options[title]']").val(response.data.title);
                        $("input[name='options[description]']").val(response.data.description);
                        $("input[name='options[image]']").val(response.data.image);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }
        });
</script>

@stack('scripts')
</body>
</html>
