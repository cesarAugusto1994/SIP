<?php

use App\User;
use Illuminate\Database\Seeder;
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Models\Permission;
use App\Models\RoleDefaultPermissions;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Add Roles
         *
         */
        if (!Role::whereName('Administrador')->first()) {
            $adminRole = Role::create([
                'name'        => 'Administrador',
                'slug'        => 'administrador',
                'description' => 'Acesso de Administrador',
                'level'       => 5,
            ]);

            foreach (Permission::all() as $key => $permission) {
                RoleDefaultPermissions::create([
                  'role_id' => $adminRole->id,
                  'permission_id' => $permission->id
                ]);
            }

        }

        $roles = ['Sistema',
                  'Tecnologia da Informação',
                  'Atendimento',
                  'Técnico em Segurança do Trabalho',
                  'Coleta',
                  'Comercial',
                  'Marketing',
                  'Exames',
                  'Diretoria',
                  'Documentação',
                  'Recursos Humanos',
                  'Enfermagem',
                  'Financeiro',
                  'Fonoaudiologia',
                  'Administrativo',
                  'Treinamentos',
                  'Juridico',
                  'Laboratório',
                  'Psicologia',
                  'Expedição'];

        foreach ($roles as $key => $item) {

          if (Role::where('name', '=', $item)->first() === null) {
              $userRole = Role::create([
                  'name'        => $item,
                  'slug'        => str_slug($item, '.'),
                  'description' => 'Acesso de '. $item,
                  'level'       => 1,
              ]);

              $permissions = [5,9,10,11,12,13,14,16,42,43,44,99,100,104];

              foreach ($permissions as $key => $item) {
                  RoleDefaultPermissions::create([
                    'role_id' => $userRole->id,
                    'permission_id' => $item
                  ]);
              }

          }

        }

    }
}
