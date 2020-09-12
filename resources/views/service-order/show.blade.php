@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Ordem de Serviço</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('service-order.index') }}"> Ordem de Serviço </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Informações</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

  <div class="row">

    <div class="col-xl-12 col-lg-12 filter-bar">

      <div class="card">
          <div class="card-block">
              <div class=" waves-effect waves-light m-r-10 v-middle issue-btn-group">

                  <a href="{{route('service_order_receipt', ['id' => $order->uuid])}}" target="_blank" class="btn btn-primary text-white btn-sm">Imprimir OS</a>
                  <a href="{{route('service_order_receipt', ['id' => $order->uuid, 'without_value' => 1])}}" target="_blank" class="btn btn-primary text-white btn-sm">Imprimir OS sem valor</a>
                  <a href="{{route('service_order_contract', ['id' => $order->uuid])}}" target="_blank" class="btn btn-primary text-white btn-sm">Imprimir Proposta</a>
                  <a href="{{route('service-order.edit', ['id' => $order->uuid])}}" class="btn btn-primary text-white btn-sm">Editar</a>

                  <a href="{{route('service_order_email', ['id' => $order->uuid])}}" target="_blank" class="btn btn-primary text-white btn-sm">Enviar por E-mail</a>

              </div>
          </div>
      </div>
    </div>

    <div class="col-md-12">

        <div class="card">
            <div class="card-header card bg-c-green update-card">
                <h5 class="text-white">Informações da Ordem de Serviço</h5>
            </div>
            <div class="card-block">
              <h2>{{ $order->client->name}}</h2>
              <p>CNPJ: {{ $order->client->document}}</p>
              <p>OS #{{ str_pad($order->id, 6, "0", STR_PAD_LEFT) }}</p>
              <p>Contrato: {{ $order->contract->name}}</p>
              <p>Contato: {{ $order->contact ? $order->contact->name : '-' }}</p>
              <p>Situação: {{ $order->status->name}}</p>
            </div>
        </div>

        <div class="row">
        <div class="col-md-6">

        <div class="card">
            <div class="card-header">
                <h5>Chamados</h5>
                <span>Lista de chamados que serão vinculados à OS.</span>
            </div>
            <div class="card-block table-border-style">
                <div class="table-responsive">
                    <table class="table table-lg table-styling">
                        <thead>
                            <tr class="table-inverse">
                                <th>Chamados</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($order->tickets as $ticket)
                              <tr>
                                  <th scope="row">{{ $ticket->type->name }}

                                    @if(empty($ticket->ticket_id))

                                        <a href="{{ route('tickets.create', ['ticket' => $ticket->uuid, 'type' =>  $ticket->type->uuid, 'service_order' => $order->uuid]) }}" class="btn btn-success text-white btn-round f-right">Abrir Chamado</a>

                                    @elseif($ticket->ticket)

                                        <a target="_blank" href="{{ route('tickets.show', $ticket->ticket->uuid) }}" class="btn btn-primary text-white btn-round f-right">Chamado</a>

                                    @endif

                                    <br/>
                                    <small>Categoria: {{ $ticket->type->category->name }}</small><br/>
                                    @if(empty($ticket->ticket_id))
                                        <span class="label label-danger">Pendente</span>
                                    @endif

                                  </th>
                              </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        </div>

        <div class="col-md-6">

        <div class="card">
            <div class="card-header">
                <h5>Treinamentos</h5>
                <span>Lista de treinamentos que serão vinculados à OS.</span>
            </div>
            <div class="card-block table-border-style">
                <div class="table-responsive">
                    <table class="table table-lg table-styling">
                        <thead>
                            <tr class="table-inverse">
                                <th>Treinamentos</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($order->courses as $course)
                              <tr>
                                  <th scope="row">{{ $course->course->title }}

                                      @if(empty($course->team_id))

                                          <a href="{{ route('teams.create', ['service_order_course' => $course->uuid, 'course' =>  $course->course->uuid, 'service_order' => $order->uuid]) }}" class="btn btn-success text-white btn-round f-right">Agendar</a>

                                      @elseif($course->team)

                                          <a target="_blank" href="{{ route('teams.show', $course->team->uuid) }}" class="btn btn-primary text-white btn-round f-right">Turma</a>

                                      @endif

                                    <br/>
                                    @if(empty($course->team_id))
                                        <span class="label label-danger">Pendente</span>
                                    @endif
                                  </th>
                              </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Unidades do Cliente</h5>
                <span>Listagem de Unidades/Endereços onde os serviços serão realizados.</span>
            </div>
            <div class="card-block table-border-style">
                <div class="table-responsive">
                    <table class="table table-lg table-styling">
                        <thead>
                            <tr class="table-primary">
                                <th>Unidade</th>
                                <th>CNPJ</th>
                                <th>CEP</th>
                                <th>Endereço</th>
                                <th>Bairro</th>
                                <th>Cidade</th>
                            </tr>
                        </thead>
                        <tbody>

                          @foreach($order->addresses as $address)
                            @php
                                $address = $address->address;
                            @endphp
                              <tr>
                                  <th scope="row"><a href="#">{{ str_pad($address->id, 6, "0", STR_PAD_LEFT) }} - {{ $address->description }}</a></th>
                                  <td>{{ $address->document }}</td>
                                  <td>{{ $address->zip }}</td>
                                  <td>{{ $address->street }}, {{ $address->number }}<br/>
                                      <small>{{ $address->complement }}</small>
                                  </td>
                                  <td>{{ $address->district }}</td>
                                  <td>{{ $address->city }} / {{ $address->state }}</td>
                              </tr>
                          @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">

                <div class="card">
                    <div class="card-header card bg-c-green update-card">
                        <h5 class="text-white">Tabela de Serviços</h5>
                        <span class="text-white">Listagem dos valores e custos do serviço por contrato.</span>
                    </div>

                    <div class="card-block">

                      <div class="row">
                          <div class="col-lg-12 col-xl-12">
                              <!-- Nav tabs -->
                              <ul class="nav nav-tabs md-tabs tabs-left b-none" role="tablist">
                                @foreach($order->services as $service)
                                  <li class="nav-item">
                                      <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#item-{{ $loop->index }}" role="tab" aria-expanded="{{ $loop->first ? 'true' : 'false' }}">{{ $service->service->name }}</a>
                                      <div class="slide"></div>
                                  </li>
                                @endforeach
                              </ul>
                              <!-- Tab panes -->
                              <div class="tab-content tabs-left-content card-block">
                                @foreach($order->services as $service)
                                  <div class="tab-pane {{ $loop->first ? 'active' : '' }}" id="item-{{ $loop->index }}" role="tabpanel" aria-expanded="{{ $loop->first ? 'true' : 'false' }}">

                                      @foreach($service->service->values->where('contract_id', $order->contract_id) as $value)

                                      <div class="sub-title">{{ $service->service->name }}</div>

                                      <div class="row">

                                          <div class="col-xl-3 col-md-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Quantidade</label>
                                                <div class="input-group">
                                                    <input class="form-control inputUpdateOS" type="number" data-type="integer" data-url="{{ route('service_order_item_update', $service->uuid) }}" name="quantity" value="{{$service->quantity ?? 1}}" min="1" max="50"/>
                                                </div>
                                            </div>
                                          </div>

                                          <div class="col-xl-3 col-md-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Valor</label>
                                                <div class="input-group">
                                                    <input class="form-control inputMoney inputUpdateOS" data-type="money" data-url="{{ route('service_order_item_update', $service->uuid) }}" type="text" name="value" value="{{ number_format($service->value, 2, ',', '.') }}" placeholder="Valor do serviço"/>
                                                </div>
                                            </div>
                                          </div>

                                          <div class="col-xl-3 col-md-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Executor</label>
                                                <div class="input-group">
                                                  <select class="form-control inputUpdateOS" name="user_id" data-type="integer" data-url="{{ route('service_order_item_update', $service->uuid) }}">
                                                    <option value="">Selecione</option>
                                                    @foreach(\App\Helpers\Helper::users() as $user)
                                                      <option value="{{ $user->id }}" {{$service->user_id == $user->id ? 'selected' : ''}}>{{ $user->person->name }}</option>
                                                    @endforeach
                                                  </select>
                                                </div>
                                            </div>
                                          </div>

                                          <div class="col-xl-3 col-md-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Prazo</label>
                                                <div class="input-group">
                                                    <input class="form-control inputDate inputUpdateOS" data-type="date" data-url="{{ route('service_order_item_update', $service->uuid) }}" type="text" name="deadline" value="{{ $service->deadline ? $service->deadline->format('d/m/Y') : '' }}" placeholder="Prazo para realização do serviço"/>
                                                </div>
                                            </div>
                                          </div>

                                          <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Observação</label>
                                                <div class="input-group">
                                                    <textarea class="form-control inputUpdateOS" rows="4" data-type="text" data-url="{{ route('service_order_item_update', $service->uuid) }}" type="text" name="observation" placeholder="Observação para a realização do serviço">{{ $service->observation }}</textarea>
                                                </div>
                                            </div>
                                          </div>

                                      </div>

                                      @endforeach

                                  </div>
                                @endforeach
                              </div>
                          </div>
                      </div>

                    </div>

                </div>

            </div>
            <div class="col-md-6">

                <div class="card">
                    <div class="card-header card bg-c-green update-card">
                        <h5 class="text-white">Informações Financeiras</h5>
                        <span class="text-white">Listagem dos valores e custos do serviço por contrato.</span>
                    </div>
                    <div class="card-block">

                      <div class="row">

                          <div class="col-md-3">
                            <div class="form-group">
                                <label class="col-form-label">Valor Total</label>
                                <div class="input-group">
                                  <input type="text" class="form-control inputMoney inputUpdateOS" data-type="money" data-url="{{ route('service_order_update', $order->uuid) }}" name="amount" value="{{ $order->amount ? number_format($order->amount, 2, ',', '.') : number_format($order->services->sum('value'), 2, ',', '.') }}"/>
                                </div>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                                <label class="col-form-label">Desconto</label>
                                <div class="input-group">
                                  <input type="text" class="form-control inputMoney inputUpdateOS" data-type="money" data-url="{{ route('service_order_update', $order->uuid) }}" name="discount" value="{{ $order->discount ? number_format($order->discount, 2, ',', '.') : '0,00' }}"/>
                                </div>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                                <label class="col-form-label">Valor de Entrada</label>
                                <div class="input-group">
                                  <input type="text" class="form-control inputMoney inputUpdateOS" data-type="money" data-url="{{ route('service_order_update', $order->uuid) }}" name="input_value" value="{{ $order->input_value ? number_format($order->input_value, 2, ',', '.') : '0,00' }}"/>
                                </div>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                                <label class="col-form-label">Data de Vencimento</label>
                                <div class="input-group">
                                  <input type="text" class="form-control inputDate inputUpdateOS" name="due_date" value="{{ $order->due_date ? $order->due_date->format('d/m/Y') : '' }}" data-type="date" data-url="{{ route('service_order_update', $order->uuid) }}"/>
                                </div>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                                <label class="col-form-label">Qtd. de Parcelas</label>
                                <div class="input-group">
                                  <input type="number" min="1" max="12" maxlength="2" class="form-control inputMoney inputUpdateOS" name="installment_quantity" value="{{ $order->installment_quantity ?? 1 }}" data-type="money" data-url="{{ route('service_order_update', $order->uuid) }}"/>
                                </div>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                                <label class="col-form-label">Valor das Parcelas</label>
                                <div class="input-group">
                                  <input type="text" class="form-control inputMoney inputUpdateOS" name="installment_value" value="{{ $order->installment_value ? number_format($order->installment_value, 2, ',', '.') : '0,00' }}" data-type="money" data-url="{{ route('service_order_update', $order->uuid) }}"/>
                                </div>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                                <label class="col-form-label">Data da Parcela</label>
                                <div class="input-group">
                                  <input type="text" class="form-control inputDate inputUpdateOS" name="installment_date" value="{{ $order->installment_date ? $order->installment_date->format('d/m/Y') : '' }}" data-type="date" data-url="{{ route('service_order_update', $order->uuid) }}"/>
                                </div>
                            </div>
                          </div>

                      </div>

                    </div>
                </div>

            </div>
            <div class="col-md-6">

                <div class="card">
                    <div class="card-header card bg-c-green update-card">
                        <h5 class="text-white">Outras Informações</h5>
                        <span class="text-white">Informações para finalização da OS.</span>
                    </div>
                    <div class="card-block">

                      <div class="row m-b-30">

                          <div class="col-md-3">
                            <div class="form-group">
                                <label class="col-form-label">DATA DE SOLICITAÇÃO DE DADOS AO CLIENTE</label>
                                <div class="input-group">
                                  <input type="text" class="form-control inputDate inputUpdateOS" data-type="date" data-url="{{ route('service_order_update', $order->uuid) }}" name="client_data_solicitation_date" value="{{ $order->client_data_solicitation_date ? $order->client_data_solicitation_date->format('d/m/Y') : '' }}"/>
                                </div>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                                <label class="col-form-label">DATA DE RETORNO DO CLIENTE</label>
                                <div class="input-group">
                                  <input type="text" class="form-control inputDate inputUpdateOS" data-type="date" data-url="{{ route('service_order_update', $order->uuid) }}" name="client_feedback_date" value="{{ $order->client_feedback_date ? $order->client_feedback_date->format('d/m/Y') : '' }}"/>
                                </div>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                                <label class="col-form-label">DATA DE LIBERAÇÃO DA OS PARA ÁREA TÉCNICA</label>
                                <div class="input-group">
                                  <input type="text" class="form-control inputDate inputUpdateOS" name="release_date" value="{{ $order->release_date ? $order->release_date->format('d/m/Y') : '' }}" data-type="date" data-url="{{ route('service_order_update', $order->uuid) }}"/>
                                </div>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                                <label class="col-form-label">SERVIÇO CONCLUÍDO?</label>
                                <div class="input-group">
                                  <input type="checkbox" class="inputUpdateOS" name="completed_service" value="1" {{ $order->completed_service ? 'checked' : '' }} data-type="boolean" data-url="{{ route('service_order_update', $order->uuid) }}"/>
                                </div>
                            </div>
                          </div>

                          <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-form-label">OBSERVAÇÕES QUANTO A EVOLUÇÃO DA OS</label>
                                <div class="input-group">
                                  <textarea rows="6" class="form-control inputUpdateOS" name="observation" data-type="text" data-url="{{ route('service_order_update', $order->uuid) }}">{{ $order->observation }}</textarea>
                                </div>
                            </div>
                          </div>

                      </div>

                    </div>
                </div>

            </div>
        </div>

    </div>

  </div>

</div>

@endsection

@section('scripts')

<script>

  $(document).ready(function() {

      $(".inputUpdateOS").change(function() {

          var self = $(this);
          var value = self.val();
          var name = self.attr('name');
          var url = self.data('url');
          var type = self.data('type');

          $.ajax({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type: "POST",
              url: url,
              dataType: 'json',
              cache: true,
              data: {
                name: name,
                value: value,
                type: type
              },
              success: function(data) {

              }
          });

      });

  });

</script>

@endsection
