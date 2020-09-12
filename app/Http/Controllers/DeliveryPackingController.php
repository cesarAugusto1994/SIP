<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeliveryOrder\Packing;
use App\Models\DeliveryOrder\Packing\Item as PackingItem;
use App\Models\DeliveryOrder;
use App\Helpers\{Helper, Constants};
use App\Models\{Client, People};
use App\Models\Department\Occupation;
use App\Models\DeliveryOrder\Log as DeliveryOrderLog;
use PDF;

class DeliveryPackingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packings = Packing::orderByDesc('id');
        $quantity = $packings->count();
        $packings = $packings->paginate();

        return view('packing.index', compact('packings', 'quantity'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $deliveries = DeliveryOrder::where('status_id', 1)->orderByDesc('id')->take(10)->get();

        $result = [];
        $lat = -20.3101037;
        $lng = -40.320972999999995;

        $occupation = Occupation::where('name', 'Entregador')->get();

        $occupation = $occupation->first();

        $people = People::where('active', true)->orderBy('name')->get();

        $delivers = $people->filter(function ($person, $key) use ($occupation) {
            return $person->occupation_id == $occupation->id;
        });

        $anotherPeople = $people->filter(function ($person, $key) use ($occupation) {
            return $person->occupation_id != $occupation->id;
        });

        $quantity = 0;

        foreach ($deliveries as $key => $delivery) {

            $hasAnotherPacking = $delivery->packings->map(function($pack) {
                return $pack->packing->where('status', '!=', 'Finalizado')->first();
            })->first();

            if($hasAnotherPacking) {
                continue;
            }

            $distance = Helper::calculateDistances($lat, $lng, $delivery->address->lat, $delivery->address->long, 'K');

            $distance = number_format($distance, 2, '.','');

            $result[$distance][] = [
              'id' => str_pad($delivery->id, 6, "0", STR_PAD_LEFT),
              'uuid' => $delivery->uuid,
              'client_uuid' => $delivery->client->uuid,
              'client' => $delivery->client->name,
              'distance' => $distance,
              'status' => $delivery->status->name,
              'color' => Helper::deliveryStatusColor($delivery->status->id),
              'address_id' => $delivery->address->id,
              'address' => $delivery->address->street . ', ' . $delivery->address->number . ', ' . $delivery->address->district . ' - ' . $delivery->address->city,
              'date' => in_array($delivery->status_id, [1,2,3]) ? $delivery->delivery_date->format('d/m/Y') : $delivery->delivered_at->format('d/m/Y'),
            ];
            $quantity++;

        }

        ksort($result);

        return view('packing.create', compact('result', 'delivers', 'anotherPeople', 'quantity'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->request->all();
        $user = $request->user();

        $deliveryDate = $data['delivery_date'] ? \DateTime::createFromFormat('d/m/Y', $data['delivery_date']) : null;
        $deliver = People::uuid($data['delivered_by']);

        $packing = Packing::create([
          'delivery_date' => $deliveryDate,
          'delivered_by' => $deliver->id,
          'user_id' => $user->id
        ]);

        foreach ($data['deliveries'] as $key => $delivery) {

            $delivery = DeliveryOrder::uuid($delivery);

            PackingItem::create([
              'packing_id' => $packing->id,
              'delivery_id' => $delivery->id
            ]);

            DeliveryOrderLog::create([
              'delivery_order_id' => $delivery->id,
              'status_id' => Constants::STATUS_DELIVERY_REMESSA_ENTREGA,
              'user_id' => $user->id,
              'message' => 'Ordem de Entrega adicionada a Remessa de n° ' . str_pad($packing->id, 6, "0", STR_PAD_LEFT)
            ]);
        }

        notify()->flash('Sucesso!', 'success', [
          'text' => 'Nova Remessa de Entrega Gerada com sucesso.'
        ]);

        return redirect()->route('delivery-packings.show', $packing->uuid);
    }

    public function confirm($id, Request $request)
    {
        try {

          $data = $request->request->all();
          $user = $request->user();

          $packing = Packing::uuid($id);

          if($request->filled('deliveries')) {

            foreach ($data['deliveries'] as $key => $item) {

                $packingItem = PackingItem::uuid($item);

                $delivery = $packingItem->delivery;

                $delivery->status_id = Constants::STATUS_DELIVERY_ENTREGUE;
                $delivery->save();

                DeliveryOrderLog::create([
                  'delivery_order_id' => $delivery->id,
                  'status_id' => Constants::STATUS_DELIVERY_ENTREGUE,
                  'user_id' => $user->id,
                  'message' => 'Ordem de Entrega alterada para a Situação Entregue pela Remessa de n° ' . str_pad($packing->id, 6, "0", STR_PAD_LEFT)
                ]);

                $packingItem->delivered = true;
                $packingItem->save();


            }

          }

          $packing->status = 'Finalizado';
          $packing->save();

          return response()->json([
            'success' => true,
            'message' => 'Remessa de Entrega Confirmada com Sucesso.',
            'route' => route('delivery-packings.show', $packing->uuid)
          ]);

        } catch(\Exception $e) {

          return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
            'route' => null
          ]);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $packing = Packing::uuid($id);
        return view('packing.show', compact('packing'));
    }

    public function print($id)
    {
        $packing = Packing::uuid($id);
        //return view('packing.print', compact('packing'));

        $id = str_pad($packing->id, 6, "0", STR_PAD_LEFT);
        $title = "Remessa de Entrega:$id:";

        $pdf = PDF::loadView('packing.print', compact('packing'));

        $stylePdf = $pdf->getDomPDF();
        $canvas = $stylePdf ->get_canvas();
        $canvas->page_text(520, 2, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(255, 255, 255));

        return $pdf->stream($title. ".pdf");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

          $packing = PackingItem::uuid($id);

          $packing->delete();

          return response()->json([
            'success' => true,
            'message' => 'Item removido da Remessa de Entrega com sucesso.'
          ]);

        } catch(\Exception $e) {
          return response()->json([
            'success' => false,
            'message' => 'Ocorreu um erro inesperado.'
          ]);
        }
    }
}
