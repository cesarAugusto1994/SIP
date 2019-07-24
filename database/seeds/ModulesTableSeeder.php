<?php

use Illuminate\Database\Seeder;
use App\Models\Module;

class ModulesTableSeeder extends Seeder
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
            'name' => 'Módulos',
            'slug' => str_slug('Modulos'),
            'description' => 'Módulos',
            'parent' => null,
          ],
          [
            'name' => 'Painel Principal',
            'slug' => str_slug('Painel Principal'),
            'description' => 'Painel Principal',
            'parent' => str_slug('Modulos'),
          ],
          [
            'name' => 'Gestão de Entregas',
            'slug' => str_slug('Gestao de Entregas'),
            'description' => 'Gestão de Entregas',
            'parent' => str_slug('Modulos'),
          ],
          [
            'name' => 'Gestão de Tarefas',
            'slug' => str_slug('Gestao de Tarefas'),
            'description' => 'Gestão de Tarefas',
            'parent' => str_slug('Modulos'),
          ],
          [
            'name' => 'Chat',
            'slug' => str_slug('Chat'),
            'description' => 'Chat',
            'parent' => str_slug('Modulos'),
          ],



          [
            'name' => 'Chamados',
            'slug' => str_slug('Chamados'),
            'description' => 'Chamados',
            'parent' => str_slug('Modulos'),
          ],
/*
          [
            'name' => 'Treinamentos',
            'slug' => str_slug('Treinamentos'),
            'description' => 'Gestão de Treinamentos',
            'parent' => str_slug('Modulos'),
          ],
          */
          [
            'name' => 'Mural de Recados',
            'slug' => str_slug('Mural de Recados'),
            'description' => 'Mural de Recados',
            'parent' => str_slug('Modulos'),
          ],
          [
            'name' => 'Administrativo',
            'slug' => str_slug('Administrativo'),
            'description' => 'Administrativo',
            'parent' => str_slug('Modulos'),
          ],
          [
            'name' => 'Clientes',
            'slug' => str_slug('Clientes'),
            'description' => 'Clientes',
            'parent' => str_slug('Modulos'),
          ],
          [
            'name' => 'Cliente Endereços',
            'slug' => str_slug('Enderecos'),
            'description' => 'Cliente Enderecos',
            'parent' => str_slug('Clientes'),
          ],

          [
            'name' => 'Cliente Funcionários',
            'slug' => str_slug('Funcionarios'),
            'description' => 'Cliente Funcionários',
            'parent' => str_slug('Clientes'),
          ],

          [
            'name' => 'Documentos',
            'slug' => str_slug('Documentos'),
            'description' => 'Documentos',
            'parent' => str_slug('Gestao de Entregas'),
          ],
          [
            'name' => 'Ordem Entrega',
            'slug' => str_slug('Ordem Entrega'),
            'description' => 'Ordem Entrega',
            'parent' => str_slug('Gestao de Entregas'),
          ],

          [
            'name' => 'Tarefas',
            'slug' => str_slug('Tarefas'),
            'description' => 'Tarefas',
            'parent' => str_slug('Gestao de Tarefas'),
          ],

          [
            'name' => 'Processos',
            'slug' => str_slug('Processos'),
            'description' => 'Processos',
            'parent' => str_slug('Gestao de Tarefas'),
          ],
/*
          [
            'name' => 'Cursos',
            'slug' => str_slug('Cursos'),
            'description' => 'Cursos',
            'parent' => str_slug('Treinamentos'),
          ],

          [
            'name' => 'Turmas',
            'slug' => str_slug('Turmas'),
            'description' => 'Turmas',
            'parent' => str_slug('Treinamentos'),
          ],
          [
            'name' => 'Agenda',
            'slug' => str_slug('Agenda'),
            'description' => 'Agenda',
            'parent' => str_slug('Treinamentos'),
          ],
*/

          [
            'name' => 'Departamentos',
            'slug' => str_slug('Departamentos'),
            'description' => 'Departamentos',
            'parent' => str_slug('Administrativo'),
          ],
          [
            'name' => 'Cargos',
            'slug' => str_slug('Cargos'),
            'description' => 'Cargos',
            'parent' => str_slug('Administrativo'),
          ],
          [
            'name' => 'Usuarios',
            'slug' => str_slug('Usuarios'),
            'description' => 'Usuarios',
            'parent' => str_slug('Administrativo'),
          ],

          [
            'name' => 'Tipos de Recados',
            'slug' => str_slug('Tipos de Recados'),
            'description' => 'Tipos de Recados',
            'parent' => str_slug('Administrativo'),
          ],

          [
            'name' => 'Tipo de Chamados',
            'slug' => str_slug('Tipo de Chamados'),
            'description' => 'Tipo de Chamados',
            'parent' => str_slug('Administrativo'),
          ],

          [
            'name' => 'Privilégios',
            'slug' => str_slug('Privilegios'),
            'description' => 'Privilégios',
            'parent' => str_slug('Administrativo'),
          ],

          [
            'name' => 'Permissões',
            'slug' => str_slug('Permissoes'),
            'description' => 'Permissões',
            'parent' => str_slug('Administrativo'),
          ],

          [
            'name' => 'Ramais e E-mails',
            'slug' => str_slug('Ramais e E-mails'),
            'description' => 'Ramais e E-mails',
            'parent' => str_slug('Modulos'),
          ],

          [
            'name' => 'Pastas',
            'slug' => str_slug('Pastas'),
            'description' => 'Pastas',
            'parent' => str_slug('Modulos'),
          ],

          [
            'name' => 'Arquivos',
            'slug' => str_slug('Arquivos'),
            'description' => 'Arquivos',
            'parent' => str_slug('Modulos'),
          ],

          [
            'name' => 'Email',
            'slug' => str_slug('Email'),
            'description' => 'Email',
            'parent' => str_slug('Modulos'),
          ],

          [
            'name' => 'Unidades',
            'slug' => str_slug('Unidades'),
            'description' => 'Unidades',
            'parent' => str_slug('Administrativo'),
          ],

        ];

        foreach ($itens as $key => $value) {

            if($value['parent']) {
                $module = Module::where('slug', $value['parent'])->get()->first();
                if($module) {
                  $value['parent'] = $module->id;
                }
            }

            Module::create($value);
        }
    }
}
