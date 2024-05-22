@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="mt5">
            <h2>
                Results Board
            </h2>
        </div>

        <table class="table table-bordered data-table" id="user_table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Quiz</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Score</th>
                </tr>
            </thead>
            <tbody>
                @if ($results == null)
                    <tr class="table-light text-center">
                        <td colspan="5">No Record found!</td>
                    </tr>
                @endif
                @foreach ($results as $key => $result)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $result->quiz->title }}</td>
                        <td>{{ $result->user->name }}</td>
                        <td>{{ $result->user->email }}</td>
                        <td>{{ $result->total_correct_answers }} / {{ $result->quiz->questions->count() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @push('js')
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        @endpush
    </div>
@endsection
