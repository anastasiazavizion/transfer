<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\Client;

class ClientRepository
{
    public function create(array $data = []) :Client|false
    {
        try {
            DB::beginTransaction();

            $client = Client::updateOrCreate(
                ['email' => $data['email']],
                ['phone' => $data['phone'], 'first_name' => $data['name'], 'last_name' => $data['surname'], 'preferred_messenger_id' => $data['preferred_messenger_id']]
            );

            DB::commit();
            return $client;

        } catch (\Throwable $exception) {
            DB::rollBack();
            logs()->error($exception->getMessage());
            return false;
        }
    }

    public function update(int $id, array $data = []) :Client|false
    {
        try {
            DB::beginTransaction();

            $client = Client::findOrFail($id);
            $client->update($data);

            DB::commit();
            return $client;

        } catch (\Throwable $exception) {
            DB::rollBack();
            logs()->error($exception->getMessage());
            return false;
        }
    }

}
