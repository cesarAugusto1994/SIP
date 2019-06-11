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
            'icon' => 'feather icon-home',
          ],
          [
            'title' => 'Treinamentos',
            'route' => '#',
            'permission' => 'view.treinamentos',
            'description' => 'Treinamentos',
            'parent' => null,
            'icon' => 'feather icon-home',
          ],
          [
            'title' => 'Cursos',
            'route' => 'courses.index',
            'permission' => 'view.cursos',
            'description' => 'Cursos',
            'parent' => 'Treinamentos',
            'icon' => 'feather icon-home',
          ],
          [
            'title' => 'Turmas',
            'route' => 'teams.index',
            'permission' => 'view.turmas',
            'description' => 'Turmas',
            'parent' => 'Treinamentos',
            'icon' => 'feather icon-home',
          ],
          [
            'title' => 'Agenda',
            'route' => 'teams.index',
            'permission' => 'view.agenda',
            'description' => 'Agenda',
            'parent' => 'Treinamentos',
            'icon' => 'feather icon-home',
          ],
          [
            'title' => 'Gestão de Entregas',
            'route' => null,
            'permission' => 'view.gestao.de.entregas',
            'description' => 'Gestão de Entregas',
            'parent' => null,
            'icon' => 'feather icon-home',
          ],
          [
            'title' => 'Documentos',
            'route' => 'documents.index',
            'permission' => 'view.documentos',
            'description' => 'Documentos',
            'parent' => 'Gestão de Entregas',
            'icon' => 'feather icon-home',
          ],
          [
            'title' => 'Entregas',
            'route' => 'delivery-order.index',
            'permission' => 'view.ordem.entrega',
            'description' => 'Entregas',
            'parent' => 'Gestão de Entregas',
            'icon' => 'feather icon-home',
          ],
          [
            'title' => 'Tipos de Documentos',
            'route' => 'types.index',
            'permission' => 'view.tipo.documento',
            'description' => 'Tipos de Documentos',
            'parent' => 'Gestão de Entregas',
            'icon' => 'feather icon-home',
          ],
          [
            'title' => 'Mural de Recados',
            'route' => null,
            'permission' => 'view.mural.de.recados',
            'description' => 'Mural de Recados',
            'parent' => null,
            'icon' => 'feather icon-home',
          ],
          [
            'title' => 'Mural',
            'route' => 'message-board.index',
            'permission' => 'view.mural',
            'description' => 'Mural',
            'parent' => 'Mural de Recados',
            'icon' => 'feather icon-home',
          ],

          [
            'title' => 'Tipos',
            'route' => 'message-types.index',
            'permission' => 'view.tipos.de.recados',
            'description' => 'Tipos',
            'parent' => 'Mural de Recados',
            'icon' => 'feather icon-home',
          ],
          [
            'title' => 'Administrativo',
            'route' => null,
            'permission' => 'view.administrativo',
            'description' => 'Administrativo',
            'parent' => null,
            'icon' => 'feather icon-home',
          ],
          [
            'title' => 'Departamentos',
            'route' => 'departments.index',
            'permission' => 'view.departamentos',
            'description' => 'Departamentos',
            'parent' => 'Administrativo',
            'icon' => 'feather icon-home',
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
            'icon' => 'feather icon-home',
          ],
          [
            'title' => 'Configurações',
            'route' => 'configurations.index',
            'permission' => 'view.configuracoes',
            'description' => 'Configurações',
            'parent' => 'Administrativo',
            'icon' => 'feather icon-home',
          ],
          [
            'title' => 'Chat',
            'route' => 'home',
            'permission' => 'view.chat',
            'description' => 'Chat',
            'parent' => null,
            'icon' => 'feather icon-home',
          ],
          [
            'title' => 'Chamados',
            'route' => 'home',
            'permission' => 'view.chamados',
            'description' => 'Chamados',
            'parent' => null,
            'icon' => 'feather icon-home',
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
