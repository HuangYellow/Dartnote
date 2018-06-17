<div id="L{{ $index+1 }}" class="card mb-1">
    <div class="card-body">
        <div class="row">
            <label for="content" class="col-2 col-form-label">
                <img data-src="holder.js/75x75" class="rounded-circle" alt="75x75" style="width: 36px; height: 36px;"
                     src="{{ gravatar($comment->user->email) }}"
                     data-holder-rendered="true">
            </label>

            <div class="mt-2">
                <span class="align-middle">
                    <a href="{{ route('users.show', $comment->user->nickname) }}">{{ $comment->user->nickname }}</a>
                     ．{{ $comment->created_at->diffForHumans() }}．@lang($PostPresenter->status($comment->status))
                </span>
            </div>
        </div>

        <div class="row">
            <p class="col-12" class="card-text">
                {!! $ContentPresent->content($comment->description) !!}
            </p>
        </div>

        @auth
            <div class="mt-3 row">
                <div class="col-4 justify-content-start">
                    <a href="{{ auth()->guest() ? route('login') : 'javascript:void(0);' }}" data-id="{{ $comment->id }}" data-type="comment" class="like" style="text-decoration: none;">
                        <i class="{{ $comment->auth_like->isNotEmpty() ? 'text-danger fas' : 'far' }} fa-heart fa-lg"></i>
                        <span class="pl-1" style="font-size: 1.33333em">{{ $comment->likers_count }}</span>
                    </a>
                </div>
                <div class="col-4 offset-4 justify-content-end text-right">
                    <a href="#L{{ $index+1 }}" style="font-size: 1.33333em;">#L{{ $index+1 }}</a>
                </div>
            </div>
        @endauth
    </div>
</div>