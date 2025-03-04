<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateOrderRequest;
use App\Http\Resources\Admin\OrderResource;
use App\Http\Resources\V1\Categories\CategoryResource;
use App\Models\Order;
use App\Repositories\ClientRepository;
use App\Repositories\OrderRepository;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct(public ClientRepository $clientRepository, public OrderRepository $orderRepository)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return OrderResource::collection(Order::latest()->get());
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return new OrderResource($order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        $data = $request->validated();

        $client = $this->clientRepository->update($data['client_id'], $data);

        if($client){
            $orderUpdated = $this->orderRepository->update($data, $order);
        }

        if($client && $orderUpdated){
         //   $client->notify(new OrderCreatedNotification($order));
            return new OrderResource($orderUpdated);
        }
        return response()->json(['message'=>'Error'], 500);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        try {
            DB::beginTransaction();
            $id = $order->id;
            $order->delete();
            DB::commit();
            return response()->json(['message' => "Order #$id was removed", 'data'=>new OrderResource($order)], 200);
        }catch (\Exception $exception){
            DB::rollBack();
            logs()->error($exception->getMessage());
            return response()->json(['message' => $exception->getMessage(), 'data'=>[]], $exception->getCode());
        }
    }
}
