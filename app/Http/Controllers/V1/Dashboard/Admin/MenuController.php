<?php

namespace App\Http\Controllers\V1\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\MenuResource;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menu=Menu::all();
        return response()->json([
            'status'=>'ok',
            'data'=>MenuResource::collection($menu)
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
            'name' => 'required|string|max:255',
            'type'=>'required'
        ]);
        $menu=Menu::create([
            'name'=>$validData['name'],
            'type'=>$validData['type'],
            'parent_id'=>$request->parent_id,
        ]);
        return response()->json([
            'status'=>'ok',
            'data'=>new MenuResource($menu)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        return response()->json([
            'status'=>'ok',
            'data'=>new MenuResource($menu)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        return response()->json([
            'status'=>'ok',
            'data'=>new MenuResource($menu)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        $validData=$this->validate($request,[
            'name' => 'required|string|max:255',
            'type'=>'required'
        ]);
        $menu->update([
            'name'=>$validData['name'],
            'type'=>$validData['type'],
            'parent_id'=>$request->parent_id
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();
    }
}
