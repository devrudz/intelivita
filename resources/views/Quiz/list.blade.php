@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="container mt-5">
        <!-- Add New Button -->
        <button type="button" class="btn btn-outline-dark float-end mb-3" data-toggle="modal" data-target="#addModal">
          Add New Quiz
        </button>

        <div id="quizListTable" class="table table-responsive">
            @include('Quiz.quizes-list')
        </div>


      <!-- Add New Modal -->
      <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="addModalLabel">Add New Quiz</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <!-- Form for adding new item -->
              <form id="saveNewQuize" action-url="{{ route('quizzes.store') }}" method="POST">
                @csrf
                @method('post')
                <div class="form-group">
                  <label for="name">Title</label>
                  <input type="text" class="form-control" name="title" id="title" placeholder="Enter Quiz Title">
                  <span class="text-danger" id="errorText"></span>
                </div>
                <button type="submit" id="btn-saveNewQuize" class="btn btn-primary">Add New Quiz</button>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Edit Quiz Modal -->
      <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="editModalLabel">Edit Quiz</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <!-- Form for adding new item -->
              <form id="editQuiz" action-url="" method="POST">
                @csrf
                @method('post')
                <input type="hidden" id="editId" name="editId" value="">
                <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" class="form-control" name="title" id="editTitle" placeholder="Enter Quiz Title">
                  <span class="text-danger error" id="errorTexttitle"></span>
                </div>
                <div class="form-group">
                  <label for="name">Status</label>
                  <select name="status" class="form-control" id="status">
                    <option value="">Select Stauts</option>
                    <option value="1">Enable</option>
                    <option value="0">Disable</option>
                  </select>
                  <span class="text-danger error" id="errorTextstatus"></span>
                </div>
                <button type="submit" id="btn-editQuiz" class="btn btn-primary">Update Quiz</button>
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

$(document).ready(function() {
    $(document).on('submit','#saveNewQuize', function(e) {
        e.preventDefault();
        $('#errorText').text('');
        var formData = $('#saveNewQuize').serialize();
        console.log(formData);
        var url = $('#saveNewQuize').attr('action-url');
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#quizListTable').html(response.quize_list);
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
                        $('#errorMessage').append('<p>'+ value +'</p>');
                    });

                    $('#errorToast').toast('show');
                }
            });
    });
    $(function(){
        $('#saveNewQuize').validate(
            {
            rules:{
                title: {
                    required: true,
                    maxlength:75,
                },
            }
        });
    });

    $(function(){
        $('#editQuiz').validate(
            {
            rules:{
                title: {
                    required: true,
                    maxlength:75,
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
        $('#editTitle').val($(this).data('edit_title'));
        $('#status').val($(this).data('status'));
        $('#editId').val(recordId);
        $('#editModal').modal('show');
    });

    $(document).on('submit','#editQuiz', function(e) {
        e.preventDefault();
        $('#errorTextEdit').text('');
        var formData = $('#editQuiz').serialize();
        var editId = $('#editId').val();
        var url = 'quizzes/'+editId;
        $.ajax({
            url: url,
            type: 'PUT',
            data: formData,
            beforeSend: function(xhr) {
                $('.error').text('');
            },
            success: function(response) {
                $('#quizListTable').html(response.quize_list);
                $('.close').click();
                $('#successMessage').text(response.message);
                $('#ajaxToast').toast('show');
            },
            error: function(xhr, status, error) {
                // Handle errors here
                var errors = xhr.responseJSON.errors;
                $.each(errors, function(key, value) {
                    $('#errorText'+key).text(value);
                    $('#errorMessage').html('');
                    $('#errorMessage').append('<p>'+ value +'</p>');
                });

                $('#errorToast').toast('show');
            }

        });
    });


    // Delete Quiz

    $(document).on('click', '.btnDelete', function() {
        var recordId = $(this).data('id');
        var confirmation = confirm('Are you sure you want to delete this Quiz?');
        if(confirmation){
            $.ajax({
                url: 'quizzes/' + recordId,
                type: 'DELETE',
                success: function(response) {
                    $('#successMessage').text(response.message);
                    $('#quizListTable').html(response.quize_list);
                    $('#ajaxToast').toast('show');
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    var error = xhr.responseJSON.error;
                        $('#errorMessage').html('');
                        $('#errorMessage').append('<p>'+ error +'</p>');
                        $('#errorToast').toast('show');
                }
            });
        }
    });

    $(document).on('click', '.close', function(){
        $('.modal').modal('hide');
    })
});
</script>
