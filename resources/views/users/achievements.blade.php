@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mt-3">
            <div class="mx-auto">
                <h3>
                    @lang('Achievements')
                </h3>
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
@endsection