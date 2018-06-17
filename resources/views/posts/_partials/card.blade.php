<div class="card mb-2">
    <div class="card-body">
        <div class="row">
            <label for="content" class="col-1 col-form-label">
                <img data-src="holder.js/75x75" class="rounded-circle" alt="75x75" style="width: 36px; height: 36px;"
                     src="{{ gavatar($post->user->email) }}"
                     data-holder-rendered="true">
            </label>

            <div class="col-11 mt-2">
                <span class="align-middle">
                    <a href="{{ route('users.show', $post->user->nickname) }}">{{ $post->user->nickname }}</a>
                     ．{{ $post->created_at->diffForHumans() }}．@lang($PostPresenter->status($post->status))
                </span>
            </div>
        </div>

        <div class="row">
            <p class="col-11 offset-1" class="card-text">
                {!! $ContentPresent->content($post->content) !!}
            </p>
        </div>

        @if (! empty($post->options['url']))
            <div class="row">
                <div class="col-11 offset-1">
                    <a href="{{ $post->options['url'] }}" target="_blank" style="text-decoration: none !important;color: #212529">
                        <div class="card" style="max-width: 506px">
                            <img class="preview_image card-img-top" src="{{ $post->options['image'] }}"
                                 data-src="holder.js/200x250?theme=thumb"
                                 data-holder-rendered="true"
                                 style="max-width: 506px;max-height: 254px;"
                                 alt="no image">

                            <div class="card-body">
                                <div class="card-text">
                                    <span class="preview_title" style="font-size: 16pt;">
                                        {{ str_limit($post->options['title'], 50) }}
                                    </span>
                                    <div class="preview_description" style="text-decoration: none;">
                                        {{ str_limit($post->options['description'], 100) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        @endif

        <span class="float-left offset-1 mt-4">
            <a href="{{ auth()->guest() ? route('login') : 'javascript:void(0);' }}" data-id="{{ $post->id }}" data-type="{{ $type }}" class="like" style="text-decoration: none;">
                @lang($post->auth_like->isNotEmpty() ? "Unlike" : "Like")&nbsp;(<span>{{ $post->likers_count }}</span>)
            </a>
            ．
            <a href="{{ route('posts.show', $post->id) }}">
                @lang('Comments')&nbsp;(<span>{{ $post->comments_count }}</span>)
            </a>
        </span>

        <a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary float-right mt-3">
            @lang("Read more")
        </a>
    </div>
</div>