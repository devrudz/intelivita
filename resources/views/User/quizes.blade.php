@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="container mt-5">
            <div id="quizListTable" class="table table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Quiz Name</th>
                            <th>Total Questions</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($quizes == null)
                            <tr class="table-light text-center">
                                <td colspan="4">No Record found!</td>
                            </tr>
                        @endif
                        @foreach ($quizes as $key => $quiz)
                            <tr class="{{ $quiz->status == 1 ? 'table-success' : 'table-danger' }}">
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $quiz->title }}</td>
                                <td>{{ $quiz->questions->where('status', 1)->count() }}</td>
                                <td><a
                                        href="{{ Session::has('quiz_start') && collect(Session::get('quiz_start'))->contains($quiz->id) ? 'javascript:void(0)' : route('quizes.show', \Crypt::encrypt($quiz->id)) }}">
                                        <button
                                            {{ Session::has('quiz_start') && collect(Session::get('quiz_start'))->contains($quiz->id) ? 'disabled' : '' }}
                                            class="btn btn-outline-primary edit-btn" type="button">Start Quiz</button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $quizes->links('pagination::bootstrap-5') }}

            </div>
            <div class="text-danger font-weight-bold">
                <p>Note : Once you start Quiz, you can not refresh a page or can not go back, else Quiz will be terminate!
                </p>
            </div>
        </div>
    </div>
@endsection
