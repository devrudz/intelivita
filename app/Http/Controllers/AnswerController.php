<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\Questions;
use App\Models\Quiz;
use App\Models\Answers;
use Crypt;

class AnswerController extends Controller
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
        $questions = Questions::with('quiz')->orderby('created_at','DESC')->paginate(10);
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
        $question_id = $request->question_id;
        Answers::where('question_id', $question_id)->delete();
        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'answer_') === 0 && !empty($value)) {
                Answers::updateOrCreate(
                    [
                        'question_id'=> $question_id,
                        'answer'=>  $value,
                        'status'=>0,
                    ]
                );
            }
        }

        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'correct_answer_') === 0 && !empty($value)) {
                Answers::updateOrCreate(
                    [
                        'question_id'=> $question_id,
                        'answer'=>  $value,
                        'status'=>1,
                    ]
                );
            }
        }

        $questions = Questions::with('quiz')->orderby('created_at','DESC')->paginate(10);
        $questions_list = view::make('Questions.questions-list', ['questions'=>$questions])->render();
        return response()->json(['message' => 'Question saved successfully','questions_list'=>$questions_list]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        try {
            $ans_id = Crypt::decrypt($id);
            $record = Answers::findOrFail($ans_id);
            $record->delete();

            $questions = Questions::with(['answers'])->findOrFail($record->question_id);
            $qa = view::make('Questions.questions-answers', ['qas'=>$questions])->render();

            return response()->json(['message' => 'Answer deleted successfully','qa'=>$qa]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Record not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete record'], 500);
        }
    }

}
