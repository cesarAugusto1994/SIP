<div class="row">

    <div class="col-xl-4 col-md-6">
        <div class="card update-card">
            <div class="card-block">
                <div class="row align-items-end">
                    <div class="col-12">
                        <h4 class="text-inverse">{{ \App\Helpers\Helper::ticketsTotal() }}</h4>
                        <h6 class="text-inverse m-b-0">Chamados</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-xl-4 col-md-6">
        <div class="card update-card">
            <div class="card-block">
                <div class="row align-items-end">
                    <div class="col-12">
                        <h4 class="text-inverse">{{ \App\Helpers\Helper::ticketsClosedTotal() }}</h4>
                        <h6 class="text-inverse m-b-0">Chamados Concluídos</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="card update-card">
            <div class="card-block">
                <div class="row align-items-end">
                    <div class="col-12">
                        <h4 class="text-inverse">{{ \App\Helpers\Helper::tasksTotal() }}</h4>
                        <h6 class="text-inverse m-b-0">Tarefas</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="card update-card">
            <div class="card-block">
                <div class="row align-items-end">
                    <div class="col-12">
                        <h4 class="text-inverse">{{ \App\Helpers\Helper::documentsTotal() }}</h4>
                        <h6 class="text-inverse m-b-0">Documentos</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="card update-card">
            <div class="card-block">
                <div class="row align-items-end">
                    <div class="col-12">
                        <h4 class="text-inverse">{{ \App\Helpers\Helper::deliveriesTotal() }}</h4>
                        <h6 class="text-inverse m-b-0">Ordens de Entrega</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="card update-card">
            <div class="card-block">
                <div class="row align-items-end">
                    <div class="col-12">
                        <h4 class="text-inverse">{{ \App\Helpers\Helper::teamsTotal() }}</h4>
                        <h6 class="text-inverse m-b-0">Treinamentos</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="card update-card">
            <div class="card-block">
                <div class="row align-items-end">
                    <div class="col-12">
                        <h4 class="text-inverse">{{ \App\Helpers\Helper::teamEmloyeesTotal() }}</h4>
                        <h6 class="text-inverse m-b-0">Alunos dos Treinamentos</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="card update-card">
            <div class="card-block">
                <div class="row align-items-end">
                    <div class="col-12">
                        <h4 class="text-inverse">{{ \App\Helpers\Helper::clients()->count() }}</h4>
                        <h6 class="text-inverse m-b-0">Clientes</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="card update-card">
            <div class="card-block">
                <div class="row align-items-end">
                    <div class="col-12">
                        <h4 class="text-inverse">{{ \App\Helpers\Helper::employees()->count() }}</h4>
                        <h6 class="text-inverse m-b-0">Funcionários</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="card update-card">
            <div class="card-block">
                <div class="row align-items-end">
                    <div class="col-12">
                        <h4 class="text-inverse">{{ \App\Helpers\Helper::onlineUsers() }}</h4>
                        <h6 class="text-inverse m-b-0">Online</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="card update-card">
            <div class="card-block">
                <div class="row align-items-end">
                    <div class="col-12">
                        <h4 class="text-inverse">{{ \App\Helpers\Helper::userLogs(auth()->user()) }}</h4>
                        <h6 class="text-inverse m-b-0">Logs do Usuário</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="card update-card">
            <div class="card-block">
                <div class="row align-items-end">
                    <div class="col-12">
                        <h4 class="text-inverse">{{ \App\Helpers\Helper::usersLogs() }}</h4>
                        <h6 class="text-inverse m-b-0">Logs da Aplicação</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
