<?php

namespace App\Http\Controllers;

use App\Http\Requests\Questions\UpdateQuestionRequest;
use App\Http\Requests\Questions\CreateQuestionRequest as CreateQuestionRequestAlias;

use App\Question;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'])->except(['index','show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::with('owner')->latest()->paginate(10);
        return view('questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateQuestionRequestAlias $request)
    {
        auth()->user()->questions()->create([
            'title' => $request->title,
            'body' => $request->body,
        ]);
        session()->flash('success', 'Question has been added successfully');
        return redirect(route('questions.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Question $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        return view('questions.edit', compact('question'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateQuestionRequest $request
     * @param Question $question
     * @return void
     */
    public function update(UpdateQuestionRequest $request, Question $question)
    {
        $question->update([
            "title" => $request->title,
            "body" => $request->body,
        ]);
        session()->flash('success', 'Question has been modified successfully');
        redirect(route('questions.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Question $question
     * @return void
     * @throws \Exception
     */
    public function destroy(Question $question)
    {
        $question->delete();
        session()->flash('success', 'Question has been deleted successfully');
        return redirect(route('questions.index'));

    }
}
