<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Notifications\OrderCreatedNotification;
use App\Repositories\ClientRepository;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function __construct(public OrderRepository $orderRepository, public ClientRepository $clientRepository)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderRequest $request)
    {
        $data = $request->validated();

        $client = $this->clientRepository->create($data);

        if($client){
            $order = $this->orderRepository->create($data, $client);
        }

        if($client && $order){


            $client->notify(new OrderCreatedNotification($order));


            return response()->json(['message'=>'Success']);
        }

        return response()->json(['message'=>'Error'], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
