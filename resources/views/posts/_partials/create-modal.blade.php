<form class="create-form" method="POST" action="{{ route('posts.store') }}">
    @csrf

    <div class="form-group">
        <textarea v-model="content" class="content form-control{{ $errors->has('content') ? ' is-invalid' : '' }}"
                  name="content" cols="30" rows="10"
                  autofocus>{{ old('content') }}</textarea>
    </div>

    @include('posts._partials.embed')

    @include('posts._partials.embed-fields')

    <div class="modal-footer">
        <button id="create-modal-btn" type="button" class="btn btn-primary">Create</button>
    </div>
</form>

@push('push_scripts')
    <script>
        $('#create-modal-btn').on('click', function(e) {
            e.preventDefault();
            $(".create-form").submit();
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