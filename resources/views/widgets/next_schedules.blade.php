<div class="card feed-card">
    <div class="card-header card bg-c-green update-card">
        <h5 class="text-white">Próximos Compromissos</h5>
        <span class="text-white">Lista de seus compromissos</span>
    </div>
    <div class="card-block">
      @forelse(\App\Helpers\Helper::listNextSchedules() as $schedule)
        <div class="row m-b-30">
            <div class="col-auto p-r-0">
                <i class="feather icon-bell bg-simple-c-blue feed-icon"></i>
            </div>
            <div class="col">
                <h6 class="m-b-5"><a href="{{ route('schedules.show', $schedule['uuid']) }}">{{ $schedule['title'] }} </a><span class="text-muted f-right f-13">{{ $schedule['start'] }}</span></h6>
            </div>
        </div>
      @empty
        <div class="widget white-bg no-padding">
            <div class="p-m text-center">
                <h1 class="m-md"><i class="fas fa-history fa-2x"></i></h1>
                <br/>
                <h6 class="font-bold no-margins">
                    Nenhum compromisso agendado.
                </h6>
            </div>
        </div>
      @endforelse
    </div>
</div>
