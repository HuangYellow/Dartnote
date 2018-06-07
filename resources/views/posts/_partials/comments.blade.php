<div class="card" style="margin-bottom: 2px;">
    <div class="card-body">
        <div class="row">
            <label for="content" class="col-md-1 col-form-label">
                <img data-src="holder.js/75x75" class="rounded-circle" alt="75x75" style="width: 36px; height: 36px;"
                     src="{{ gavatar($comment->user->email) }}"
                     data-holder-rendered="true">
            </label>

            <div class="col-md-11 mt-2">
                <span class="align-middle">
                    <a href="{{ route('users.show', $comment->user->nickname) }}">{{ $comment->user->nickname }}</a>
                     ．{{ $comment->created_at->diffForHumans() }}．@lang($PostPresenter->status($comment->status))
                </span>
            </div>
        </div>

        <div class="row">
            <p class="col-md-11 offset-1" class="card-text">
                {!! $ContentPresent->content($comment->description) !!}
            </p>
        </div>

        <span class="float-left offset-1 mt-4">
            <a href="{{ auth()->guest() ? route('login') : 'javascript:void(0);' }}" data-id="{{ $comment->id }}" data-type="comment" class="like" style="text-decoration: none;">
                @lang($comment->auth_like->isNotEmpty() ? "Unlike" : "Like")&nbsp;(<span>{{ $comment->likers->count() }}</span>)
            </a>
        </span>
    </div>
</div>