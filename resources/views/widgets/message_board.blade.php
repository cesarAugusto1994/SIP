<div class="card latest-update-card">
    <div class="card-header card bg-c-green update-card">
        <h5 class="text-white">Gestão à Vista</h5>
        <span class="text-white">Mural de recados com informes e anúncios da empresa ou setor</span>
    </div>
    <div class="card-block">

      @if(auth()->user()->messageBoard->isNotEmpty())

        <div class="latest-update-box">
          @foreach(auth()->user()->messageBoard as $message)
              @php
                  $message = $message->board;
              @endphp
              <div class="row p-t-20 p-b-30">
                  <div class="col-auto text-right update-meta">
                      <p class="text-muted m-b-0 d-inline">{{ $message->created_at->diffForHumans() }}</p>
                      <i class="feather icon-briefcase bg-info update-icon"></i>
                  </div>
                  <div class="col">
                    <a class="" href="{{ route('message-board.show', $message->uuid) }}">
                      <h6>{{ $message->subject }}</h6>
                      <p class="text-muted m-b-0">
                          {{ html_entity_decode(strip_tags(substr($message->content, 0, 500))) }} ...
                      </p>
                    </a>
                      <br/>
                      <span class="label label-{{ array_random(['info', 'success', 'primary', 'warning']) }}">{{ $message->type->name }}</span>
                      @if($message->important)
                          <span class="label label-danger }}">Importante</span>
                      @endif

                      <span class="badge badge-inverse-success">Visualizado por: {{ $message->messages->where('status', 'VISUALIZADO')->count() }}</span>
                  </div>
              </div>

          @endforeach
        </div>

        @else

          <div class="widget white-bg no-padding">
              <div class="p-m text-center">
                  <h1 class="m-md"><i class="far fa-comment fa-2x"></i></h1>
                  <br/>
                  <h6 class="font-bold no-margins">
                      Voce não possui nenhum recado até o momento.
                  </h6>
              </div>
          </div>

        @endif

    </div>
</div>
