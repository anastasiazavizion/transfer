<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Models\Client;

class ClientRepository
{
    public function create(array $data = []) :Client|false
    {
        try {
            DB::beginTransaction();

            $client = Client::updateOrCreate(
                ['email' => $data['email'], 'phone' => $data['phone']],
                ['first_name' => $data['name'], 'last_name' => $data['surname'], 'preferred_messenger_id'=>$data['preferred_messenger_id']]
            );

            DB::commit();
            return $client;

        } catch (\Throwable $exception) {
            DB::rollBack();
            logs()->error($exception->getMessage());
            return false;
        }
    }

}
