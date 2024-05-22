<table class="table table-hover">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Quiz Name</th>
            <th>Question</th>
            <th>Status</th>
            <th>Time in Second(s)</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @if (count($questions) == 0)
            <tr class="table-light text-center">
                <td colspan="6">No Record found!</td>
            </tr>
        @endif
        @foreach ($questions as $key => $question)
            <tr class="{{ $question->status == 1 ? 'table-success' : 'table-danger' }}">
                <td>{{ $key + 1 }}</td>
                <td>{{ $question->quiz->title }}</td>
                <td>{{ $question->question }}</td>
                <td>{{ $question->status == 1 ? 'Enable' : 'Disable' }}</td>
                <td>{{ $question->time_limit }}</td>
                <td><button class="btn btn-outline-primary edit-btn" type="button"
                        data-id="{{ \Crypt::encrypt($question->id) }}" data-edit_quiz="{{ $question->quiz->id }}"
                        data-edit_question="{{ $question->question }}" data-status={{ $question->status }}
                        data-edit_time_limit="{{ $question->time_limit }}">Edit</button>
                    <button
                        class="btn answer-btn {{ $question->answers->count() == 0 ? 'btn-warning' : 'btn-outline-dark' }}"
                        type="button" data-id="{{ \Crypt::encrypt($question->id) }}"
                        data-edit_quiz="{{ $question->quiz->id }}"
                        data-edit_question="{{ $question->question }}">Answer for Question</button>
                    <button type="button" class="btn btn-outline-danger btnDelete"
                        data-id="{{ \Crypt::encrypt($question->id) }}">Delete</button>
                    @if ($question->answers->count() == 0)
                        <span class="ml-1"><span class="badge badge-warning">Please add Answers</span></span>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $questions->links('pagination::bootstrap-5') }}
