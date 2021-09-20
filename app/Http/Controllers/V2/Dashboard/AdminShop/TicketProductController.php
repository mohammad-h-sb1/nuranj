<?php

namespace App\Http\Controllers\V2\Dashboard\AdminShop;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\AdminShop\TicketProductResource;
use App\Models\Ticket;
use App\Models\V2\Product;
use App\Models\V2\Shop;
use App\Models\V2\TicketProduct;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shop=Shop::query()->where('user_id',auth()->user()->id)->pluck('id')->first();
        $ticket=TicketProduct::query()->where('shop_id',$shop)->paginate(\request('limit'));
        return response()->json([
            'status'=>'ok',
            'data'=>TicketProductResource::collection($ticket)
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
        $validData=$this->validate($request,[
            'name'=>['required','string']
        ]);
        $shop=Shop::query()->where('user_id',auth()->user()->id)->pluck('id')->first();
        $ticket=TicketProduct::create([
            'shop_id'=>$shop ,
            'name'=>$validData['name']
        ]);
        return  response()->json([
            'status'=>'ok',
            'data'=>new TicketProductResource($ticket)
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TicketProduct  $ticketProduct
     * @return \Illuminate\Http\Response
     */
    public function show(TicketProduct $ticketProduct)
    {
        if ($ticketProduct->shop->user_id == auth()->user()->id){
            return response()->json([
                'status'=>'ok',
                'data'=>new TicketProductResource($ticketProduct)
            ]);
        }
        else{
            return response()->json([
                'status'=>'ok',
                'massage'=>'شماد دسترسی ندارید'
            ],403);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TicketProduct  $ticketProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(TicketProduct $ticketProduct)
    {
        if ($ticketProduct->shop->user_id == auth()->user()->id){
            return response()->json([
                'status'=>'ok',
                'data'=>new TicketProductResource($ticketProduct)
            ]);
        }
        else{
            return response()->json([
                'status'=>'ok',
                'massage'=>'شماد دسترسی ندارید'
            ],403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TicketProduct  $ticketProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TicketProduct $ticketProduct)
    {
        $validData=$this->validate($request,[
            'name'=>['required','string']
        ]);
        if ($ticketProduct->shop->user_id == auth()->user()->id){
            $ticketProduct->update($validData);
        }
        else{
            return response()->json([
                'status'=>'ok',
                'massage'=>'شماد دسترسی ندارید'
            ],403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TicketProduct  $ticketProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(TicketProduct $ticketProduct)
    {
        if ($ticketProduct->shop->user_id == auth()->user()->id){
            $ticketProduct->delete();
        }
        else{
            return response()->json([
                'status'=>'ok',
                'massage'=>'شماد دسترسی ندارید'
            ],403);
        }

    }
}
