@extends('layouts.app')
@inject('PostPresenter', '\App\Presenters\PostPresenter')

@section('content')
    <div class="container">
        <div>
            <div class="form-group row justify-content-center">
                <div class="col-md-8 offset-4">
                    <button id="follow" data-id="{{ $user->id }}" {{ $user->id == auth()->id() ? 'disabled': '' }}>
                        {{ auth()->user()->isFollowing($user->id) ? 'unfollow' : 'follow' }}
                    </button>

                    <label class="col-sm-4 col-form-label text-md-right">achievements</label>
                    <div class="col-md-6">
                        <ol>
                            @foreach(\App\Achievement::all() as $achievement)
                                @if (auth()->user()->experience >= $achievement->experience)
                                    <li>{{ $achievement->name }} | {{ $achievement->description }}</li>
                                @endif
                            @endforeach
                        </ol>
                    </div>
                </div>
            </div>

            <div class="col-md-8 offset-2">
                <div class="infinite-scroll list-group">
                    @foreach($posts as $post)
                        <div class="card" style="margin-bottom: 2px;">
                            <div class="card-body">
                                {{--<h5 class="card-title">Special title treatment</h5>--}}
                                <p class="card-text">
                                    {!! $PostPresenter->content($post->content) !!}
                                </p>

                                @if (! empty($post->options['url']))
                                    <div class="preview form-group row justify-content-center">
                                        <div class="col-md-8">
                                            <div class="card">
                                                <img class="preview_image card-img-top" src="{{ $post->options['image'] }}"
                                                     data-src="holder.js/200x250?theme=thumb"
                                                     data-holder-rendered="true"
                                                     style="max-width: 492px;max-height: 256px;"
                                                     alt="no image">
                                                <div class="card-body">
                                                    <p class="preview_body card-text">
                                                        {{ $post->options['title'] }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary float-right">Read more...</a>
                            </div>
                        </div>
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
        $("#follow").on('click', function(e) {
            let id = $(this).data('id');
            axios.post('/api/follow', {
                id: id
            })
                .then(function (response) {
                    let status = response.data.status;
                    if (status === 'follow') {
                        $("#follow").html('unfollow');
                    }

                    if (status === 'unfollow') {
                        $("#follow").html('follow');
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
    </script>
@endpush