<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Questions;
use App\Models\UserResult;
use App\Models\Answers;
use Crypt;
use Auth;

class UserResultController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $results = UserResult::with('quiz.questions')->where('user_id',Auth::user()->id)->orderBy('created_at','DESC')->get();
        return view('User.Result.result', compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // dd($request->all());
        $correctAns = Answers::whereIn('id',$request->selectedAnswers)->where('status',1)->count();
        $obj = [
            'quiz_id'=> $request->quize_id,
            'user_id'=> Auth::user()->id,
            'email'=> Auth::user()->email,
            'answers'=> json_encode($request->selectedAnswers),
            'total_correct_answers'=>$correctAns
        ];
        UserResult::create($obj);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $quiz_id = Crypt::decrypt($id);
        $quiz = Quiz::findOrFail($quiz_id);
        $questions = Questions::where('quiz_id',$quiz->id)->where('status',1)->with('answers')->get();
        $json_questions = $questions;

        return view('User.Quiz.start-quiz', compact('quiz','questions','json_questions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
