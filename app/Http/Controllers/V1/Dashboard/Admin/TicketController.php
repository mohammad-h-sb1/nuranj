<?php

namespace App\Http\Controllers\V1\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\TicketResource;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets=Ticket::query()->orderBy('created_at','DESC')->get();
        $count=count($tickets);

        $active=$tickets->where('status',1);
        $inactive=$tickets->where('status',0);
        $countActive=count($active);
        $countInactive=count($inactive);

        return response()->json([
            'status'=>'ok',
            'data'=>[
                'tickets'=>TicketResource::collection($tickets),
                'count'=>$count,
                'countActive'=>$countActive,
                'countInactive'=>$countInactive
            ]
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ticket=Ticket::query()->where('id',$id)->first();
        return response()->json([
            'status'=>'ok',
            'data'=>new TicketResource($ticket)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Ticket::query()->where('id',$id)->delete();
    }

    public function hasBeenAnswered()
    {
        $ticket=Ticket::query()->where('status',1)->orderBy('created_at','DESC')->get();
        $count=count($ticket);
        return response()->json([
            'status'=>'ok',
            'data'=>[
                'ticket'=>TicketResource::collection($ticket),
                'count'=>$count
            ]
        ]);
    }

    public function NotAnswered()
    {
        $ticket=Ticket::query()->where('status',0)->orderBy('created_at','DESC')->get();
        $count=count($ticket);
        return response()->json([
            'status'=>'ok',
            'data'=>[
                'ticket'=>TicketResource::collection($ticket),
                'count'=>$count
            ]
        ]);
    }

    public function frontAnswered()
    {
        $ticket=Ticket::query()->where('category','front')->orderBy('created_at','DESC')->get();
        $count=count($ticket);
        return response()->json([
            'status'=>'ok',
            'data'=>[
                'ticket'=>TicketResource::collection($ticket),
                'count'=>$count
            ]
        ]);
    }
    public function backendAnswered()
    {
        $ticket=Ticket::query()->where('category','backend')->orderBy('created_at','DESC')->get();
        $count=count($ticket);
        return response()->json([
            'status'=>'ok',
            'data'=>[
                'ticket'=>TicketResource::collection($ticket),
                'count'=>$count
            ]
        ]);
    }


}
