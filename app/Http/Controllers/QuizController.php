<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\Quiz;
use Crypt;

class QuizController extends Controller
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
        //
        $quizes = Quiz::paginate(10);

        return view('Quiz.list', compact('quizes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function list()
    {
        //
        $data = Quiz::all();

        return response()->json($data);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validateQuiz = $request->validate(array(
            'title' => 'required',
        ));

        if(Quiz::create($validateQuiz)){
            $quizes = Quiz::paginate(10);
            $quize_list = view::make('Quiz.quizes-list', ['quizes'=>$quizes])->render();
            return response()->json(['message' => 'Quiz saved successfully','quize_list'=>$quize_list]);
        }

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
        $validateQuiz = $request->validate(array(
            'title' => 'required',
            'status' => 'required',
        ));
        $quiz_id = Crypt::decrypt($id);
        $quiz = Quiz::findOrFail($quiz_id);
        $quiz->title = $request->input('title');
        $quiz->status = $request->input('status');
        $quizSave = $quiz->save();
        if($quizSave){
            $quizes = Quiz::paginate(10);
            $quize_list = view::make('Quiz.quizes-list', ['quizes'=>$quizes])->render();
            return response()->json(['message' => 'Quiz updated successfully','quize_list'=>$quize_list]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        try {
            $quiz_id = Crypt::decrypt($id);
            $record = Quiz::findOrFail($quiz_id);
            $record->delete();
            $quizes = Quiz::paginate(10);
            $quize_list = view::make('Quiz.quizes-list', ['quizes'=>$quizes])->render();
            return response()->json(['message' => 'Quiz deleted successfully', 'quize_list'=>$quize_list]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Record not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete record'], 500);
        }
    }

}
