@extends('layouts.app')
@inject('PostPresenter', '\App\Presenters\PostPresenter')
@inject('ContentPresent', '\App\Presenters\ContentPresent')

@section('style')
    <style>
        .outline-0 {
            outline: 0;
        }
        .resize-none {
            resize: none;
        }
    </style>
@endsection

@section('content')
<div class="container">
    @auth
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form id="create-form" method="POST" action="{{ route('posts.store') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="content" class="col-md-1 col-form-label text-md-right">
                                    <img data-src="holder.js/75x75" class="rounded-circle" alt="75x75" style="width: 36px; height: 36px;" src="{{ auth()->gavatar() }}" data-holder-rendered="true">
                                </label>

                                <div class="col-md-11">
                                    <resizable-textarea>
                                        <textarea v-model="content" class="content form-control{{ $errors->has('content') ? ' is-invalid' : '' }} resize-none outline-0"
                                                  name="content" rows="2" placeholder="{{ __('What does you think?') }}"
                                                  autofocus>{{ old('content') }}</textarea>
                                    </resizable-textarea>

                                    @if ($errors->has('content'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('content') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

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

                            @include('posts._partials.embed-fields')

                            <div class="form-group row mb-0">
                                <div class="col-md-1"></div>
                                <div class="col-md-11">
                                    <button type="submit" class="btn btn-primary float-right">
                                        @lang('Create Post')
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endauth

    <div class="row mt-3 justify-content-center">
        <div class="col-md-6">
            <div class="infinite-scroll list-group">
                @foreach($posts as $post)
                    @include('posts._partials.card')
                @endforeach

                {{ $posts->links() }}
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

        $(".content").keyup(function () {
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