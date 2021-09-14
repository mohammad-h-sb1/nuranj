<?php

namespace App\Http\Controllers\V2\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\Admin\RoleResource;
use App\Http\Resources\V2\Admin\RoleShowResource;
use App\Models\V2\Permission;
use App\Models\V2\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role=Role::query()->paginate(\request('limit'));
        return response()->json([
            'status'=>'ok',
            'data'=>RoleResource::collection($role)
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
            'name' => 'required|unique:permissions|max:255',
            'label' => 'string|unique:permissions|max:255',
            'permissions'=>['required','array'],
        ]);
        $role=Role::create([
            'name'=>$validData['name'],
            'label'=>$validData['label']
        ]);
        $role->permissions()->sync($validData['permissions']);;
        return response()->json([
            'status'=>'ok',
            'data'=>new RoleResource($role)
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
        $role=Role::query()->where('id',$id)->first();
        return response()->json([
            'status'=>'ok',
            'date'=>new RoleShowResource($role)
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
        $role=Role::query()->where('id',$id)->first();
        return response()->json([
            'status'=>'ok',
            'date'=>new RoleShowResource($role)
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
        $role=Role::query()->where('id',$id)->first();
        $validData=$this->validate($request,[
            'name' => ['required','max:255',Rule::unique('permissions')->ignore($role->id)],
            'label' => 'string|max:255',
            'permissions'=>['required','array'],

        ]);
        $role->update([
            'name'=>$validData['name'],
            'label'=>$validData['label']
        ]);
        $role->permissions()->sync($validData['permissions']);
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
