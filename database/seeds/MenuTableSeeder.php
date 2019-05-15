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
          ],

          [
            'title' => 'Clientes',
            'route' => 'clients.index',
            'permission' => 'view.clientes',
            'description' => 'Clientes',
            'parent' => null,
          ],
          [
            'title' => 'Treinamentos',
            'route' => '#',
            'permission' => 'view.treinamentos',
            'description' => 'Treinamentos',
            'parent' => null,
          ],
          [
            'title' => 'Cursos',
            'route' => 'courses.index',
            'permission' => 'view.cursos',
            'description' => 'Cursos',
            'parent' => 'Treinamentos',
          ],
          [
            'title' => 'Turmas',
            'route' => 'teams.index',
            'permission' => 'view.turmas',
            'description' => 'Turmas',
            'parent' => 'Treinamentos',
          ],
          [
            'title' => 'Agenda',
            'route' => 'teams.index',
            'permission' => 'view.agenda',
            'description' => 'Agenda',
            'parent' => 'Treinamentos',
          ],
          [
            'title' => 'Gestão de Entregas',
            'route' => null,
            'permission' => 'view.gestao.de.entregas',
            'description' => 'Gestão de Entregas',
            'parent' => null,
          ],
          [
            'title' => 'Documentos',
            'route' => 'documents.index',
            'permission' => 'view.documentos',
            'description' => 'Documentos',
            'parent' => 'Gestão de Entregas',
          ],
          [
            'title' => 'Entregas',
            'route' => 'delivery-order.index',
            'permission' => 'view.ordem.entrega',
            'description' => 'Entregas',
            'parent' => 'Gestão de Entregas',
          ],
          [
            'title' => 'Tipos de Documentos',
            'route' => 'types.index',
            'permission' => 'view.tipo.documento',
            'description' => 'Tipos de Documentos',
            'parent' => 'Gestão de Entregas',
          ],
          [
            'title' => 'Mural de Recados',
            'route' => null,
            'permission' => 'view.mural.de.recados',
            'description' => 'Mural de Recados',
            'parent' => null,
          ],
          [
            'title' => 'Mural',
            'route' => 'message-board.index',
            'permission' => 'view.mural',
            'description' => 'Mural',
            'parent' => 'Mural de Recados',
          ],

          [
            'title' => 'Tipos',
            'route' => 'message-types.index',
            'permission' => 'view.tipos.de.recados',
            'description' => 'Tipos',
            'parent' => 'Mural de Recados',
          ],
          [
            'title' => 'Administrativo',
            'route' => null,
            'permission' => 'view.administrativo',
            'description' => 'Administrativo',
            'parent' => null,
          ],
          [
            'title' => 'Departamentos',
            'route' => 'departments',
            'permission' => 'view.departamentos',
            'description' => 'Departamentos',
            'parent' => 'Administrativo',
          ],
          [
            'title' => 'Cargos',
            'route' => 'occupations.index',
            'permission' => 'view.cargos',
            'description' => 'Cargos',
            'parent' => 'Administrativo',
          ],
          [
            'title' => 'Usuários',
            'route' => 'users',
            'permission' => 'view.usuarios',
            'description' => 'Usuários',
            'parent' => 'Administrativo',
          ],
          [
            'title' => 'Privilégios',
            'route' => 'roles.index',
            'permission' => 'view.privilegios',
            'description' => 'Privilégios',
            'parent' => 'Administrativo',
          ],
          [
            'title' => 'Configurações',
            'route' => 'configurations.index',
            'permission' => 'view.configuracoes',
            'description' => 'Configurações',
            'parent' => 'Administrativo',
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
