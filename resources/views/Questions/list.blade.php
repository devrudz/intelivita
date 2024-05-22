@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="container mt-5">
            <!-- Add New Button -->
            <button type="button" class="btn btn-outline-dark float-end mb-3" data-toggle="modal" data-target="#addModal"
                onClick="return resetSaveQuestionForm()">
                Add New Questions
            </button>

            <div id="questionListTable" class="table table-responsive">
                @include('Questions.questions-list')
            </div>


            <!-- Add New Question Modal -->
            <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addModalLabel">Add New Question</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Form for adding new item -->
                            <form id="saveNewQuestion" action-url="{{ route('questions.store') }}" method="POST">
                                @csrf
                                @method('post')
                                <div class="form-group">
                                    <label for="quiz_id">Quiz</label>
                                    <select name="quiz_id" class="form-control" id="quiz_id">
                                        <option value="">Select Quiz</option>
                                        @foreach ($quizes as $key => $quiz)
                                            <option value="{{ $quiz->id }}">{{ $quiz->title }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error" id="add_errorTextquiz"></span>
                                </div>
                                <div class="form-group">
                                    <label for="question">Question</label>
                                    <textarea class="form-control" name="question" id="question" placeholder="Enter Question"></textarea>
                                    <span class="text-danger" id="add_errorTextquestion"></span>
                                </div>
                                <div class="form-group">
                                    <label for="time_limit">Timer for Question (in Seconds) </label>
                                    <input type="range" id="time_limit" name="time_limit" min="1" max="600"
                                        value="60" class="form-range">
                                    <span id="showRangeNumber">60</span>
                                    <span class="text-danger" id="add_errorTexttime_limit"></span>
                                </div>
                                <button type="submit" id="btn-saveNewQuestion" class="btn btn-primary">Add New
                                    Question</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Question Modal -->
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Question</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Form for adding new item -->
                            <form id="editQuestion" action-url="" method="POST">
                                @csrf
                                @method('post')
                                <input type="hidden" id="editId" name="editId" value="">
                                <div class="form-group">
                                    <label for="edit_quiz_id">Quiz</label>
                                    <select name="quiz_id" class="form-control" id="edit_quiz_id">
                                        <option value="">Select Quiz</option>
                                        @foreach ($quizes as $key => $quiz)
                                            <option value="{{ $quiz->id }}">{{ $quiz->title }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error" id="edit_errorTextquiz"></span>
                                </div>
                                <div class="form-group">
                                    <label for="name">Question</label>
                                    <textarea class="form-control" name="question" id="edit_question" placeholder="Enter Question"></textarea>
                                    <span class="text-danger" id="edit_errorTextquestion"></span>
                                </div>
                                <div class="form-group">
                                    <label for="name">Status</label>
                                    <select name="status" class="form-control" id="edit_status">
                                        <option value="">Select Stauts</option>
                                        <option value="1">Enable</option>
                                        <option value="0">Disable</option>
                                    </select>
                                    <span class="text-danger error" id="edit_errorTextstatus"></span>
                                </div>
                                <div class="form-group">
                                    <label for="edit_time_limit">Timer for Question (in Seconds) </label>
                                    <input type="range" id="edit_time_limit" name="time_limit" min="1"
                                        max="600" value="60" class="form-range">
                                    <span id="edit_showRangeNumber">60</span>
                                    <span class="text-danger" id="edit_errorTexttime_limit"></span>
                                </div>
                                <button type="submit" id="btn-editQuestion" class="btn btn-primary">Update
                                    Question</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Answer Modal -->
            <div class="modal fade" id="questionAnswersModal" tabindex="-1" role="dialog"
                aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Answer</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Form for adding new item -->
                            <form id="storeAnswers" action-url="{{ route('answers.store') }}" method="POST">
                                @csrf
                                @method('post')
                                <div class="form-group">
                                    <h4 id="qa_question"></h4>
                                </div>
                                <div id="input-container"></div>
                                <div class="form-group">
                                    <button type="button" id="add-input" class="btn btn-danger text-white">Add wrong
                                        Answer</button>
                                    <button type="button" id="add-correct-ans"
                                        class="btn btn-success bg-success text-white">Add correct Answer</button>
                                </div>
                                <div class="form-group mt-3 center">
                                    <button type="submit" id="btn-Question-Answer" class="btn btn-primary">Save Answers
                                        to Question</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            function resetSaveQuestionForm() {
                $('#quiz_id').val('');
                $('#question').val('');
                $('#time_limit').val(60);
                $('#showRangeNumber').text(60);

            }

            $(document).ready(function() {

                $(document).on('submit', '#saveNewQuestion', function(e) {
                    e.preventDefault();
                    $('#errorText').text('');
                    var formData = $('#saveNewQuestion').serialize();
                    console.log(formData);
                    var url = $('#saveNewQuestion').attr('action-url');
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            $('#questionListTable').html(response.questions_list);
                            $('.close').click();
                            $('#successMessage').text(response.message);
                            $('#ajaxToast').toast('show');
                        },
                        error: function(xhr, status, error) {
                            // Handle errors here
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                $('#errorText').text(value);
                                $('#errorMessage').html('');
                                $('#errorMessage').append('<p>' + value + '</p>');
                            });

                            $('#errorToast').toast('show');
                        }
                    });
                });
                $(function() {
                    $('#saveNewQuestion').validate({
                        rules: {
                            quiz_id: {
                                required: true,
                            },
                            question: {
                                required: true,
                                minlength: 5,
                            },
                        }
                    });
                });

                $(function() {
                    $('#editQuestion').validate({
                        rules: {
                            quiz_id: {
                                required: true,
                            },
                            question: {
                                required: true,
                                minlength: 5,
                            },
                            status: {
                                required: true,
                            },
                        }
                    });
                });

                // Edit Quiz

                $(document).on('click', '.edit-btn', function() {
                    var recordId = $(this).data('id');
                    $('#edit_quiz_id').val($(this).data('edit_quiz'));
                    $('#edit_question').val($(this).data('edit_question'));
                    $('#edit_status').val($(this).data('status'));
                    $('#edit_time_limit').val($(this).data('edit_time_limit'));
                    $('#edit_showRangeNumber').text($(this).data('edit_time_limit'));
                    $('#editId').val(recordId);
                    $('#editModal').modal('show');
                });


                $(document).on('submit', '#editQuestion', function(e) {
                    e.preventDefault();
                    $('#edit_errorText').text('');
                    var formData = $('#editQuestion').serialize();
                    var editId = $('#editId').val();
                    var url = 'questions/' + editId;
                    $.ajax({
                        url: url,
                        type: 'PUT',
                        data: formData,
                        beforeSend: function(xhr) {
                            $('.error').text('');
                        },
                        success: function(response) {
                            $('#questionListTable').html(response.questions_list);
                            $('.close').click();
                            $('#successMessage').text(response.message);
                            $('#ajaxToast').toast('show');
                        },
                        error: function(xhr, status, error) {
                            // Handle errors here
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                $('#edit_errorText' + key).text(value);
                                $('#errorMessage').html('');
                                $('#errorMessage').append('<p>' + value + '</p>');
                            });

                            $('#errorToast').toast('show');
                        }

                    });
                });


                // Delete Quiz

                $(document).on('click', '.btnDelete', function() {
                    var recordId = $(this).data('id');
                    var confirmation = confirm('Are you sure you want to delete this Quiz?');
                    if (confirmation) {
                        $.ajax({
                            url: 'questions/' + recordId,
                            type: 'DELETE',
                            success: function(response) {
                                $('#successMessage').text(response.message);
                                $('#questionListTable').html(response.questions_list);
                                $('#ajaxToast').toast('show');
                            },
                            error: function(xhr, status, error) {
                                console.log(xhr);
                                var error = xhr.responseJSON.error;
                                $('#errorMessage').html('');
                                $('#errorMessage').append('<p>' + error + '</p>');
                                $('#errorToast').toast('show');
                            }
                        });
                    }
                });

                $(document).on('click', '.close', function() {
                    $('.modal').modal('hide');
                })

                $('#time_limit').on('input', function() {
                    $('#showRangeNumber').text($(this).val());
                })
                $('#edit_time_limit').on('input', function() {
                    $('#edit_showRangeNumber').text($(this).val());
                })

                // Add input field when button is clicked
                var inputCount = 0;
                $('#add-input').click(function() {
                    inputCount++;
                    $('#input-container').append(
                        '<input type="text" class="form-control bg-danger" name="answer_' + inputCount +
                        '" placeholder="Enter Answer ' + inputCount + '"><br>');
                });
                $('#add-correct-ans').click(function() {
                    inputCount++;
                    $('#input-container').append(
                        '<input type="text" class="form-control bg-success" name="correct_answer_' +
                        inputCount + '" placeholder="Enter Correct Answer ' + inputCount + '"><br>');
                });


                // Store answer for questions

                $(document).on('submit', '#storeAnswers', function(e) {
                    e.preventDefault();
                    $('#edit_errorText').text('');
                    var formData = $('#storeAnswers').serialize();
                    var questionId = $('#question_id').val();
                    var url = $('#storeAnswers').attr('action-url');
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: formData,
                        beforeSend: function(xhr) {
                            $('.error').text('');
                        },
                        success: function(response) {
                            $('#questionListTable').html(response.questions_list);
                            $('.close').click();
                            $('#successMessage').text(response.message);
                            $('#ajaxToast').toast('show');
                        },
                        error: function(xhr, status, error) {
                            // Handle errors here
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                $('#edit_errorText' + key).text(value);
                                $('#errorMessage').html('');
                                $('#errorMessage').append('<p>' + value + '</p>');
                            });

                            $('#errorToast').toast('show');
                        }

                    });
                });

                // Get Answer view

                $(document).on('click', '.answer-btn', function(e) {
                    e.preventDefault();
                    var recordId = $(this).data('id');
                    var url = 'questions/' + recordId;
                    $.ajax({
                        url: url,
                        type: 'GET',
                        beforeSend: function(xhr) {
                            $('.error').text('');
                        },
                        success: function(response) {
                            $('#input-container').html(response.qa);
                            $('#qa_question').text($(this).data('edit_question'));
                            $('#questionAnswersModal').modal('show');
                        },
                        error: function(xhr, status, error) {}

                    });


                });
                // Delete Answers

                $(document).on('click', '.btnDeleteAnswer', function() {
                    var recordId = $(this).data('id');
                    var confirmation = confirm('Are you sure you want to delete this Answer?');
                    if (confirmation) {
                        $.ajax({
                            url: 'answers/' + recordId,
                            type: 'DELETE',
                            success: function(response) {
                                $('#successMessage').text(response.message);
                                $('#input-container').html(response.qa);
                                $('#ajaxToast').toast('show');
                            },
                            error: function(xhr, status, error) {
                                console.log(xhr);
                                var error = xhr.responseJSON.error;
                                $('#errorMessage').html('');
                                $('#errorMessage').append('<p>' + error + '</p>');
                                $('#errorToast').toast('show');
                            }
                        });
                    }
                });
            });
        </script>
