<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\Questions;
use App\Models\Quiz;
use Crypt;

class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quizes = Quiz::where('status',1)->get();
        $questions = Questions::with(['quiz','answers'])->orderby('created_at','DESC')->paginate(10);
        return view('Questions.list', compact('questions','quizes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function list()
    {
        //
        $data = Questions::all();

        return response()->json($data);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validateQuiz = $request->validate(array(
            'quiz_id' => 'required',
            'question'=>'required|min:5',
            'time_limit'=> 'required|digits_between:1,600',
        ));

        if(Questions::create($validateQuiz)){
            $questions = Questions::with(['quiz','answers'])->orderby('created_at','DESC')->paginate(10);
            $questions_list = view::make('Questions.questions-list', ['questions'=>$questions])->render();
            return response()->json(['message' => 'Question saved successfully','questions_list'=>$questions_list]);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $question_id = Crypt::decrypt($id);
        $questions = Questions::with(['answers'])->findOrFail($question_id);
        $qa = view::make('Questions.questions-answers', ['qas'=>$questions])->render();
        return response()->json(['qa'=>$qa]);
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

        $validateQuiz = $request->validate(array(
            'quiz_id' => 'required',
            'question'=>'required|min:5',
            'status' => 'required',
            'time_limit'=> 'required|digits_between:1,600',
        ));
        $quiz_id = Crypt::decrypt($id);
        $question = Questions::findOrFail($quiz_id);
        $question->quiz_id = $request->input('quiz_id');
        $question->question = $request->input('question');
        $question->status = $request->input('status');
        $question->time_limit = $request->input('time_limit');
        $questionUpdated = $question->save();
        if($questionUpdated){
            $questions = Questions::with(['quiz','answers'])->orderby('created_at','DESC')->paginate(10);
            $questions_list = view::make('Questions.questions-list', ['questions'=>$questions])->render();
            return response()->json(['message' => 'Question updated successfully','questions_list'=>$questions_list]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        try {
            $quiz_id = Crypt::decrypt($id);
            $record = Questions::findOrFail($quiz_id);
            $record->delete();
            $questions = Questions::with('quiz')->orderby('created_at','DESC')->paginate(10);
            $questions_list = view::make('Questions.questions-list', ['questions'=>$questions])->render();
            return response()->json(['message' => 'Question deleted successfully','questions_list'=>$questions_list]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Record not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete record'], 500);
        }
    }

}
