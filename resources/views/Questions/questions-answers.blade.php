<input type="hidden" id="question_id" name="question_id" value="{{ $qas->id }}">

<h3>{{ $qas->question }}</h3>
<hr>
@foreach ($qas->answers as $key => $question)
<div class="row">
    <div class="col-md-10">
<input type="text" name="{{ $question->status == 1 ? 'correct_answer_'.$question->id : 'answer_'.$question->id }}" value="{{ $question->answer }}" class="{{ $question->status == 1 ? 'bg-success' : 'bg-danger' }} form-control"></td>
    </div><div class="col-md-2">
<button type="button" class="btn btn-outline-danger btnDeleteAnswer" data-id="{{ \Crypt::encrypt($question->id) }}">Delete</button>
</div>
</div>
@endforeach
<div class="mt-2"></div>
