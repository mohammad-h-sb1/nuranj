<?php

namespace App\Http\Controllers\V2\Dashboard\AdminShop;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\AdminShop\ProductMetaResource;
use App\Http\Resources\V2\AdminShop\ProductResource;
use App\Models\User;
use App\Models\V2\CategoryShop;
use App\Models\V2\Product;
use App\Models\V2\ProductMeta;
use App\Models\V2\Shop;
use App\Models\V2\ShopCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product=Product::query()->where('user_id',auth()->user()->id)->paginate(\request('limit'));
        return response()->json([
            'status'=>'ok',
            'data'=>ProductResource::collection($product)
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
            'name' => ['required','string','max:50'],
            'type' => ['required',],
            'categories'=>['array','nullable'],
            'tickets'=>['array','nullable'],
            'code' => ['string','max:15','min:11'],
            'Price'=>['string'],
            'existing'=>['string'],
            'limitations'=>['string'],
        ]);
        $shop=Shop::query()->where('user_id',auth()->user()->id)->pluck('id')->first();
        $data=[
            'user_id'=>auth()->user()->id,
            'shop_id'=>$shop,
            'name'=>$validData['name'],
            'type'=>$validData['type'],
            'description'=>$request->description,
            'code'=>$request->code,
            'Price'=>$request->Price,
            'existing'=>$request->existing,
            'limitations'=>$request->limitations
        ];
        $product=Product::create($data);
        $product->Shopcategories()->sync($validData['categories']);
        $product->TicketProducts()->sync($validData['tickets']);
        return response()->json([
            'status'=>'ok',
            'data'=>new ProductResource($product)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        if ($product->uesr_id = auth()->user()->id){
            return response()->json([
                'status'=>'ok',
                'data'=>new ProductResource($product)
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
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        if ($product->uesr_id = auth()->user()->id){
            return response()->json([
                'status'=>'ok',
                'data'=>new ProductResource($product)
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product=Product::query()->where('id',$id)->where('user_id',auth()->user()->id)->first();
        if ($product){
            $validData=$this->validate($request,[
                'name' => ['required','string','max:50'],
                'categories'=>['array'],
            ]);
            $product->update([
                'user_id'=>auth()->user()->id,
                'name'=>$validData['name'],
                'description'=>$request->description,
            ]);
            $product->Shopcategories()->sync($validData['categories']);
        }
        else{
            return response()->json([
                'status'=>'Error',
                'massage'=>'شما دسترسی ندارید'
            ],403);
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product=Product::query()->where('id',$id)->where('user_id',auth()->user()->id)->first();
        if ($product){
            $product->delete();
        }
        else{
            return response()->json([
                'status'=>'Error',
                'massage'=>'شما دسترسی ندارید'
            ],403);
        }
    }

    public function status($id)
    {
        $product=Product::query()->where('id',$id)->where('user_id',auth()->user()->id)->first();
        if ($product){
            $product->update([
                'status'=> ! $product->status
            ]);
            return response()->json([
                'status'=>'ok',
                'data'=>new ProductResource($product)
            ]);
        }
        else{
            return response()->json([
                'status'=>'Error',
                'massage'=>'شما دسترسی ندارید'
            ],403);
        }
    }

    public function getStatus(Request $request)
    {
        $validData=$this->validate($request,[
            'status' => 'nullable|boolean',
            'existing'=>'nullable|boolean',
            'type'=>'nullable',
            'category'=>'nullable'
        ]);
        $product=Product::query()->whereIn('user_id',[auth()->user()->id])
            ->when($request->input('status'),function ($query) use ($request){
                return $query->where('status','=',$request->status);
            })->when($request->input('existing'),function ($query) use ($request){
                return $query->where('existing','>',0);
            })->when($request->input('type'),function ($query) use ($request){
                return $query->where('type','like','%'.$request->input('type'));
            })
            ->paginate(\request('limit'));
        return response()->json([
            'status'=>'ok',
            'data'=>ProductResource::collection($product)
        ]);
    }

    public function getCategory(Request $request)
    {
        $validData=$this->validate($request,[
            'id' => 'required|',
        ]);
        $category=ShopCategory::query()->where('id',$request->input('id'))->first();
        $product=$category->Products->paginate(\request('limit'));
        return response()->json([
            'status'=>'ok',
            'date'=>ProductResource::collection($product)
        ]);

    }

    public function getOrdering(Request $request)
    {
        $validData=$this->validate($request,[
            'orderBy'=>'nullable|string'

        ]);
        $product=Product::query()->whereIn('user_id',[auth()->user()->id])
            ->when($request->input('orderBy') =='by_date',function ($q) use ($request){
               return $q->orderByDesc('created_at',);
            })->when($request->input('orderBy')=='based_on_price',function ($q)use ($request){
                return $q->orderByDesc('Price');
            })->when($request->input('orderBy',)=='based_on_existing',function ($q) use ($request){
                return $q->orderByDesc('existing');
            })->when($request->input('orderBy',)=='unavailable',function ($q) use ($request){
                return $q->where('existing',0);
            })
            ->paginate(\request('limit'));
        return response()->json([
            'status'=>'ok',
            'data'=>ProductResource::collection($product)
        ]);
    }
}
