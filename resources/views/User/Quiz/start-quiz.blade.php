@extends('layouts.app')

@section('content')
    <div class="container">
        {{--  {{ dd(Session::get('quiz_start')) }}
        {{ dd(collect(Session::get('quiz_start'))->contains($quiz->id)) }}  --}}
        @if (Session::has('quiz_start') && collect(Session::get('quiz_start'))->contains($quiz->id))
            <h1>You have already attented this Quiz!</h1>
        @else
            <input type="hidden" name="quize_id" id="quize_id" value="{{ $quiz->id }}">
            @csrf
            <div class="mt-5">
                <h3>Quiz : {{ $quiz->title }}</h3>
            </div>

            <div id="timer"></div>
            <div id="question"></div>
            <br>
            <div id="answers"></div>
            <br>
            <button type="button" class="btn btn-dark" onclick="nextClickBtn()" id="nextButton">Next</button>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
                const questions = JSON.parse('{!! $json_questions !!}');
                var selectedAnswers = [];



                let currentQuestionIndex = 0;
                let timeLeft = questions[currentQuestionIndex].time_limit;

                function displayQuestion() {
                    const question = questions[currentQuestionIndex];
                    document.getElementById('question').textContent = question.question;
                    document.getElementById('answers').textContent = question.question.answers;
                }

                function displayAnswers() {
                    const answers = questions[currentQuestionIndex].answers;
                    console.log(answers);
                    var container = document.getElementById('answers');
                    $.each(answers, function(key, value) {
                        if (answers.hasOwnProperty(key)) {

                            console.log(value.answer);

                            // Create a label for the input element
                            var label = document.createElement('label');
                            label.innerHTML = value.answer;

                            // Create an input element
                            var input = document.createElement('input');

                            input.type = 'radio';
                            // Set input name and value
                            input.name = 'answer';
                            input.value = value.id;



                            // Append input and label to the container
                            container.appendChild(input);
                            container.appendChild(label);

                            // Add a line break for better formatting
                            container.appendChild(document.createElement('br'));
                        }
                    });
                }

                function startTimer() {
                    const timerDisplay = document.getElementById('timer');
                    timerDisplay.textContent = `Time left: ${timeLeft} seconds`;

                    const timerInterval = setInterval(() => {
                        timeLeft--;
                        timerDisplay.textContent = `Time left: ${timeLeft} seconds`;

                        if (timeLeft <= 0) {
                            clearInterval(timerInterval);
                            nextQuestion();
                        }
                    }, 1000);
                }

                function nextQuestion() {
                    currentQuestionIndex++;
                    if (currentQuestionIndex < questions.length) {
                        timeLeft = questions[currentQuestionIndex].time_limit;
                        displayQuestion();
                        displayAnswers()
                    } else {
                        console.log(selectedAnswers);
                        alert('Quiz ended!');
                        var quize_id = $('#quize_id').val();
                        $.ajax({
                            url: '{{ route('quizes.store') }}',
                            type: 'post',
                            data: {
                                quize_id: quize_id,
                                selectedAnswers: selectedAnswers
                            },
                            success: function(response) {
                                $('#successMessage').text(response.message);
                                $('#quizListTable').html(response.quize_list);
                                $('#ajaxToast').toast('show');

                                // Redirect after 3 seconds
                                setTimeout(function() {
                                    window.location.href =
                                        '{{ route('result.index') }}'; // Replace with your redirect page URL
                                }, 1500);
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
                }

                function nextClickBtn() {
                    if ($("input[type='radio']").is(':checked')) {
                        selectedAnswers.push($("input[type='radio']:checked").val());
                    }
                    nextQuestion();
                }

                displayQuestion();
                displayAnswers();
                startTimer();

                $(document).on('load', function() {
                    {{ \Session::push('quiz_start', $quiz->id) }}
                });
            </script>
        @endif
    </div>
@endsection
