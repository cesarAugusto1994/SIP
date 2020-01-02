<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{DeliveryOrder, Client};

class DeliveryController extends Controller
{
    public function index(Request $request)
    {
        $deliveries = DeliveryOrder::orderByDesc('id');

        if($request->has('q')) {
            $search = $request->get('q');
            $clients = Client::where('name', 'LIKE', "%$search%")->pluck('id');
            $deliveries->where('id', 'LIKE', "%$search%")->orWhereIn('client_id', $clients);
        }

        $deliveries = $deliveries->where('status_id', 5)->paginate(12);

        $result = [];

        foreach($deliveries as $delivery) {

            if(!$delivery->address->lat || !$delivery->address->long) {
                continue;
            }

            $result[] = [
                'id' => $delivery->uuid,
                'code' => str_pad($delivery->id, 6, "0", STR_PAD_LEFT),
                'status_id' => $delivery->status->id,
                'status' => $delivery->status->name,
                'client' => $delivery->client->name,
                'address' => $delivery->address->description . ' - ' . $delivery->address->street . ', ' . $delivery->address->number . ', ' . $delivery->address->district . ' - ' . $delivery->address->city . ' / ' . $delivery->address->state . ' - ' . $delivery->address->zip,
                'latitude' => (float)$delivery->address->lat,
                'longitude' => (float)$delivery->address->long,
            ];
        }

        return response()->json($result);
    }

    public function show($id)
    {
        $delivery = DeliveryOrder::uuid($id);

        if(!$delivery) {
            return response()->json(null);
        }

        return response()->json([
            'id' => $delivery->uuid,
            'code' => str_pad($delivery->id, 6, "0", STR_PAD_LEFT),
            'status' => $delivery->status->name,
            'client' => $delivery->client->name,
            'address' => $delivery->address->description . ' - ' . $delivery->address->street . ', ' . $delivery->address->number . ', ' . $delivery->address->district . ' - ' . $delivery->address->city . ' / ' . $delivery->address->state . ' - ' . $delivery->address->zip,
            'latitude' => $delivery->address->lat,
            'longitude' => $delivery->address->long,
        ]);
    }
}
