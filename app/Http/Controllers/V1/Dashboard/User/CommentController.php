<?php

namespace App\Http\Controllers\V1\Dashboard\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\CommentResource;
use App\Http\Resources\User\ProjectResource;
use App\Models\Comment;
use App\Models\Project;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        $validData=$this->validate($request,[
            'project_id' => 'required',
            'description' => 'required',
        ]);
        $project=Project::query()->where('id',$request->project_id)->first();
        if ($project->user_id == auth()->user()->id){
            $comment=Comment::create([
                'user_id'=>auth()->user()->id,
                'project_id'=>$validData['project_id'],
                'description'=>$validData['description']
            ]);
            return response()->json([
                'status'=>'ok',
                'data'=>new CommentResource($comment)
            ]);
        }
        else{
            return response()->json([
                'status'=>'Error',
                'massager'=>'شمادست رسی ندارید'
            ],403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        return response()->json([
            'status'=>'ok',
            'data'=>new CommentResource($comment)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        if ($comment->user_id == auth()->user()->id){
            return response()->json([
                'status'=>'ok',
                'data'=>new CommentResource($comment)
            ]);
        }
        else{
            return response()->json([
                'status'=>'Error',
                'massager'=>'شمادست رسی ندارید'
            ],403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {

        if (auth()->user()->id == $comment->user_id){
            $validData=$this->validate($request,[
                'description' => 'required',
            ]);
            $comment->update([
                'description'=>$validData['description']
            ]);

        }
        else{
            return response()->json([
                'status'=>'Error',
                'massager'=>'شمادست رسی ندارید'
            ],403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        if (auth()->user()->id == $comment->user_id){
            $comment->delete();
        }
        else{
                return response()->json([
                    'status'=>'Error',
                    'massager'=>'شمادست رسی ندارید'
                ],403);
            }
    }
}
