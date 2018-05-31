@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="form-group">
            <div class="row">
                <div class="mx-auto">
                    <img data-src="holder.js/75x75" class="rounded-circle" alt="75x75" style="width: 150px; height: 150px;"
                         src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%2275%22%20height%3D%2275%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2075%2075%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_1638c9b279a%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A10pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_1638c9b279a%22%3E%3Crect%20width%3D%2275%22%20height%3D%2275%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2219.34375%22%20y%3D%2242.15%22%3E75x75%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E"
                         data-holder-rendered="true">
                </div>
            </div>
            <div class="row mt-3 justify-content-center">
                <form action="{{ route('users.update', auth()->nickname()) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="mx-auto">
                        <textarea name="bio" id="bio" cols="30" rows="10">{{ old('bio', $user->bio) }}</textarea>
                        <button class="btn btn-primary">update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection