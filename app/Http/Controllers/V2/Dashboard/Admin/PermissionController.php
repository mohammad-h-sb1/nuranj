<?php

namespace App\Http\Controllers\V2\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\Admin\PermissionResource;
use App\Http\Resources\V2\Admin\PermissionShowResource;
use App\Models\V2\Permission;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Validation\Rule;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->type == 'admin'){
            $permission=Permission::query()->paginate(\request('limit'));
            return response()->json([
                'status'=>'ok',
                'data'=>PermissionResource::collection($permission)
            ]);
        }
        else{
            return response()->json([
                'status'=>'Error',
                'massager'=>'شما دسترسی ندارید'
            ],403);
        }
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
            'name' => 'required|unique:permissions|max:255',
            'label' => 'string|unique:permissions|max:255',
        ]);
        $permission=Permission::create($validData);
        return response()->json([
            'status'=>'ok',
            'data'=>new PermissionResource($permission)
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $permission=Permission::query()->where('id',$id)->first();
        return response()->json([
            'status'=>'ok',
            'date'=>new PermissionShowResource($permission)
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
        $permission=Permission::query()->where('id',$id)->first();
        return response()->json([
            'status'=>'ok',
            'date'=>new PermissionShowResource($permission)
        ]);
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
        $permission=Permission::query()->where('id',$id)->first();
        $validData=$this->validate($request,[
            'name' => ['required','max:255',Rule::unique('permissions')->ignore($permission->id)],
            'label' => 'string|max:255',
        ]);
        $permission->update([
            'name'=>$validData['name'],
            'label'=>$validData['label']
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission=Permission::query()->where('id',$id)->first();
        $permission->delete();
    }
}
