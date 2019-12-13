<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceOrder\Service;
use App\Models\ServiceOrder\Service\Value as ServiceValue;
use App\Models\ServiceOrder\Service\Ticket\Type as ServiceTicketType;
use App\Models\ServiceOrder\Service\Training\Course as ServiceTrainingCourse;
use App\Models\Ticket\Type as TicketType;
use App\Models\Training\Course as Course;
use App\Models\{Contract};

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $services = Service::orderBy('name');

        if($request->filled('search')) {
          $search = $request->get('search');
          $services->where('id', $search)
          ->orWhere('name', 'like', "%$search%")
          ->orWhere('description', 'like', "%$search%");
        }

        if($request->filled('service_type_id')) {
            $services->where('service_type_id', $request->get('service_type_id'));
        }

        $quantity = $services->count();
        $services = $services->paginate();
        return view('service-order.service.index', compact('services', 'quantity'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('service-order.service.create');
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

        $ticketTypes = $request->get('ticket_types');
        $courses = $request->get('courses');

        $service = Service::create($data);

        $contracts = Contract::where('active', true)->get();

        foreach ($contracts as $key => $contract) {

            $slug = 'value-'.$contract->uuid;
            $slugCost = 'cost-'.$contract->uuid;

            if($request->has($slug) && $request->has($slugCost)) {

                $value = $request->get($slug);
                if($value) {
                    $value = \App\Helpers\Helper::brl2decimal($value);
                }

                $cost = $request->get($slugCost);
                if($cost) {
                  $cost = \App\Helpers\Helper::brl2decimal($cost);
                }

                ServiceValue::create([
                  'service_id' => $service->id,
                  'value' => $value ?: 0.00,
                  'cost' => $cost ?: 0.00,
                  'contract_id' => $contract->id,
                ]);
            }
        }

        if($request->filled('ticket_types')) {
            foreach ($ticketTypes as $key => $ticketType) {
                $ticketType = TicketType::uuid($ticketType);
                ServiceTicketType::create([
                  'service_id' => $service->id,
                  'ticket_type_id' => $ticketType->id
                ]);
            }
        }

        if($request->filled('courses')) {
            foreach ($courses as $key => $course) {
                $course = Course::uuid($course);
                ServiceTrainingCourse::create([
                  'service_id' => $service->id,
                  'course_id' => $course->id
                ]);
            }
        }

        notify()->flash('Sucesso', 'success', [
          'text' => 'Serviço adicionado com sucesso.'
        ]);

        return redirect()->route('services.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service = Service::uuid($id);

        $values = $service->values->where('active', true);
        return view('service-order.service.show', compact('service', 'values'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $service = Service::uuid($id);
        $values = $service->values->where('active', true);

        $ticketTypes = $service->ticketTypes->pluck('ticket_type_id')->toArray();
        $courses = $service->courses->pluck('course_id')->toArray();

        return view('service-order.service.edit', compact('service', 'values', 'ticketTypes', 'courses'));
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

        $ticketTypes = $request->get('ticket_types');
        $courses = $request->get('courses');

        $service = Service::uuid($id);

        $service->ticketTypes->map(function($serviceTicketType) use($ticketTypes) {
            if(!in_array($serviceTicketType->type->uuid, $ticketTypes)) {
                $serviceTicketType->delete();
            }
        });

        $service->courses->map(function($serviceCourses) use($courses) {
            if(!in_array($serviceCourses->course->uuid, $courses)) {
                $serviceCourses->delete();
            }
        });

        $data['active'] = $request->has('active');

        $service->update($data);

        $contracts = Contract::where('active', true)->get();

        foreach ($contracts as $key => $contract) {

            $slug = 'value-'.$contract->uuid;
            $slugCost = 'cost-'.$contract->uuid;

            if($request->has($slug)) {

                $value = $request->get($slug);
                $cost = $request->get($slugCost);

                if(!empty($value) && !empty($cost)) {
                  $value = \App\Helpers\Helper::brl2decimal($value);
                  $cost = \App\Helpers\Helper::brl2decimal($cost);
                } else {
                  $cost = $value = 0.00;
                }

                $serviceValues = $service->values->where('contract_id', $contract->id)
                  ->where('active', true);

                foreach ($serviceValues as $key => $serviceValue) {

                    $serviceValue->value = $value ?: 0.00;
                    $serviceValue->cost = $cost ?: 0.00;
                    $serviceValue->save();

                }

            }
        }

        if($request->filled('ticket_types')) {

          foreach ($ticketTypes as $key => $ticketType) {

              $ticketType = TicketType::uuid($ticketType);

              ServiceTicketType::updateOrCreate([
                'service_id' => $service->id,
                'ticket_type_id' => $ticketType->id
              ]);
          }

        }

        if($request->filled('courses')) {

          foreach ($courses as $key => $course) {

              $course = Course::uuid($course);

              ServiceTrainingCourse::updateOrCreate([
                'service_id' => $service->id,
                'course_id' => $course->id
              ]);
          }

        }

        notify()->flash('Sucesso', 'success', [
          'text' => 'Serviço atualizado com sucesso.'
        ]);

        return redirect()->route('services.show', $service->uuid);
    }
}
