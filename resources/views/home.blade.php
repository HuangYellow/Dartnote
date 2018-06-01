@extends('layouts.app')

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
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                        <form id="create-form" method="POST" action="{{ route('posts.store') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="content" class="col-md-1 col-form-label text-md-right">
                                    <img data-src="holder.js/75x75" class="rounded-circle" alt="75x75" style="width: 36px; height: 36px;" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%2275%22%20height%3D%2275%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2075%2075%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_1638c9b279a%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A10pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_1638c9b279a%22%3E%3Crect%20width%3D%2275%22%20height%3D%2275%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2219.34375%22%20y%3D%2242.15%22%3E75x75%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true">
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
</div>
@endsection

@push('push_scripts')
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
    </script>
@endpush