@extends('layouts.app')
@inject('PostPresenter', '\App\Presenters\PostPresenter')
@inject('ContentPresent', '\App\Presenters\ContentPresent')

@section('content')
    <div class="container">
        <div class="form-group">
            <div class="row">
                <div class="mx-auto">
                    <img data-src="holder.js/75x75" class="rounded-circle" alt="75x75" style="width: 150px; height: 150px;"
                         src="{{ gavatar($user->email) }}"
                         data-holder-rendered="true">
                </div>
            </div>
            <div class="row mt-3">
                <div class="mx-auto">
                    @if(auth()->user()->can('users.update', $user))
                        <a class="btn btn-outline-primary" href="{{ route('users.edit', auth()->nickname()) }}">
                            @lang("Edit Profile")
                        </a>
                    @else
                        <button id="follow" data-id="{{ $user->id }}" type="button" class="btn btn-{{ auth()->user()->isFollowing($user->id) ? 'outline-primary' : 'primary' }}">
                            @lang(auth()->user()->isFollowing($user->id) ? "Unfollow" : "Follow")
                        </button>
                    @endif
                </div>
            </div>
            <div class="row mt-3 justify-content-center">
                <div class="mx-auto">
                    {{ $user->bio }}
                </div>
            </div>
        </div>

        <div class="form-group row justify-content-lg-center">
            <div class="col-6">
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
        $("#follow").on('click', function(e) {
            let id = $(this).data('id');
            axios.post('/api/follow', {
                id: id
            })
                .then(function (response) {
                    let status = response.data.status;
                    if (status === 'follow') {
                        let follow = $("#follow");
                        follow.removeClass('btn-primary').addClass('btn-outline-primary').html("{{ __('Unfollow') }}");

                    }

                    if (status === 'unfollow') {
                        let unfollow = $("#follow");
                        unfollow.removeClass('btn-outline-primary').addClass('btn-primary').html("{{ __('Follow') }}");
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