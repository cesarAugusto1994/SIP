<?php

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $itens = [
          [
            'title' => 'Painel Principal',
            'route' => 'home',
            'permission' => null,
            'description' => 'Painel Principal',
            'parent' => null,
            'icon' => 'feather icon-home',
          ],

          [
            'title' => 'Clientes',
            'route' => 'clients.index',
            'permission' => 'view.clientes',
            'description' => 'Clientes',
            'parent' => null,
            'icon' => 'fas fa-users',
          ],
          /*[
            'title' => 'Treinamentos',
            'route' => null,
            'permission' => 'view.treinamentos',
            'description' => 'Treinamentos',
            'parent' => null,
            'icon' => 'fas fa-toolbox',
          ],
              [
                'title' => 'Cursos',
                'route' => 'courses.index',
                'permission' => 'view.cursos',
                'description' => 'Cursos',
                'parent' => 'Treinamentos',
                'icon' => 'fas fa-book',
              ],
              [
                'title' => 'Turmas',
                'route' => 'teams.index',
                'permission' => 'view.turmas',
                'description' => 'Turmas',
                'parent' => 'Treinamentos',
                'icon' => 'fas fa-users',
              ],
              [
                'title' => 'Agenda',
                'route' => 'teams.index',
                'permission' => 'view.agenda',
                'description' => 'Agenda',
                'parent' => 'Treinamentos',
                'icon' => 'far fa-calendar-alt',
              ],*/
          [
            'title' => 'Gestão de Entregas',
            'route' => null,
            'permission' => 'view.gestao.de.entregas',
            'description' => 'Gestão de Entregas',
            'parent' => null,
            'icon' => 'fas fa-truck',
          ],
              [
                'title' => 'Documentos',
                'route' => 'documents.index',
                'permission' => 'view.documentos',
                'description' => 'Documentos',
                'parent' => 'Gestão de Entregas',
                'icon' => 'far fa-file-alt',
              ],
              [
                'title' => 'Entregas',
                'route' => 'delivery-order.index',
                'permission' => 'view.ordem.entrega',
                'description' => 'Entregas',
                'parent' => 'Gestão de Entregas',
                'icon' => 'fas fa-boxes',
              ],

              [
                'title' => 'Faturamento',
                'route' => 'delivery_billing',
                'permission' => 'view.entrega.faturamento',
                'description' => 'Faturamento',
                'parent' => 'Gestão de Entregas',
                'icon' => 'fas fa-receipt',
              ],

          [
            'title' => 'Tarefas',
            'route' => null,
            'permission' => 'view.tarefas',
            'description' => 'Tarefas',
            'parent' => null,
            'icon' => 'fas fa-tasks',
          ],


          [
            'title' => 'Painel de Tarefas',
            'route' => 'boards',
            'permission' => 'view.painel.de.tarefas',
            'description' => 'Painel de Tarefas',
            'parent' => 'Tarefas',
            'icon' => 'feather icon-check-square',
          ],

          [
            'title' => 'Mapeamentos',
            'route' => 'mappings',
            'permission' => 'view.mapeamentos',
            'description' => 'Mapeamentos',
            'parent' => 'Tarefas',
            'icon' => 'far fa-clock',
          ],

          [
            'title' => 'Tarefas',
            'route' => 'tasks.index',
            'permission' => 'view.tarefas',
            'description' => 'Tarefas',
            'parent' => 'Tarefas',
            'icon' => 'fas fa-tasks',
          ],

          [
            'title' => 'Mural de Recados',
            'route' => 'message-board.index',
            'permission' => 'view.mural.de.recados',
            'description' => 'Mural',
            'parent' => null,
            'icon' => 'fas fa-bullhorn',
          ],

          [
            'title' => 'Chamados',
            'route' => 'tickets.index',
            'permission' => 'view.chamados',
            'description' => 'Lista de Chamados',
            'parent' => null,
            'icon' => 'fas fa-ticket-alt',
          ],

          [
            'title' => 'Agenda',
            'route' => 'schedules.index',
            'permission' => 'view.agenda',
            'description' => 'Agenda',
            'parent' => null,
            'icon' => 'far fa-calendar-alt',
          ],


          [
            'title' => 'Administrativo',
            'route' => null,
            'permission' => 'view.administrativo',
            'description' => 'Administrativo',
            'parent' => null,
            'icon' => 'fas fa-cogs',
          ],
            [
              'title' => 'Departamentos',
              'route' => 'departments.index',
              'permission' => 'view.departamentos',
              'description' => 'Departamentos',
              'parent' => 'Administrativo',
              'icon' => 'feather icon-briefcase',
            ],
            [
              'title' => 'Cargos',
              'route' => 'occupations.index',
              'permission' => 'view.cargos',
              'description' => 'Cargos',
              'parent' => 'Administrativo',
              'icon' => 'feather icon-home',
            ],
            [
              'title' => 'Usuários',
              'route' => 'users',
              'permission' => 'view.usuarios',
              'description' => 'Usuários',
              'parent' => 'Administrativo',
              'icon' => 'fas fa-user-friends',
            ],
            [
              'title' => 'Configurações',
              'route' => 'configurations.index',
              'permission' => 'view.configuracoes',
              'description' => 'Configurações',
              'parent' => 'Administrativo',
              'icon' => 'fas fa-cogs',
            ],

            [
              'title' => 'Tipos de Documentos',
              'route' => 'types.index',
              'permission' => 'view.tipo.de.documentos',
              'description' => 'Tipos de Documentos',
              'parent' => 'Administrativo',
              'icon' => 'far fa-file-alt',
            ],

            [
              'title' => 'Tipos de Recados',
              'route' => 'message-types.index',
              'permission' => 'view.tipos.de.recados',
              'description' => 'Tipos',
              'parent' => 'Administrativo',
              'icon' => 'fas fa-bullhorn',
            ],

            [
              'title' => 'Tipos de chamados',
              'route' => 'ticket-types.index',
              'permission' => 'view.tipo.de.chamados',
              'description' => 'Tipos de Chamados',
              'parent' => 'Administrativo',
              'icon' => 'fas fa-bullhorn',
            ],

        [
          'title' => 'Ramais e E-mails',
          'route' => 'contacts',
          'permission' => 'view.ramais.e.e.mails',
          'description' => 'Lista de Contatos',
          'parent' => null,
          'icon' => 'fas fa-phone-volume',
        ],

        [
          'title' => 'Arquivos',
          'route' => 'folders.index',
          'permission' => 'view.pastas',
          'description' => 'Arquivos',
          'parent' => null,
          'icon' => 'far fa-folder-open',
        ],

        [
          'title' => 'E-mail',
          'route' => 'emails.index',
          'permission' => 'view.email',
          'description' => 'E-mails',
          'parent' => null,
          'icon' => 'far fa-envelope',
        ],

        [
          'title' => 'Unidades',
          'route' => 'units.index',
          'permission' => 'view.unidades',
          'description' => 'Unidades',
          'parent' => 'Administrativo',
          'icon' => 'far fa-building',
        ],



        ];


        foreach ($itens as $key => $item) {

            $parent = $item['parent'];

            if(!empty($parent)) {

                $menu = Menu::where('title', $parent)->get()->first();

                if($menu) {
                    $item['parent'] = $menu->id;
                }

            }

            Menu::create($item);
        }
    }
}
