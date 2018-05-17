@extends('layouts.app')
@inject('PostPresenter', '\App\Presenters\PostPresenter')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="form-group row">
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

            <div class="col-md-12">
                <div class="infinite-scroll list-group">
                    @foreach($posts as $post)
                        <div class="card">
                            <div class="card-header">#</div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="description"
                                           class="col-sm-4 col-form-label text-md-right">Content</label>

                                    <div class="col-md-6">
                                        <p>{!! $PostPresenter->content($post->content) !!}</p>
                                    </div>
                                </div>

                                @if (! empty($post->options['url']))
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label text-md-right">preview</label>
                                        <div class="col-md-6">
                                            <a href="{{ $post->options['url'] }}" target="_blank"
                                               style="text-decoration: none;color: inherit;">
                                                <div class="card flex-md-row mb-4 box-shadow h-md-250">
                                                    <img class="card-img-left flex-auto d-none d-md-block"
                                                         data-src="holder.js/200x250?theme=thumb"
                                                         alt="Thumbnail [200x250]" style="width: 200px; height: 250px;"
                                                         src="{{ $post->options['image'] }}"
                                                         data-holder-rendered="true">
                                                    <div class="card-body d-flex flex-column align-items-start">
                                                        <h3 class="mb-0">
                                                            {{ $post->options['title'] }}
                                                        </h3>
                                                        <p class="card-text mb-auto">{{ $post->options['description'] }}</p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @endif

                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <a href="{{ route('posts.edit', $post->id) }}">Edit</a>
                                        <a href="#"
                                           onclick="event.preventDefault();document.getElementById('delete-form').submit();">
                                            Delete
                                        </a>

                                        <form id="delete-form" action="{{ route('posts.destroy', $post->id) }}"
                                              method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <a href="{{ route('posts.show', $post->id) }}">全頁閱讀</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js"></script>
    <script>
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
@endsection