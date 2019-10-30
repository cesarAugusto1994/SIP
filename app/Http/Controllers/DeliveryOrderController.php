<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeliveryOrder;
use App\Models\DeliveryOrder\Log;
use App\Models\{Client, People};
use App\Models\Delivery\Document;
use App\Models\Client\{Address, Employee};
use App\Models\Department\Occupation;
use App\Models\DeliveryOrder\Documents as DeliveryOrderDocuments;
use App\Helpers\Constants;
use App\Notifications\DeliveryOrder as DeliveryOrderNotification;
use App\Mail\DeliveryOrder as DeliveryOrderMail;
use App\Jobs\DeliveryOrder as DeliveryOrderJob;
use Illuminate\Support\Facades\Validator;
use Khill\Lavacharts\Lavacharts;
use Storage;
use Notification;
use Auth;
use PDF;
use Mail;
use App\User;
use DateTime;
use DateInterval;
use DatePeriod;

class DeliveryOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!Auth::user()->hasPermission('view.ordem.entrega')) {
            return abort(403, 'Unauthorized action.');
        }

        $orders = DeliveryOrder::orderByDesc('id');

        $delay = DeliveryOrder::whereIn('status_id',
                    [Constants::STATUS_DELIVERY_PENDENTE, Constants::STATUS_DELIVERY_EM_TRANSITO])
                    ->where('delivery_date', '<', now()->setTime(00,00,00))->count();

        if(!$request->has('find')) {
            $orders->whereIn('status_id', [1]);
        }

        if($request->has('delay')) {
            $orders->whereIn('status_id',
                        [Constants::STATUS_DELIVERY_PENDENTE, Constants::STATUS_DELIVERY_EM_TRANSITO])
                        ->where('delivery_date', '<', now()->setTime(00,00,00));
        }

        if($request->filled('code')) {
            $orders->where('id', $request->get('code'));

            if($orders->count() == 1) {
                $delivery = $orders->first();
                return redirect()->route('delivery-order.show', $delivery->uuid);
            }

        } else {

          if($request->filled('client')) {
              $client = Client::uuid($request->get('client'));
              $orders->where('client_id', $client->id);
          }

          if($request->filled('employee')) {

              $employee = Employee::uuid($request->get('employee'));

              $orders->whereHas('documents', function($query) use ($employee) {
                  $query->whereHas('document', function($query2) use ($employee) {
                      $query2->where('employee_id', $employee->id);
                  });
              });

          }

          if($request->filled('status')) {
              $orders->where('status_id', $request->get('status'));
          }

          if($request->filled('start')) {
              $start = \DateTime::createFromFormat('d/m/Y', $request->get('start'));
              $orders->where('finished_at', '>=', $start->format('Y-m-d') . ' 00:00:00');
          }

          if($request->filled('end')) {
              $end = \DateTime::createFromFormat('d/m/Y', $request->get('end'));
              $orders->where('finished_at', '<=', $end->format('Y-m-d') . ' 23:59:59');
          }
        }

        $lava = new Lavacharts;

        $reasons = $lava->DataTable();
        $reasons2 = $lava->DataTable();
        $reasons3 = $lava->DataTable();
        $reasons4 = $lava->DataTable();

        $groupedByPriority = $groupedByStatus = $groupedByUser = $groupedByType = $orders->get();

        $groupedByType = $groupedByType->groupBy('delivered_by');

        $reasons->addStringColumn('Entregue Por')
                ->addNumberColumn('Percent');

        foreach ($groupedByType as $key => $grouped) {
          $reasons->addRow([$grouped->first()->user->person->name, $grouped->count()]);
        }

        $lava->DonutChart('Entregador', $reasons, [
            'title' => 'Entregas'
        ]);

        $reasons3->addStringColumn('Situação')
                ->addNumberColumn('Porcentagem');

        $groupedByStatus = $groupedByStatus->groupBy('status_id');

        foreach ($groupedByStatus as $key => $grouped) {
          $reasons3->addRow([$grouped->first()->status->name, $grouped->count()]);
        }

        $lava->DonutChart('Status', $reasons3, [
            'title' => 'Entregas Por Situação'
        ]);

        // Prioridade

        $reasons4->addStringColumn('Cliente')
                ->addNumberColumn('Quantidade');

        $groupedByPriority = $groupedByPriority->groupBy('client_id');

        foreach ($groupedByPriority as $key => $grouped) {
          $reasons4->addRow([$grouped->first()->client->name, $grouped->count()]);
        }

        $lava->BarChart('Empresa', $reasons4, [
            'title' => 'Documentos Por Empresa'
        ]);

        $quantity = $orders->count();

        $orders = $orders->paginate();

        foreach ($request->all() as $key => $value) {
            $orders->appends($key, $value);
        }

        return view('delivery-order.index', compact('orders', 'quantity', 'lava', 'delay'));
    }

    public function billing(Request $request)
    {
        $deliveries = DeliveryOrder::whereIn('status_id',
            [Constants::STATUS_DELIVERY_FINALIZADA]);

        $first = new DateTime('first day of this month');
        $last = new DateTime('last day of this month');

        if($request->filled('start') && $request->filled('end')) {
            $first = DateTime::createFromFormat('d/m/Y', $request->get('start'));
            $last = DateTime::createFromFormat('d/m/Y', $request->get('end'));
        }

        $deliveries->where('finished_at', '>=', $first)->where('finished_at', '<=', $last);

        $deliveries = $deliveries->get();

        $lava = new Lavacharts;

        $deliv = $lava->DataTable();

        $deliv->addDateColumn('Date')
              ->addNumberColumn('Entregas');

        $deliveriesPerMonth = $lava->DataTable();

        $deliveriesPerMonth->addDateColumn('Mês')
                 ->addNumberColumn('Entregas')
                 ->setDateTimeFormat('Y-m-d');

        $quantityPerDay = [];
        $deliveriesPerPeriodo = [];

        foreach ($deliveries as $key => $delivery) {

            if(!$delivery->delivered_at) {
               continue;
            }

            $date = $delivery->finished_at ? $delivery->finished_at->format('Y-m-d') : $delivery->delivered_at->format('Y-m-d');
            $dateA = $delivery->finished_at ? $delivery->finished_at->format('Y-m-d') : $delivery->delivered_at->format('Y-m-d');

            if(!isset($quantityPerDay[$date])) {
                $quantityPerDay[$date] = 0;
            }

            $q = $quantityPerDay[$date] += 1;

            $deliv->addRow([$delivery->created_at, $q]);

            if(!isset($quantityPerDay[$dateA])) {
                $quantityPerDay[$dateA] = 0;
            }

            $qA = $quantityPerDay[$dateA] += 1;

            $deliveriesPerMonth->addRow([$dateA, $qA]);

        }

        $lava->CalendarChart('Entregas', $deliv, [
            'title' => 'Entregas Por Dia',
            'unusedMonthOutlineColor' => [
                'stroke'        => '#ECECEC',
                'strokeOpacity' => 0.75,
                'strokeWidth'   => 1
            ],
            'dayOfWeekLabel' => [
                'color'    => '#4f5b0d',
                'fontSize' => 16,
                'italic'   => true
            ],
            'noDataPattern' => [
                'color' => '#DDD',
                'backgroundColor' => '#11FFFF'
            ],
            'colorAxis' => [
                'values' => [0, 100],
                'colors' => ['black', 'green']
            ]
        ]);

        $lava->ColumnChart('EntregasPorMes', $deliveriesPerMonth, [
            'title' => 'Entregas Por Mês',
            'titleTextStyle' => [
                'color'    => '#eb6b2c',
                'fontSize' => 14
            ]
        ]);

        $reasons = $lava->DataTable();
        $reasons2 = $lava->DataTable();
        $reasons3 = $lava->DataTable();
        $reasons4 = $lava->DataTable();

        $groupedByPriority = $groupedByStatus = $groupedByUser = $groupedByType = $deliveries;

        $groupedByType = $groupedByType->groupBy('delivered_by');

        $reasons->addStringColumn('Entregue Por')
                ->addNumberColumn('Percent');

        foreach ($groupedByType as $key => $grouped) {
          $reasons->addRow([$grouped->first()->user->person->name, $grouped->count()]);
        }

        $lava->DonutChart('Entregador', $reasons, [
            'title' => 'Entregas'
        ]);

        $reasons3->addStringColumn('Situação')
                ->addNumberColumn('Porcentagem');

        $groupedByStatus = $groupedByStatus->groupBy('status_id');

        foreach ($groupedByStatus as $key => $grouped) {
          $reasons3->addRow([$grouped->first()->status->name, $grouped->count()]);
        }

        $lava->DonutChart('Status', $reasons3, [
            'title' => 'Entregas Por Situação'
        ]);

        // Prioridade

        $reasons4->addStringColumn('Cliente')
                ->addNumberColumn('Quantidade');

        $groupedByPriority = $groupedByPriority->groupBy('client_id');

        foreach ($groupedByPriority as $key => $grouped) {
          $reasons4->addRow([$grouped->first()->client->name, $grouped->count()]);
        }

        $lava->BarChart('Empresa', $reasons4, [
            'title' => 'Documentos Por Empresa'
        ]);

        $data = [];

        $todayAmount = 0;
        $weekAmount = 0;
        $monthAmount = 0;
        $totalAmount = 0;

        $result = [];
        $loopToday = 0;
        $loopWeek = 0;
        $loopMonth = 0;
        $loopTotal = 0;
        $deliveriesByClient = [];

        $date = $first;

        $result['today'] = [
          'title' => 'Hoje',
          'amount' => '0,00',
          'count' => 0
        ];

        $result['week'] = [
          'title' => 'Semana',
          'amount' => '0,00',
          'count' => 0
        ];

        $result['month'] = [
          'title' => 'Mês',
          'amount' => '0,00',
          'count' => 0
        ];

        $result['total'] = [
          'title' => 'Total',
          'amount' => '0,00',
          'count' => 0
        ];

        $deliveriesGroupedByClient = [];

        foreach ($deliveries->sortBy('client.name') as $key => $delivery) {

            $amount = 0.00;
            $loopTotal++;
            $dateMark = $delivery->finished_at->format('Ymd');

            if(!isset($deliveriesGroupedByClient[$delivery->client->uuid]['deliveries'])) {
                $deliveriesGroupedByClient[$delivery->client->uuid] = ['deliveries' => 0, 'value' => 0.00, 'client_name' => $delivery->client->name, 'charge' => true];
            }

            if(!$delivery->client->charge_delivery || !$delivery->charge_delivery) {
                $deliveriesGroupedByClient[$delivery->client->uuid]['charge'] = false;
            }

            if($delivery->client->charge_delivery && $delivery->charge_delivery) {
              if(!isset($deliveriesGroupedByClient[$delivery->client->uuid]['date']) ||
                $deliveriesGroupedByClient[$delivery->client->uuid]['date'] != $dateMark
                ) {
                $amount = 5.00;
                $deliveriesGroupedByClient[$delivery->client->uuid]['value'] += $amount;
                $deliveriesGroupedByClient[$delivery->client->uuid]['charge'] = true;
              }
            }

            $deliveriesGroupedByClient[$delivery->client->uuid]['deliveries'] += 1;
            $deliveriesGroupedByClient[$delivery->client->uuid]['date'] = $dateMark;

            if($delivery->delivered_at->format('Y-m-d') == now()->format('Y-m-d')) {

                $todayAmount += $amount;
                $loopToday++;

                $result['today'] = [
                  'title' => 'Hoje',
                  'amount' => number_format($todayAmount, 2, ',', '.'),
                  'count' => $loopToday
                ];

            }

            if($delivery->delivered_at > now()->modify('last monday')->setTime(0,0,0) &&
              $delivery->delivered_at < now()->modify('this saturday')->setTime(23,59,59)) {

                $weekAmount += $amount;

                $loopWeek++;

                $result['week'] = [
                  'title' => 'Nesta Semana',
                  'amount' => number_format($weekAmount, 2, ',', '.'),
                  'count' => $loopWeek
                ];

            }

            if($delivery->delivered_at > now()->modify('first day of this month')->setTime(0,0,0) &&
              $delivery->delivered_at < now()->modify('last day of this month')->setTime(23,59,59)) {

                $monthAmount += $amount;

                $loopMonth++;

                $result['month'] = [
                  'title' => 'Neste Mês',
                  'amount' => number_format($monthAmount, 2, ',', '.'),
                  'count' => $loopMonth
                ];

            }

            $totalAmount += $amount;

            $result['total'] = [
              'title' => 'Total',
              'amount' => number_format($totalAmount, 2, ',', '.'),
              'count' => $loopTotal
            ];

        }

        return view('delivery-order.billing', compact('result', 'deliveriesGroupedByClient', 'lava', 'first', 'last'));
    }

    public function billingreport(Request $request)
    {
        $deliveries = DeliveryOrder::whereIn('status_id',
            [Constants::STATUS_DELIVERY_FINALIZADA]);

        $first = new DateTime('first day of this month');
        $last = new DateTime('last day of this month');

        if($request->filled('start') && $request->filled('end')) {
          $first = DateTime::createFromFormat('d/m/Y', $request->get('start'));
          $last = DateTime::createFromFormat('d/m/Y', $request->get('end'));
        }

        if(!$request->has('find')) {
            $deliveries->whereBetween('delivered_at', [$first, $last]);
        }

        $deliveries = $deliveries->get();
        $deliveries = $deliveries->sortBy('client.name')->groupBy('client_id');

        $title = "Entregas:Faturamento";

        $pdf = PDF::loadView('delivery-order.billing-report', compact('deliveries', 'first', 'last'));

        return $pdf->stream($title. ".pdf");

        //return view('delivery-order.billing-report', compact('deliveries'));
    }

    public function billingGraph()
    {
         $colors = ['#1ab394'];

         $resultado = [];

         $today = now()->addMonth(1);
         $sixMonthsAgo = now()->subMonths(6);

         $interval = new DateInterval('P1M');

         $period = new DatePeriod($sixMonthsAgo, $interval, $today);

         foreach ($period as $key => $current) {

           $start = $current->format('Y-m-01') . ' 00:00:00';
           $end = $current->format('Y-m-t') . ' 23:59:59';

           $deliveries = DeliveryOrder::where('status_id', 5)->whereBetween('created_at', [$start, $end])->count();

           $random = array_rand($colors);

           $resultado['data'][] = $deliveries;
           $resultado['labels'][] = $current->format('F');
           $resultado['backgroundColor'][] = $colors[$random];

         }

         return json_encode($resultado);
    }

    public function printTags($id, Request $request)
    {
        $delivery = DeliveryOrder::uuid($id);
        $delivery->printed = true;
        $delivery->save();

        $user = $request->user();

        $file = \Storage::disk('local')->path($user->avatar);

        return view('delivery-order.protocol-simple', compact('delivery', 'file'));
    }

    public function printBatchList(Request $request)
    {
        $orders = DeliveryOrder::where('status_id', Constants::STATUS_DELIVERY_PENDENTE)
        ->where('printed', false);

        if($request->has('only_user')) {
            $orders->where('user_id', $request->user()->id);
        }

        $orders = $orders->get();

        return view('delivery-order.list', compact('orders'));
    }

    public function printBatch(Request $request)
    {
        $data = $request->request->all();

        if(!$request->has('deliveries')) {
          notify()->flash('Erro!', 'error', [
            'text' => 'Informe ao menos um documento para a impressão.'
          ]);

          return back();
        }

        $deliveries = DeliveryOrder::whereIn('uuid', $data['deliveries'])->orderByDesc('id')->get();

        $deliveries->map(function($delivery) {
            $delivery->printed = true;
            $delivery->save();
        });

        $user = $request->user();

        $file = \Storage::disk('local')->path($user->avatar);

        return view('delivery-order.batch', compact('deliveries', 'file'));
    }

    public function start($id, Request $request)
    {
        $delivery = DeliveryOrder::uuid($id);

        if(!$delivery->client->deliver_documents && Auth::check()) {
            return redirect()->route('start_delivery_client', $delivery->uuid);
        }

        if($delivery->status_id == Constants::STATUS_DELIVERY_PENDENTE) {

            if(!Auth::check()) {
                abort(403, 'Ordem de Entrega Pendente');
            }

            $user = $request->user();

            $delivery->status_id = Constants::STATUS_DELIVERY_EM_TRANSITO;
            $delivery->withdrawal_by_client = false;
            $delivery->save();

            $orderCode = str_pad($delivery->id, 6, "0", STR_PAD_LEFT);
            $message = 'Ordem de Entrega nº: '. $orderCode .' está em Transito.';
            $subject = 'Ordem de Entrega no. ' . $orderCode . ' em Transito';
            DeliveryOrderJob::dispatchNow($delivery, $subject , $message);

            Log::create([
              'delivery_order_id' => $delivery->id,
              'status_id' => Constants::STATUS_DELIVERY_EM_TRANSITO,
              'user_id' => $user->id,
              'message' => 'Ordem de Entrega alterada para Em Transio por ' . $user->person->name
            ]);

            return view('delivery-order.scan-transit', compact('message'));

        } elseif($delivery->status_id == Constants::STATUS_DELIVERY_EM_TRANSITO ||
          $delivery->status_id == Constants::STATUS_DELIVERY_ENTREGUE) {

            if(!Auth::check()) {
                abort(403, 'Ordem de Entrega Em Transito');
            }

            $user = $request->user();
            $message = 'Para confirmar a entrega da Ordem de Entrega de nº: '. str_pad($delivery->id, 6, "0", STR_PAD_LEFT) .' é preciso enviar o comprovante.';
            return view('delivery-order.scan-delivered', compact('message', 'delivery'));

        } else {

            return redirect()->route('delivery_receipt_view', $delivery->uuid);

        }

    }

    public function startWithdrawal($id, Request $request)
    {
        $delivery = DeliveryOrder::uuid($id);
        $user = $request->user();

        switch ($delivery->status_id) {
          case Constants::STATUS_DELIVERY_PENDENTE:

            $delivery->status_id = Constants::STATUS_DELIVERY_RETIRADA_PELO_CLIENTE;
            $delivery->delivered_by = $user->id;
            $delivery->withdrawal_by_client = true;
            $delivery->save();

            Log::create([
              'delivery_order_id' => $delivery->id,
              'status_id' => Constants::STATUS_DELIVERY_RETIRADA_PELO_CLIENTE,
              'user_id' => $user->id,
              'message' => 'Ordem de Entrega retirada pelo cliente'
            ]);

          case Constants::STATUS_DELIVERY_PENDENTE:
          case Constants::STATUS_DELIVERY_RETIRADA_PELO_CLIENTE:

            $message = 'Para confirmar a entrega da Ordem de Entrega de nº: '. str_pad($delivery->id, 6, "0", STR_PAD_LEFT) .' é preciso enviar o comprovante.';
            return view('delivery-order.scan-delivered', compact('message', 'delivery'));

          default:
            return redirect()->route('delivery_receipt_view', $delivery->uuid);
        }

    }

    public function deliveryReceipt($id)
    {
        $delivery = DeliveryOrder::uuid($id);

        if(!$delivery->receipt || $delivery->status_id != Constants::STATUS_DELIVERY_FINALIZADA) {
          $message = 'Para confirmar a entrega da Ordem de Entrega de nº: '. str_pad($delivery->id, 6, "0", STR_PAD_LEFT) .' é preciso enviar o comprovante.';
          return view('delivery-order.scan-delivered', compact('message', 'delivery'));
        }

        return view('delivery-order.delivery', compact('delivery'));
    }

    public function deliveryReceiptImage($id)
    {
        $delivery = DeliveryOrder::uuid($id);

        $link = $delivery->receipt;

        $file = \Storage::exists($link) ? \Storage::get($link) : false;

        if(!$file) {
          abort(404, 'Comprovante não encontrado.');
        }

        $mimetype = \Storage::disk('local')->mimeType($link);

        return response($file, 200)->header('Content-Type', $mimetype);
    }

    public function receipt($id, Request $request)
    {
        $data = $request->request->all();

        if(!$request->hasFile('document') && !$delivery->receipt) {

          $message = 'Para confirmar a entrega da Ordem de Entrega de nº: '. str_pad($delivery->id, 6, "0", STR_PAD_LEFT) .' é preciso enviar o comprovante.';
          return view('delivery-order.scan-delivered', compact('message', 'delivery'));

          notify()->flash('Erro!', 'error', [
            'text' => 'A Imagem do protocolo não foi informada.'
          ]);

          return back();
        }

        $user = $request->user();

        $validator = Validator::make($request->all(), [
            //'document' => 'required|image|mimes:jpeg,png,jpg|max:10024',
            'document' => 'required|max:10024',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $delivery = DeliveryOrder::uuid($id);

        if ($request->hasFile('document') && $request->file('document')->isValid()) {
            $path = $request->document->store('receipt');
            $delivery->receipt = $path;
            $delivery->status_id = Constants::STATUS_DELIVERY_ENTREGUE;
            $delivery->delivered_at = now();
            $delivery->save();

            Log::create([
              'delivery_order_id' => $delivery->id,
              'status_id' => Constants::STATUS_DELIVERY_ENTREGUE,
              'user_id' => $user->id,
              'message' => 'Ordem de Entrega alterada para Entregue por ' . $user->person->name
            ]);

        }

        $orderCode = str_pad($delivery->id, 6, "0", STR_PAD_LEFT);
        $message = 'Ordem de Entrega nº: '. $orderCode .' foi entregue.';
        $subject = 'Ordem de Entrega nº. ' . $orderCode . ' Entregue';
        DeliveryOrderJob::dispatchNow($delivery, $subject , $message);

        if(!$delivery->shipment) {
          $delivery->documents->map(function($document) {
              $document->document->status_id = 5;
              $document->document->save();
          });
        }

        $delivery->status_id = 5;
        $delivery->finished_by = $user->id;
        $delivery->finished_at = now();
        $delivery->save();

        Log::create([
          'delivery_order_id' => $delivery->id,
          'status_id' => 5,
          'user_id' => $user->id,
          'message' => 'Ordem de Entrega Confirmada por ' . $user->person->name
        ]);

        return redirect()->route('delivery_done', $delivery->uuid);
    }

    public function done($id, Request $request)
    {
        $delivery = DeliveryOrder::uuid($id);
        //$message = 'A Ordem de Entrega nº: '. str_pad($delivery->id, 6, "0", STR_PAD_LEFT) .' foi entregue.';
        //return view('delivery-order.scan-done', compact('message', 'delivery'));
        return redirect()->route('delivery_receipt_view', $delivery->uuid);
    }

    public function getReceipt($id)
    {
        $delivery = DeliveryOrder::uuid($id);

        $link = $delivery->receipt;

        $file = \Storage::exists($link) ? \Storage::get($link) : false;

        if(!$file) {
          $file = null;
        }

        $mimetype = \Storage::disk('local')->mimeType($link);

        return response($file, 200)->header('Content-Type', $mimetype);
    }

    public function cancel($id)
    {
        try {

          $delivery = DeliveryOrder::uuid($id);

          $user = auth()->user();

          $delivery->documents->map(function($document) {
              $document->document->status_id = 1;
              $document->document->save();
              $document->delete();
          });

          $delivery->status_id = 4;
          $delivery->save();

          Log::create([
            'delivery_order_id' => $delivery->id,
            'status_id' => 4,
            'user_id' => $user->id,
            'message' => 'Ordem de Entrega Cancelada por ' . $user->person->name
          ]);

          return response()->json([
            'success' => true,
            'message' => 'Ordem de Entrega cancelada com sucesso.',
            'route' => route('delivery-order.show', $delivery->uuid)
          ]);

        } catch(\Exception $e) {
          return response()->json([
            'success' => false,
            'message' => 'Ocorreu um erro inesperado',
            'route' => null
          ]);
        }

    }

    public function confirm($id)
    {
        try {

          $delivery = DeliveryOrder::uuid($id);

          $user = auth()->user();

          if(!$delivery->shipment) {
            $delivery->documents->map(function($document) {
                $document->document->status_id = 5;
                $document->document->save();
            });
          }

          $delivery->status_id = 5;
          $delivery->finished_by = $user->id;
          $delivery->finished_at = now();
          $delivery->save();

          Log::create([
            'delivery_order_id' => $delivery->id,
            'status_id' => 5,
            'user_id' => $user->id,
            'message' => 'Ordem de Entrega Confirmada por ' . $user->person->name
          ]);

          return response()->json([
            'success' => true,
            'message' => 'Ordem de Entrega finalizada com sucesso.',
            'route' => route('delivery-order.show', $delivery->uuid)
          ]);

        } catch(\Exception $e) {
          return response()->json([
            'success' => false,
            'message' => 'Ocorreu um erro inesperado',
            'route' => route('delivery-order.index')
          ]);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = $request->request->all();

        $occupation = Occupation::where('name', 'Entregador')->get();

        if($occupation->isEmpty()) {
          notify()->flash('Cargo de Entregador não existe.', 'warning', [
            'text' => 'Para que a entrega possa ser realizada é necessário criar o cargo Entregador.'
          ]);

          return back();
        }

        $occupation = $occupation->first();

        $people = People::where('active', true)->orderBy('name')->get();

        $delivers = $people->filter(function ($person, $key) use ($occupation) {
            return $person->occupation_id == $occupation->id;
        });

        $anotherPeople = $people->filter(function ($person, $key) use ($occupation) {
            return $person->occupation_id != $occupation->id;
        });

        if($delivers->isEmpty()) {
          notify()->flash('Nenhum usuário com o cargo de Entregador.', 'warning', [
            'text' => 'Para que a entrega possa ser realizada é necessário ao menos um usuário com o cargo de Entregador.'
          ]);

          return back();
        }

        $client = null;
        $emails = $addresses = $documents = [];

        if($request->has('client')) {
            $client = Client::uuid($request->get('client'));
            $documents = $client->documents->where('status_id', 1);
            $addresses = $client->addresses;
            $emails = $client->emails;
        } elseif($request->has('document')) {
            $documents = Document::whereIn('uuid', $data['document'])->get();
        }

        return view('delivery-order.create', compact('client', 'documents', 'delivers', 'anotherPeople', 'addresses', 'emails'));
    }

    public function createMany(Request $request)
    {
        $data = $request->request->all();

        $occupation = Occupation::where('name', 'Entregador')->get();

        if($occupation->isEmpty()) {
          notify()->flash('Cargo de Entregador não existe.', 'warning', [
            'text' => 'Para que a entrega possa ser realizada é necessário criar o cargo Entregador.'
          ]);

          return back();
        }

        $occupation = $occupation->first();

        $people = People::where('active', true)->orderBy('name')->get();

        $delivers = $people->filter(function ($person, $key) use ($occupation) {
            return $person->occupation_id == $occupation->id;
        });

        $anotherPeople = $people->filter(function ($person, $key) use ($occupation) {
            return $person->occupation_id != $occupation->id;
        });

        if($delivers->isEmpty()) {
          notify()->flash('Nenhum usuário com o cargo de Entregador.', 'warning', [
            'text' => 'Para que a entrega possa ser realizada é necessário ao menos um usuário com o cargo de Entregador.'
          ]);

          return back();
        }

        $codeCompany = 533;

        if(config('app.env') == 'local') {
            $codeCompany = 1;
        }

        $client = Client::find($codeCompany);
        $documents = Document::where('status_id', Constants::STATUS_DELIVERY_PENDENTE)->get();

        return view('delivery-order.create-many', compact('client', 'delivers', 'anotherPeople', 'documents'));
    }

    public function conference(Request $request)
    {
        if(!$request->has('document')) {

          notify()->flash('Documento não informado!', 'error', [
            'text' => 'Um documento deve ser informado para a geração da Ordem de entrega.'
          ]);

          return back();
        }

        $data = $request->request->all();

        if(count($data) == 1) {

          $document = Document::uuid(current($data['document']));
          $hasDocument = DeliveryOrderDocuments::where('document_id', $document->id)->get();

          if($hasDocument->isNotEmpty()) {

            $string = 'O documento ' . $document->description . ' já está vinculado à Ordem de Entrega n. '. $hasDocument->first()->id ?? '';

            notify()->flash('Falha ao adicionar documento!', 'error', [
              'text' => $string,
            ]);

            return back();

          }

        }

        $occupation = Occupation::where('name', 'Entregador')->get();

        if($occupation->isEmpty()) {
          notify()->flash('Cargo de Entregador não existe.', 'warning', [
            'text' => 'Para que a entrega possa ser realizada é necessário criar o cargo Entregador.'
          ]);

          return back();
        }

        $occupation = $occupation->first();

        $delivers = People::where('occupation_id', $occupation->id)->get();

        if($delivers->isEmpty()) {
          notify()->flash('Nenhum usuário com o cargo de Entregador.', 'warning', [
            'text' => 'Para que a entrega possa ser realizada é necessário ao menos um usuário com o cargo de Entregador.'
          ]);

          return back();
        }

        $documents = Document::whereIn('uuid', $data['document'])->get();
        return view('delivery-order.conference', compact('documents', 'delivers'));
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

        if(!$request->filled('delivered_by')) {
            notify()->flash('Erro de Envio', 'error', [
              'text' => 'Nenhum entregador foi informado.',
            ]);
            return back();
        }

        if(!$request->filled('address_id') && !$request->has('checkbox_address')) {
            notify()->flash('Erro de Envio', 'error', [
              'text' => 'Nenhum endereço foi informado.',
            ]);
            return back();
        }

        if(!$request->has('documents')) {
            notify()->flash('Erro de Envio', 'error', [
              'text' => 'Nenhum documento foi informado.',
            ]);
            return back();
        }

        $chargeDelivery = $request->has('charge_delivery');
        $withdrawal = $request->has('withdrawal_by_client');

        $deliverUuid = $data['delivered_by'];

        $client = Client::uuid($data['client_id']);

        $data['email_notification'] = null;

        if($request->filled('emails')) {
            $data['email_notification'] = implode(', ', $request->get('emails'));
        }

        $deliver = People::uuid($deliverUuid);
        $data['delivered_by'] = $deliver->id;

        if($request->has('checkbox_address')) {

            $clientId = $request->get('client_id');
            $postalCode = $request->get('postal_code');

            $address = Address::create([
              'description' => 'Unidade',
              'zip' => $postalCode,
              'street' => $request->get('route'),
              'number' => $request->get('street_number'),
              'district' => $request->get('sublocality_level_1'),
              'city' => $request->get('administrative_area_level_2'),
              'state' => $request->get('administrative_area_level_1'),
              'long' => $request->get('lng'),
              'lat' => $request->get('lat'),
              'client_id' => $client->id,
              'user_id' => $user->id
            ]);
        } else {
            $address = Address::uuid($data['address_id']);
        }

        $data['address_id'] = $address->id;

        $documents = Document::whereIn('uuid', $data['documents'])->get();

        $documentsGroupedByClients = [];

        $deliveryDate = $data['delivery_date'] ? \DateTime::createFromFormat('d/m/Y', $data['delivery_date']) : null;

        foreach ($documents as $key => $document) {

            $hasDocument = DeliveryOrderDocuments::where('document_id', $document->id)->get();

            if($hasDocument->isNotEmpty()) {

              $string = 'O documento ' . $document->description . ' já está vinculado à Ordem de Entrega n. '. $hasDocument->first()->id ?? '';

              notify()->flash('Falha ao adicionar documento!', 'error', [
                'text' => $string,
              ]);

              return back();

            }

            $documentsGroupedByClients[$document->client->id][] = $document;
        }

        $amount = 0;

        foreach ($documentsGroupedByClients as $keyClient => $documentsGroupedByClient) {

            $deliveryOrder = DeliveryOrder::create([
              'client_id' => $keyClient,
              'status_id' => 1,
              'delivered_by' => $data['delivered_by'],
              'address_id' => $data['address_id'],
              'annotations' => $data['annotations'],
              'delivery_date' => $deliveryDate,
              'email_notification' => $data['email_notification'],
              'withdrawal_by_client' => $withdrawal,
              'charge_delivery' => $chargeDelivery,
              'user_id' => $user->id
            ]);

            foreach ($documentsGroupedByClient as $key => $document) {

                $amount += $document->amount;

                DeliveryOrderDocuments::create([
                  'document_id' => $document->id,
                  'delivery_order_id' => $deliveryOrder->id,
                  'delivery_date' => $deliveryDate,
                  'annotations' => $data['annotations'],
                  'user_id' => $user->id,
                ]);
                $document->status_id = 2;
                $document->save();
            }

            if($chargeDelivery) {
              if($client->charge_delivery) {
                  $deliveryOrder->update(['amount' => 5.00]);
              }
            }

            Log::create([
              'delivery_order_id' => $deliveryOrder->id,
              'status_id' => 1,
              'user_id' => $user->id,
              'message' => 'Ordem de Entrega Criada por ' . $user->person->name
            ]);

        }

        notify()->flash('Sucesso!', 'success', [
          'text' => 'Nova Ordem de Entrega Gerada com sucesso.'
        ]);

        return redirect()->route('delivery-order.show', $deliveryOrder->uuid);
    }

    public function storeMany(Request $request)
    {
        $data = $request->request->all();

        $user = $request->user();

        if(!$request->filled('delivered_by')) {
            notify()->flash('Erro de Envio', 'error', [
              'text' => 'Nenhum entregador foi informado.',
            ]);
            return back();
        }

        if(!$request->filled('address_id') && !$request->has('checkbox_address')) {
            notify()->flash('Erro de Envio', 'error', [
              'text' => 'Nenhum endereço foi informado.',
            ]);
            return back();
        }

        if(!$request->has('documents')) {
            notify()->flash('Erro de Envio', 'error', [
              'text' => 'Nenhum documento foi informado.',
            ]);
            return back();
        }

        $chargeDelivery = $request->has('charge_delivery');
        $withdrawal = $request->has('withdrawal_by_client');

        $deliverUuid = $data['delivered_by'];

        $company = Client::uuid($data['client_id']);

        $deliver = People::uuid($deliverUuid);
        $data['delivered_by'] = $deliver->id;

        $address = Address::uuid($data['address_id']);
        $data['address_id'] = $address->id;

        $documents = Document::whereIn('uuid', $data['documents'])->get();

        $documentsGroupedByClients = [];

        $deliveryDate = $data['delivery_date'] ? \DateTime::createFromFormat('d/m/Y', $data['delivery_date']) : null;

        foreach ($documents as $key => $document) {

            $deliveryOrder = $document->deliveryDocument ?
                             $document->deliveryDocument->deliveryOrder :
                             null;

            if($deliveryOrder && !$deliveryOrder->shipment) {

              $string = 'O documento ' . $document->description . ' já está vinculado à Ordem de Entrega n. '. $hasDocument->first()->id ?? '';

              notify()->flash('Falha ao adicionar documento!', 'error', [
                'text' => $string,
              ]);

              return back();

            }

            $documentsGroupedByClients[$document->client->uuid][] = $document;
        }

        foreach ($documentsGroupedByClients as $keyClient => $documentsGroupedByClient) {
            $client = Client::uuid($keyClient);
            $currentDocument = current($documentsGroupedByClient);
            $codeAddress = $data['address_id-'.$currentDocument->id];
            if(!$codeAddress) {
                notify()->flash('Erro de Envio', 'error', [
                  'text' => 'Nenhum endereço foi informado para o cliente ' . $client->name,
                ]);
                return back();
            }
        }

        foreach ($documentsGroupedByClients as $keyClient => $documentsGroupedByClient) {
            $client = Client::uuid($keyClient);
            $currentDocument = current($documentsGroupedByClient);
            $codeAddress = $data['address_id-'.$currentDocument->id];

            $address = Address::uuid($codeAddress);

            $withdrawal = $request->has('withdrawal_by_client-'.$currentDocument->id);
            $chargeDelivery = $request->has('charge_delivery-'.$currentDocument->id);

            $deliveryOrder = DeliveryOrder::create([
              'client_id' => $client->id,
              'status_id' => 1,
              'delivered_by' => $data['delivered_by'],
              'address_id' => $address->id,
              'delivery_date' => $deliveryDate,
              'withdrawal_by_client' => $withdrawal,
              'charge_delivery' => $chargeDelivery,
              'user_id' => $user->id
            ]);

            foreach ($documentsGroupedByClient as $key => $document) {

                DeliveryOrderDocuments::create([
                  'document_id' => $document->id,
                  'delivery_order_id' => $deliveryOrder->id,
                  'delivery_date' => $deliveryDate,
                  'annotations' => $data['annotations'],
                  'user_id' => $user->id,
                ]);

                $document->status_id = 2;
                $document->save();

            }

            if($chargeDelivery) {
              if($client->charge_delivery) {
                  $deliveryOrder->update(['amount' => 5.00]);
              }
            }

            Log::create([
              'delivery_order_id' => $deliveryOrder->id,
              'status_id' => 1,
              'user_id' => $user->id,
              'message' => 'Ordem de Entrega Criada por ' . $user->person->name
            ]);

        }

        $deliveryOrderShipment = DeliveryOrder::create([
          'client_id' => $company->id,
          'status_id' => 1,
          'delivered_by' => $data['delivered_by'],
          'address_id' => $data['address_id'],
          'delivery_date' => $deliveryDate,
          'charge_delivery' => false,
          'user_id' => $user->id,
          'shipment' => true
        ]);

        Log::create([
          'delivery_order_id' => $deliveryOrderShipment->id,
          'status_id' => 1,
          'user_id' => $user->id,
          'message' => 'Remessa de Entrega Criada por ' . $user->person->name
        ]);

        foreach ($documentsGroupedByClients as $keyClient => $documentsGroupedByClient) {
            foreach ($documentsGroupedByClient as $key => $document) {
                DeliveryOrderDocuments::create([
                  'document_id' => $document->id,
                  'delivery_order_id' => $deliveryOrderShipment->id,
                  'delivery_date' => $deliveryDate,
                  'user_id' => $user->id,
                ]);
            }
        }

        notify()->flash('Sucesso!', 'success', [
          'text' => 'Nova Remessa de Entrega Gerada com sucesso.'
        ]);

        return redirect()->route('delivery-order.show', $deliveryOrderShipment->uuid);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
          $order = DeliveryOrder::uuid($id);
          return view('delivery-order.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $data = $request->request->all();

        $occupation = Occupation::where('name', 'Entregador')->get();

        if($occupation->isEmpty()) {
          notify()->flash('Cargo de Entregador não existe.', 'warning', [
            'text' => 'Para que a entrega possa ser realizada é necessário criar o cargo Entregador.'
          ]);

          return back();
        }

        $occupation = $occupation->first();

        $people = People::where('active', true)->orderBy('name')->get();

        $delivers = $people->filter(function ($person, $key) use ($occupation) {
            return $person->occupation_id == $occupation->id;
        });

        $anotherPeople = $people->filter(function ($person, $key) use ($occupation) {
            return $person->occupation_id != $occupation->id;
        });

        if($delivers->isEmpty()) {
          notify()->flash('Nenhum usuário com o cargo de Entregador.', 'warning', [
            'text' => 'Para que a entrega possa ser realizada é necessário ao menos um usuário com o cargo de Entregador.'
          ]);

          return back();
        }

        $delivery = DeliveryOrder::uuid($id);

        $client = $delivery->client;

        $newDocuments = $client->documents->whereIn('status_id', [1]);

        $documents = $delivery->documents->map(function($document) {
          return $document->document;
        });

        $addresses = $client->addresses;

        return view('delivery-order.edit', compact('documents', 'newDocuments', 'delivers', 'anotherPeople', 'delivery', 'addresses'));
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
        $data = $request->request->all();

        $user = $request->user();

        if(!$request->has('delivered_by')) {
            notify()->flash('Erro de Envio', 'error', [
              'text' => 'Nenhum entregador foi informado.',
            ]);
            return back();
        }

        if(!$request->has('address_id')) {
            notify()->flash('Erro de Envio', 'error', [
              'text' => 'Nenhum endereço foi informado.',
            ]);
            return back();
        }

        if(!$request->has('documents')) {
            notify()->flash('Erro de Envio', 'error', [
              'text' => 'Nenhum documento foi informado.',
            ]);
            return back();
        }

        $deliverUuid = $data['delivered_by'];

        $chargeDelivery = $request->has('charge_delivery');
        $withdrawal = $request->has('withdrawal_by_client');

        $deliver = People::uuid($deliverUuid);
        $data['delivered_by'] = $deliver->id;

        $documents = Document::whereIn('uuid', $data['documents'])->get();

        $deliveryOrder = DeliveryOrder::uuid($id);

        $deliveryDate = $data['delivery_date'] ? \DateTime::createFromFormat('d/m/Y', $data['delivery_date']) : null;

        $documentsAlreadyInOrder = $deliveryOrder->documents->pluck('document.uuid');

        $deliveryOrder->documents->whereNotIn('document.uuid', $data['documents'])
          ->map(function($document) use($deliveryOrder, $user) {
              $document->document->status_id = 1;
              $document->document->save();

              $documentCode = str_pad($document->document->id, 6, "0", STR_PAD_LEFT);

              Log::create([
                'delivery_order_id' => $deliveryOrder->id,
                'status_id' => $deliveryOrder->status_id,
                'user_id' => $user->id,
                'message' => 'Documento no. #' . $documentCode . ' removido da Ordem de Entrega por '. $user->person->name
              ]);

              $document->delete();
          });

        foreach ($documents as $key => $document) {

            if(in_array($document->uuid, $documentsAlreadyInOrder->toArray())) {
                continue;
            }

            DeliveryOrderDocuments::create([
              'document_id' => $document->id,
              'delivery_order_id' => $deliveryOrder->id,
              'delivery_date' => $deliveryDate,
              'annotations' => $data['annotations'],
              'user_id' => $request->user()->id
            ]);

            $document->status_id = 2;
            $document->save();

            $documentCode = str_pad($document->id, 6, "0", STR_PAD_LEFT);

            Log::create([
              'delivery_order_id' => $deliveryOrder->id,
              'status_id' => $deliveryOrder->status_id,
              'user_id' => $user->id,
              'message' => 'Documento no. #' . $documentCode . ' Adicionado à Ordem de Entrega por '. $user->person->name
            ]);

        }

        $address = Address::uuid($data['address_id']);

        $deliveryOrder->update([
          'delivered_by' => $data['delivered_by'],
          'address_id' => $address->id,
          'delivery_date' => $deliveryDate,
          'annotations' => $data['annotations'],
          'withdrawal_by_client' => $withdrawal,
          'charge_delivery' => $chargeDelivery
        ]);

        Log::create([
          'delivery_order_id' => $deliveryOrder->id,
          'status_id' => $deliveryOrder->status_id,
          'user_id' => $user->id,
          'message' => 'Ordem de Entrega Atualizada por ' . $user->person->name
        ]);

        notify()->flash('Sucesso!', 'success', [
          'text' => 'Ordem de Entrega Atualizada com sucesso.'
        ]);

        return redirect()->route('delivery-order.show', $deliveryOrder->uuid);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delivery($id, Request $request)
    {
        $delivery = DeliveryOrder::uuid($id);

        $result = [];

        if(!$delivery) {
            return response()->json('OE nao encontrada.');
        }

        $user = $request->user();

        if($delivery->status_id == Constants::STATUS_DELIVERY_PENDENTE) {

            $delivery->status_id = Constants::STATUS_DELIVERY_EM_TRANSITO;
            //$delivery->save();

            $message = 'Ordem de Entrega nº: '. str_pad($delivery->id, 6, "0", STR_PAD_LEFT) .' está em Transito.';

            $users = User::where('id', 2)->get();

            $subject = 'Ordem de Entrega';

            DeliveryOrderJob::dispatch($delivery, 'Ordem de Entrega', $message)->onQueue('emails');

            Log::create([
              'delivery_order_id' => $delivery->id,
              'status_id' => Constants::STATUS_DELIVERY_EM_TRANSITO,
              'user_id' => $user->id,
              'message' => 'Ordem de Entrega alterada para Em Transio por ' . $user->person->name
            ]);

            /*$result = [
              'id' => $delivery->id,
              'client_id' => $delivery->client_id,
              'client_name' => $delivery->client->name,
              'address_id' => $delivery->address_id,
              'address' => $delivery->address->description,
              'itens' => $delivery->documents->map(function($document) {
                return $document->document;
              })->toArray(),
              'response' => $message
            ];*/

            $result = [
              'id' => $delivery->id,
              //'clientId' => $delivery->client_id,
              'client' => $delivery->client->name,
              //'response' => $message
            ];

            return json_encode($result);

            dd($result);

            return view('delivery-order.scan-transit', compact('message'));

        } elseif($delivery->status_id == Constants::STATUS_DELIVERY_EM_TRANSITO) {

            $message = 'Para confirmar a entrega da Ordem de Entrega de nº: '. str_pad($delivery->id, 6, "0", STR_PAD_LEFT) .' é preciso enviar o comprovante.';

            return view('delivery-order.scan-delivered', compact('message', 'delivery'));

        } else {
            return abort(404);
        }
    }

    public function receiptUpload($id, Request $request)
    {
        $delivery = DeliveryOrder::uuid($id);
        $user = $request->user();

        if(!in_array($delivery->status_id, [1,2,3])) {
            notify()->flash('Erro!', 'error', [
              'text' => 'A imagem do protocolo não pode ser alterada devido o status da Ordem de Entrega.'
            ]);
        }

        if ($request->hasFile('receipt') && $request->file('receipt')->isValid()) {
            $path = $request->receipt->store('receipt');

            if($delivery->receipt) {
                if(Storage::exists($delivery->receipt)) {
                    Storage::delete($delivery->receipt);
                }
            }

            $delivery->receipt = $path;
            $delivery->save();

            Log::create([
              'delivery_order_id' => $delivery->id,
              'status_id' => $delivery->status_id,
              'user_id' => $user->id,
              'message' => 'Comprovante de Entrega alterado por ' . $user->person->name
            ]);

        }
    }
}
