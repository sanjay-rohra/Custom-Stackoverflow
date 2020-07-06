<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Http\Requests\Answers\CreateAnswerRequest;
use App\Question;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AnswersController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Question $question
     * @param CreateAnswerRequest $request
     * @return Response
     */
    public function store(Question $question, CreateAnswerRequest $request)
    {
        //  dd($question);
        $question->answers()->create([
            'body' => $request->body,
            'user_id' => auth()->id(),
        ]);

        session()->flash('success', 'Answer has been added successfully');
        return redirect($question->url);
    }

    /**
     * Display the specified resource.
     *
     * @param Answer $answer
     * @return Response
     */
    public function show(Answer $answer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Question $question
     * @param Answer $answer
     * @return void
     * @throws AuthorizationException
     */
    public function edit(Question $question, Answer $answer)
    {
        $this->authorize('update', $answer);
        return view('answers.edit', compact(['question', 'answer']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Answer $answer
     * @param Question $question
     * @return void
     * @throws AuthorizationException
     */
    public function update(Request $request, Question $question, Answer $answer)
    {
        $this->authorize('update', $answer);
        $answer->update([
            'body' => $request->body
        ]);
        session()->flash('success', 'Answer has been updated successfully');
        return redirect($question->url);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Answer $answer
     * @param Question $question
     * @return void
     * @throws AuthorizationException
     * @throws \Exception
     */
    public function destroy(Answer $answer, Question $question)
    {
        $this->authorize('delete', $answer);
        $answer->delete();
        session()->flash('success', 'Answer has been deleted successfully');
        return redirect($question->url);
    }

    /**
     * @param Answer $answer
     */
    public function bestAnswer(Answer $answer)
    {
        $answer->question->markBestAnswer($answer);
        return redirect()->back();
    }
}
