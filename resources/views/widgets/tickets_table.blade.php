<div class="card">
    <div class="card-header">
        <h5>Chamados Recentes</h5>
        <span>Registros retornados: {{ $quantity }}</span>
    </div>
    <div class="card-block table-border-style">
        <div class="table-responsive">
            <table class="table table-lg table-styling">
                <thead>
                    <tr class="table-primary">
                        <th>No.</th>
                        <th>Situação</th>
                        <th>Descrição</th>
                        <th>Solicitante</th>
                        <th>Abertura/Finalização</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($tickets as $ticket)

                    <tr>
                        <td><a href="{{ route('tickets.show', $ticket->uuid) }}" class="card-title">#{{ str_pad($ticket->id, 6, "0", STR_PAD_LEFT) }}</a></td>
                        <td>
                          <span class="label label-{{\App\Helpers\Helper::getColorFromValue($ticket->status->id)}} f-right"> {{$ticket->status->name}} </span>
                        </td>
                        <td>
                          <p data-toggle="tooltip" data-original-title="{{ html_entity_decode(strip_tags(substr($ticket->description, 0, 800))) }}">
                              {{$ticket->type->category->name}} - {{$ticket->type->name}}
                          </p>
                        </td>
                        <td>
                          <img width="32" class="img-fluid img-radius" src="{{ route('image', ['user' => $ticket->user->uuid, 'link' => $ticket->user->avatar, 'avatar' => true])}}" title="{{ $ticket->user->person->name }}" alt="{{ $ticket->user->person->name }}">
                          &nbsp;&nbsp;{{ $ticket->user->person->name }}
                        </td>
                        <td>
                          {{$ticket->created_at->format('d/m/Y H:i')}}
                          <br/>
                          <label class="label label-inverse-primary">{{ $ticket->created_at->diffForHumans() }}</label>
                        </td>
                    </tr>
                  @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
