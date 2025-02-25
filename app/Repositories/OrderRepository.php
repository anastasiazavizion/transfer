<?php

namespace App\Repositories;

use App\Models\Client;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;

class OrderRepository
{
    public function create(array $data, Client $client): Order|false
    {
        try {
            DB::beginTransaction();

            $order = Order::create([
                'address_from'=>$data['data']['address_from'],
                'address_to'=>$data['data']['address_to'],
                'adults'=>$data['data']['adults'],
                'children'=>$data['data']['children'],
                'suitcases'=>$data['data']['suitcases'],
                'travel_time'=>$data['duration'],
                'total_price'=>$data['total'],
                'meeting_date'=>$data['data']['meeting_date'],
                'meeting_time'=>$data['data']['meeting_time'],
                'comment'=>$data['comment'],
                'add_road_back'=>$data['data']['addRoadBack'],
                'client_id'=>$client->id
            ]);

            OrderDetail::create([
                'order_id' => $order->id,
                'km_to_location_1' => $data['km_to_location_1'],
                'km_to_location_2' => $data['km_to_location_2'],
                'km_back' => $data['km_to_location_3'],
                'price_per_km_when_empty' => config('map.price_per_1_km_to_location1'),
                'price_per_km_with_client' => config('map.price_per_1_km_to_location2'),
            ]);

            DB::commit();
            return $order;

        } catch (\Throwable $exception) {
            DB::rollBack();
            logs()->error($exception->getMessage());
            return false;
        }
    }


}
