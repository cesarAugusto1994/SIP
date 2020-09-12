<div class="card user-card-full">
    <div class="row m-l-0 m-r-0">
        <div class="col-sm-4 bg-c-green user-profile">
            <div class="card-block text-center text-white">
                <div class="m-b-25">
                </div>
                <h6 class="f-w-600">{{ Auth()->user()->person->name }}</h6>
                <p>{{ Auth()->user()->person->department->name }}</p>
                <a class="btn btn-sm" href="{{route('user')}}"><i class="feather icon-edit m-t-10 f-16"></i></a>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="card-block">
                <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Suas Informações</h6>
                <div class="row">
                    <div class="col-sm-6">
                        <p class="m-b-10 f-w-600">E-mail</p>
                        <h6 class="text-muted f-w-400">{{ Auth()->user()->email }}</h6>
                    </div>
                    <div class="col-sm-6">
                        <p class="m-b-10 f-w-600">Ramal</p>
                        <h6 class="text-muted f-w-400">{{ Auth()->user()->person->branch }}</h6>
                    </div>
                </div>
                <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600">Suas Atividades</h6>
                <div class="row">
                    <div class="col-sm-6">
                        <p class="m-b-10 f-w-600">Último Login</p>
                        <h6 class="text-muted f-w-400">{{ Auth()->user()->lastLoginAt() ? Auth()->user()->lastLoginAt()->format('d/m/Y H:i') : '-' }}</h6>
                    </div>
                    <div class="col-sm-6">
                        <p class="m-b-10 f-w-600">Última Atividade</p>
                        <h6 class="text-muted f-w-400">{{ auth()->user()->activities->isNotEmpty() ? auth()->user()->activities->last()->created_at->format('d/m/Y H:i:s') : '' }}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
