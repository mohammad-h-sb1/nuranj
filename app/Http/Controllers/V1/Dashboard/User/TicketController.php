<?php

namespace App\Http\Controllers\V1\Dashboard\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\ImageResource;
use App\Http\Resources\User\TicketResource;
use App\Models\Image;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use PHPUnit\Util\Filesystem;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ticket=Ticket::query()->where('user_id',auth()->user()->id)->get();
        return response()->json([
            'status'=>'ok',
            'data'=>TicketResource::collection($ticket)
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
    public function store(Request $request,Filesystem $filesystem)
    {
        $validData=$this->validate($request,[
            'category' => 'required',
            'description' => 'required',
            'title' => 'required',
            'image' => 'file|mimes:jpeg,bmp,png,mp4,pdf|max:10240'

        ]);

        $data=[
            'user_id'=>auth()->user()->id,
            'title'=>$validData['title'],
            'category'=>$validData['category'],
            'description'=>$validData['description'],
        ];
        $ticket=Ticket::create($data);
        $file=$request->file('image');
        $year=Carbon::now()->year;
        $month=Carbon::now()->month;
        $day=Carbon::now()->day;
        $imagePath="/upload/image/{$year}/{$month}/{$day}";
        $fileName=$file->getClientOriginalName();
//        if ($filesystem->exists(public_path("{$imagePath}/{$fileName}"))){
//            $fileName=Carbon::now()->timespan()."-{$fileName}";
//        }
        $file->move(public_path($imagePath) , $fileName);
        $data=[
            'user_id'=>auth()->user()->id,
            'ticket_id'=>$ticket->id,
            'url'=>url("{$imagePath}/{$fileName}"),
            'status'=>1
        ];
        Image::create($data);
        return response()->json([
            'status'=>'ok',
            'data'=>new TicketResource($ticket)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        if (auth()->user()->id == $ticket->user_id){
            return response()->json([
                'status'=>'ok',
                'data'=>new TicketResource($ticket)
            ]);
        }
        else{
            return response()->json([
                'status'=>'Error',
                'massage'=>'شما دسترسی ندارید'
            ],403);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        if (auth()->user()->id == $ticket->user_id){
            $ticket->delete();
        }
        else{
            return response()->json([
                'status'=>'Error',
                'massage'=>'شما دسترسی ندارید'
            ],403);
        }
    }
}
