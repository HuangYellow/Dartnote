@extends('layouts.app')
@inject('PostPresenter', '\App\Presenters\PostPresenter')

@section('content')
    <div class="container">
        <div>
            <div class="form-group justify-content-center">
                <div class="row">
                    <div class="mx-auto">
                        <img data-src="holder.js/75x75" class="rounded-circle" alt="75x75" style="width: 150px; height: 150px;"
                             src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%2275%22%20height%3D%2275%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2075%2075%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_1638c9b279a%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A10pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_1638c9b279a%22%3E%3Crect%20width%3D%2275%22%20height%3D%2275%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2219.34375%22%20y%3D%2242.15%22%3E75x75%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E"
                             data-holder-rendered="true">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="mx-auto">
                        <button id="follow" data-id="{{ $user->id }}" type="button" class="btn btn-{{ auth()->user()->isFollowing($user->id) ? 'outline-primary' : 'primary' }}" {{ $user->id == auth()->id() ? 'disabled': '' }}>
                            {{ auth()->user()->isFollowing($user->id) ? 'unfollow': 'follow' }}
                        </button>
                    </div>
                </div>
            </div>

            <div class="form-group row justify-content-lg-center">
                <div class="col-md-6">
                    <div class="infinite-scroll list-group">
                        @foreach($posts as $post)
                            @push('readmore')
                                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary float-right mt-3">Read more...</a>
                            @endpush

                            @include('posts._partials.card')
                        @endforeach

                        {{ $posts->links() }}
                    </div>
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
                        let follow = $("#follow");
                        follow.removeClass('btn-primary').addClass('btn-outline-primary').html('unfollow');

                    }

                    if (status === 'unfollow') {
                        let unfollow = $("#follow");
                        unfollow.removeClass('btn-outline-primary').addClass('btn-primary').html('follow');
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