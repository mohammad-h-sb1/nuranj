<?php

namespace App\Http\Controllers\V1\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\PageResource;

use App\Models\Image;
use App\Models\Page;
use Carbon\Carbon;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page=Page::all();
        return response()->json([
            'status'=>'ok',
            'data'=>PageResource::collection($page)
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
    public function store(Request $request , )
    {
        $this->validate($request ,[
            'name' => 'required|string|unique:pages',
            'slug' => '|string|email|max:255|unique:pages',
        ]);

        $data=[
            'user_id'=>auth()->user()->id,
            'name'=>$request->name,
            'slug'=>$request->name,
            'description'=>$request->description
        ];

        $page=Page::create($data);
        return response()->json([
            'status'=>'ok',
            'data'=>new PageResource($page)
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        return response()->json([
            'status'=>'ok',
            'data'=>new PageResource($page)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        return response()->json([
            'status'=>'ok',
            'data'=>new PageResource($page)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        $data=[
            'user_id'=>auth()->user()->id,
            'name'=>$request->name,
            'slug'=>$request->name,
            'description'=>$request->description
        ];

        $page->update($data);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        $page->delete();
    }
}
