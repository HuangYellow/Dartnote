@extends('layouts.app')
@inject('PostPresenter', '\App\Presenters\PostPresenter')
@inject('ContentPresent', '\App\Presenters\ContentPresent')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card" style="margin-bottom: 2px;">
                    <div class="card-body">
                        <div class="row">
                            <label for="content" class="col-md-1 col-form-label">
                                <img data-src="holder.js/75x75" class="rounded-circle" alt="75x75" style="width: 36px; height: 36px;"
                                     src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%2275%22%20height%3D%2275%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2075%2075%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_1638c9b279a%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A10pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_1638c9b279a%22%3E%3Crect%20width%3D%2275%22%20height%3D%2275%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2219.34375%22%20y%3D%2242.15%22%3E75x75%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E"
                                     data-holder-rendered="true">
                            </label>

                            <div class="col-md-11">
                                <span class="align-middle">
                                    <a href="{{ route('users.show', $post->user->nickname) }}">{{ $post->user->nickname }}</a>
                                     ． {{ $post->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>

                        <div class="row">
                            <p class="col-md-11 offset-1" class="card-text">
                                {!! $ContentPresent->content($post->content) !!}
                            </p>
                        </div>

                        @if (! empty($post->options['url']))
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-11">
                                    <div class="card" style="max-width: 506px">
                                        <img class="preview_image card-img-top" src="{{ $post->options['image'] }}"
                                             data-src="holder.js/200x250?theme=thumb"
                                             data-holder-rendered="true"
                                             style="max-width: 506px;max-height: 254px;"
                                             alt="no image">

                                        <div class="card-body">
                                            <div class="card-text">
                                <span class="preview_title" style="font-size: 16pt">
                                    {{ str_limit($post->options['title'], 50) }}
                                </span>
                                                <div class="preview_description">
                                                    {{ str_limit($post->options['description'], 100) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @auth
            <div class="row mt-3 justify-content-center">
                @include('comments._partials.form')
            </div>
        @endauth

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="infinite-scroll list-group">
                    @foreach($comments as $comment)
                        @include('posts._partials.comments')
                    @endforeach

                    {{ $comments->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('push_scripts')
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

            axios.post('/api/like', {
                id: id
            })
                .then(function (response) {
                    let that = $this;
                    let count = parseInt(that.find('span').text());
                    let status = response.data.status;
                    if (status === 'like') {
                        that.html("{{ __('Unlike') }}(<span>"+ (count + 1) +"</span>)");
                    }

                    if (status === 'unlike') {
                        that.html("{{ __('Like') }}(<span>"+ (count - 1) +"</span>)");
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
        });

        $(".description").keyup(function () {
            let val = $(this).val();
            if (!val.length) {
                $(".preview").addClass("hidden");
                $(".preview_image").attr('src', '#');
                $(".preview_body").text('');
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
                            $(".preview_body").text(response.data.title);
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
    </script>
@endpush