<table class="table table-hover">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Quiz Name</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @if (count($quizes) == 0)
            <tr class="table-light text-center">
                <td colspan="4">No Record found!</td>
            </tr>
        @endif
        @foreach ($quizes as $key => $quiz)
            <tr class="{{ $quiz->status == 1 ? 'table-success' : 'table-danger' }}">
                <td>{{ $key + 1 }}</td>
                <td>{{ $quiz->title }}</td>
                <td>{{ $quiz->status == 1 ? 'Enable' : 'Disable' }}</td>
                <td><button class="btn btn-outline-primary edit-btn" type="button"
                        data-id="{{ \Crypt::encrypt($quiz->id) }}" data-edit_title="{{ $quiz->title }}"
                        data-status={{ $quiz->status }}>Edit</button>
                    <button type="button" class="btn btn-outline-danger btnDelete"
                        data-id="{{ \Crypt::encrypt($quiz->id) }}">Delete</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $quizes->links('pagination::bootstrap-5') }}
