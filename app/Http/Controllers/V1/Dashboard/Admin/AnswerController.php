<?php

namespace App\Http\Controllers\V1\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AnswersResource;
use App\Models\Answer;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $answer=Answer::all();
        return response()->json([
            'status'=>'ok',
            'data'=>AnswersResource::collection($answer)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        $validData=$this->validate($request,[
            'answer' => 'required',
        ]);
        $ticket=Ticket::query()->where('id',$id)->first();

        $data=[
            'user_id'=>auth()->user()->id,
            'ticket_id'=>$ticket->id,
            'answer'=>$validData['answer']
        ];
        $answer=Answer::create($data);
        $ticket->update([
            'status'=>1
        ]);
        return response()->json([
           'status'=>'ok',
           'data'=>new AnswersResource($answer)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function show(Answer $answer)
    {
        return response()->json([
            'status'=>'ok',
            'data'=>new AnswersResource($answer)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function edit(Answer $answer)
    {
        return response()->json([
            'status'=>'ok',
            'data'=>new AnswersResource($answer)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Answer $answer)
    {
        $data=[
            'user_id'=>auth()->user()->id,
            'answer'=>$request->answer,
        ];
        $answer->update($data);
        dd($answer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Answer $answer)
    {
        $answer->delete();
    }
}
