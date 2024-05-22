@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @if (count($results) == 0)
                <div class="m-5 text-center">
                    <h3>Result not found!</h3>
                </div>
            @else
                @foreach ($results as $result)
                    <div class="col-md-3 mt-3">
                        <div class="card text-center">
                            <div class="card-header">
                                Quiz Name : <b>{{ $result->quiz->title }}</b>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Score : {{ $result->total_correct_answers }} /
                                    {{ $result->quiz->questions->where('status', 1)->count() }}</h5>
                            </div>
                            <div class="card-footer text-muted">
                                {{ $result->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </div>
@endsection
