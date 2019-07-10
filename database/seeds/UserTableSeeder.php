<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Models\People;
use App\Models\RoleDefaultPermissions;
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Models\Permission;
use App\Models\Department;
use App\Models\Department\Occupation;
use App\Models\Unit;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::whereName('Admin')->first();
        $userRole = Role::whereName('User')->first();
        $permissions = Permission::pluck('id');

        $faker = Faker\Factory::create();

        // Seed test admin
        $seededAdminEmail = 'admin@provider-es.com.br';
        $user = User::where('email', '=', $seededAdminEmail)->first();
        if ($user === null) {

            $name = 'Administrador';

            $avatar = \Avatar::create($name)->toBase64();

            $unit = Unit::create([
              'name' => 'Vitória'
            ]);

            $department = Department::create([
              'name' => 'Tecnologia da Informação'
            ]);

            $occupation = Occupation::create([
              'name' => 'Administrador',
              'department_id' => $department->id
            ]);

            $person = People::create([
              'name' => 'Administrador',
              'department_id'=> $department->id,
              'unit_id'=> $unit->id,
              'occupation_id'=> $occupation->id,
              'birthday' => '1994-07-15',
              'cpf' => '12345678987'
            ]);

            $user = User::create([
              'nick'                           => 'admin',
              'email'                          => $seededAdminEmail,
              'password'                       => Hash::make('Provider@123'),
              'avatar' => $avatar,
              'do_task' => false,
              'person_id' => $person->id,
              'email_verified_at' => now(),
              'login_soc' => '',
              'password_soc' => '',
              'id_soc' => '',
              'api_token' => str_random(60)

            ]);

            //$user->api_token = $user->createToken('Provider')->accessToken;

            //$user->profile()->save($profile);
            $user->attachRole($adminRole);

            if($adminRole->id == 1) {
                $user->syncPermissions($permissions);
            }

            $user->save();
        }
/*
        $users = "
            adinuza.lopes@provider-es.com.br,
            aeliton.silva@provider-es.com.br,
            andre.tavares@provider-es.com.br,
            vinycius.alves@provider-es.com.br";
*/

        $users = array(
          	0 => array('Cargo' => 'Aprendiz', 'Unidade' => 'Vitória', 'Setor' => 'Aprendiz', 'Nome' => 'Jovem Aprendiz', 'Email' => 'jovem.aprendiz'),
          	1 => array('Cargo' => 'Arquivo', 'Unidade' => 'Vitória', 'Setor' => 'Arquivo', 'Nome' => 'Arquivo', 'Email' => 'arquivo'),
          	2 => array('Cargo' => 'Atendente', 'Unidade' => 'Vitória', 'Setor' => 'Atendimento', 'Nome' => 'Atendimento Cariacica', 'Email' => 'atendimento.cariacica'),
          	3 => array('Cargo' => 'Atendente', 'Unidade' => 'Serra', 'Setor' => 'Atendimento', 'Nome' => 'Atendimento Serra', 'Email' => 'atendimento.serra'),
          	4 => array('Cargo' => 'Atendente', 'Unidade' => 'Vila Velha Centro', 'Setor' => 'Atendimento', 'Nome' => 'Atendimento Vila Velha Centro', 'Email' => 'atendimento.vilavelha.centro'),
          	5 => array('Cargo' => 'Atendente', 'Unidade' => 'Vila Velha Ibes', 'Setor' => 'Atendimento', 'Nome' => 'Atendimento Vila Velha Ibes', 'Email' => 'atendimento.vilavelha.ibes'),
          	6 => array('Cargo' => 'Atendente', 'Unidade' => 'Vitória', 'Setor' => 'Atendimento', 'Nome' => 'Atendimento Vitória', 'Email' => 'atendimento.vitoria'),
          	7 => array('Cargo' => 'Atendente', 'Unidade' => 'Vitória', 'Setor' => 'Atendimento', 'Nome' => 'Denise Pereira', 'Email' => 'denise.pereira'),
          	8 => array('Cargo' => 'Atendente', 'Unidade' => 'Baixo Guandú', 'Setor' => 'Atendimento', 'Nome' => 'Atendimento Baixo Guandú', 'Email' => 'atendimento.baixoguando'),
          	9 => array('Cargo' => 'Administrativo', 'Unidade' => 'Baixo Guandú', 'Setor' => 'Atendimento', 'Nome' => 'Karina Barteli', 'Email' => 'karina.barteli'),
          	10 => array('Cargo' => 'Administrativo', 'Unidade' => 'Baixo Guandú', 'Setor' => 'Técnico', 'Nome' => 'Rodrigo Alcides', 'Email' => 'rodrigo.alcides'),
          	11 => array('Cargo' => 'Coleta', 'Unidade' => 'Cariacica', 'Setor' => 'Coleta', 'Nome' => 'Coleta Cariacica', 'Email' => 'coleta.cariacica'),
          	12 => array('Cargo' => 'Coleta', 'Unidade' => 'Serra', 'Setor' => 'Coleta', 'Nome' => 'Coleta Serra', 'Email' => 'coleta.serra'),
          	13 => array('Cargo' => 'Coleta', 'Unidade' => 'Vila Velha Ibes', 'Setor' => 'Coleta', 'Nome' => 'Coleta Vila Velha IBES', 'Email' => 'coleta.vilavelha.ibes'),
          	14 => array('Cargo' => 'Coleta', 'Unidade' => 'Vitória', 'Setor' => 'Coleta', 'Nome' => 'Coleta Vitória', 'Email' => 'coleta.vitoria'),
          	15 => array('Cargo' => 'Coleta', 'Unidade' => 'Vila Velha Centro', 'Setor' => 'Coleta', 'Nome' => 'Coleta Vila Velha Centro', 'Email' => 'coleta.vilavelha.centro'),
          	16 => array('Cargo' => 'Administrativo', 'Unidade' => 'Vitória', 'Setor' => 'Comercial', 'Nome' => 'Herlan Gonçalves', 'Email' => 'comercial'),
          	17 => array('Cargo' => 'Administrativo', 'Unidade' => 'Vitória', 'Setor' => 'Comercial', 'Nome' => 'Ricardo Castro', 'Email' => 'comercial2'),
          	18 => array('Cargo' => 'Aprendiz', 'Unidade' => 'Vitória', 'Setor' => 'Comercial', 'Nome' => 'Apoio', 'Email' => 'comercial3'),
          	20 => array('Cargo' => 'Administrativo', 'Unidade' => 'Vitória', 'Setor' => 'Marketing', 'Nome' => 'Marketing', 'Email' => 'marketing'),
          	21 => array('Cargo' => 'Administrativo', 'Unidade' => 'Vitória', 'Setor' => 'Exames', 'Nome' => 'Simone Coelho', 'Email' => 'simone.coelho'),
          	22 => array('Cargo' => 'Diretor', 'Unidade' => 'Vitória', 'Setor' => 'Diretoria', 'Nome' => 'Carlos César Sad', 'Email' => 'cesar.sad'),
          	23 => array('Cargo' => 'Diretor', 'Unidade' => 'Vitória', 'Setor' => 'Técnico', 'Nome' => 'Deyvd Soares', 'Email' => 'deyvd.soares'),
          	24 => array('Cargo' => 'Diretor', 'Unidade' => 'Vitória', 'Setor' => 'RH', 'Nome' => 'Wesley Damásio', 'Email' => 'wesley.damasio'),
          	25 => array('Cargo' => 'Enfermeiro', 'Unidade' => 'Vitória', 'Setor' => 'Enfermagem', 'Nome' => 'Cristinete Silva', 'Email' => 'cristinete.silva'),
          	26 => array('Cargo' => 'Enfermeiro', 'Unidade' => 'Vitória', 'Setor' => 'Enfermagem', 'Nome' => 'Ana Florentino', 'Email' => 'enfermagem.trabalho'),
          	27 => array('Cargo' => 'Enfermeiro', 'Unidade' => 'Cariacica', 'Setor' => 'Enfermagem', 'Nome' => 'Fernando Rodrigues', 'Email' => 'enfermagem.cariacica'),
          	28 => array('Cargo' => 'E-Social', 'Unidade' => 'Vitória', 'Setor' => 'Técnico', 'Nome' => 'Ariane Pina', 'Email' => 'ariane.pina'),
          	29 => array('Cargo' => 'E-Social', 'Unidade' => 'Vitória', 'Setor' => 'E-Social', 'Nome' => 'Sara Tavares', 'Email' => 'sara.tavares'),
          	30 => array('Cargo' => 'Administrativo', 'Unidade' => 'Vila Velha Centro', 'Setor' => 'Financeiro', 'Nome' => 'Larissa', 'Email' => 'financeiro2'),
          	31 => array('Cargo' => 'Credenciamento', 'Unidade' => 'Vitória', 'Setor' => 'Exames', 'Nome' => 'Karoline', 'Email' => 'credenciamento2'),
          	32 => array('Cargo' => 'Credenciamento', 'Unidade' => 'Vitória', 'Setor' => 'Exames', 'Nome' => 'Monarah', 'Email' => 'credenciamento3'),
          	33 => array('Cargo' => 'Credenciamento', 'Unidade' => 'Vitória', 'Setor' => 'Exames', 'Nome' => 'Gierke', 'Email' => 'credenciamento4'),
          	34 => array('Cargo' => 'Credenciamento', 'Unidade' => 'Vitória', 'Setor' => 'Exames', 'Nome' => 'Lucas', 'Email' => 'credenciamento5'),
          	35 => array('Cargo' => 'Expedição', 'Unidade' => 'Vitória', 'Setor' => 'Exames', 'Nome' => 'Stela', 'Email' => 'expedicao'),
          	36 => array('Cargo' => 'Liberação', 'Unidade' => 'Vitória', 'Setor' => 'Exames', 'Nome' => 'Débora', 'Email' => 'liberacao'),
          	37 => array('Cargo' => 'Liberação', 'Unidade' => 'Vitória', 'Setor' => 'Exames', 'Nome' => 'Nathiely', 'Email' => 'liberacao2'),
          	38 => array('Cargo' => 'Liberação', 'Unidade' => 'Vitória', 'Setor' => 'Exames', 'Nome' => 'Hevellyn', 'Email' => 'liberacao3'),
          	39 => array('Cargo' => 'Liberação', 'Unidade' => 'Vitória', 'Setor' => 'Exames', 'Nome' => 'Charles', 'Email' => 'liberacao4'),
          	40 => array('Cargo' => 'Liberação', 'Unidade' => 'Vitória', 'Setor' => 'Exames', 'Nome' => 'Alex Sander', 'Email' => 'liberacao5'),
          	41 => array('Cargo' => 'Triagem', 'Unidade' => 'Vitória', 'Setor' => 'Exames', 'Nome' => 'Paulo Vinicius', 'Email' => 'triagem'),
          	42 => array('Cargo' => 'UMAP', 'Unidade' => 'Vitória', 'Setor' => 'Exames', 'Nome' => 'Thais', 'Email' => 'umap'),
          	43 => array('Cargo' => 'Triagem', 'Unidade' => 'Vitória', 'Setor' => 'Exames', 'Nome' => 'Ana Carolina', 'Email' => 'ana.carolina'),
          	44 => array('Cargo' => 'Administrativo', 'Unidade' => 'Vitória', 'Setor' => 'Comercial', 'Nome' => 'Carlos Eduardo', 'Email' => 'carlos.eduardo'),
          	45 => array('Cargo' => 'Atendente', 'Unidade' => 'Vitória', 'Setor' => 'Atendimento', 'Nome' => 'Joseth Cardozo', 'Email' => 'joseth.cardoso'),
          	46 => array('Cargo' => 'Administrativo', 'Unidade' => 'Vila Velha Centro', 'Setor' => 'Financeiro', 'Nome' => 'Mariana Pazolini', 'Email' => 'mariana.pazolini'),
          	47 => array('Cargo' => 'Administrativo', 'Unidade' => 'Vila Velha Centro', 'Setor' => 'Financeiro', 'Nome' => 'Laryssa', 'Email' => 'compras'),
          	48 => array('Cargo' => 'Administrativo', 'Unidade' => 'Vila Velha Centro', 'Setor' => 'Financeiro', 'Nome' => 'Roberta', 'Email' => 'faturamento'),
          	50 => array('Cargo' => 'Administrativo', 'Unidade' => 'Vila Velha Centro', 'Setor' => 'Financeiro', 'Nome' => 'Viviane Neves', 'Email' => 'cobranca'),
          	51 => array('Cargo' => 'Fonoaudiólogo', 'Unidade' => 'Cariacica', 'Setor' => 'Fono', 'Nome' => 'Fono Cariacica', 'Email' => 'bianca.kaiser'),
          	52 => array('Cargo' => 'Fonoaudiólogo', 'Unidade' => 'Cariacica', 'Setor' => 'Fono', 'Nome' => 'Gleice', 'Email' => 'fono.caricacica'),
          	53 => array('Cargo' => 'Fonoaudiólogo', 'Unidade' => 'Serra', 'Setor' => 'Fono', 'Nome' => 'Fono Serra', 'Email' => 'fono.serra'),
          	54 => array('Cargo' => 'Fonoaudiólogo', 'Unidade' => 'Vila Velha Ibes', 'Setor' => 'Fono', 'Nome' => 'Fono Vila Velha IBES', 'Email' => 'fono.vilavelha.ibes'),
          	55 => array('Cargo' => 'Fonoaudiólogo', 'Unidade' => 'Vitória', 'Setor' => 'Fono', 'Nome' => 'Fono Vtória', 'Email' => 'fono.vitoria'),
          	56 => array('Cargo' => 'Fonoaudiólogo', 'Unidade' => 'Vitória', 'Setor' => 'Fono', 'Nome' => 'Fono Vitória', 'Email' => 'fono2.vitoria'),
          	58 => array('Cargo' => 'Administrativo', 'Unidade' => 'Vila Velha Ibes', 'Setor' => 'Administrativo', 'Nome' => 'Mariana Coelho', 'Email' => 'mariana.coelho'),
          	59 => array('Cargo' => 'Administrativo', 'Unidade' => 'Vila Velha Ibes', 'Setor' => 'Administrativo', 'Nome' => 'Paola neves', 'Email' => 'paola.neves'),
          	60 => array('Cargo' => 'Instrutor de Treinamentos', 'Unidade' => 'Vitória', 'Setor' => 'Treinamentos', 'Nome' => 'Aeliton Silva', 'Email' => 'aeliton.silva'),

          	61 => array('Cargo' => 'Advogado', 'Unidade' => 'Vitória', 'Setor' => 'Juridico', 'Nome' => 'Andréia Botelho', 'Email' => 'juridico'),
          	62 => array('Cargo' => 'Administrativo', 'Unidade' => 'Vitória', 'Setor' => 'Laboratório', 'Nome' => 'Daniele', 'Email' => 'laboratorio'),
          	63 => array('Cargo' => 'Psicologo', 'Unidade' => 'Vitória', 'Setor' => 'Psicologia', 'Nome' => 'Psicologia', 'Email' => 'psicologia'),
          	64 => array('Cargo' => 'Psicologo', 'Unidade' => 'Vitória', 'Setor' => 'Psicologia', 'Nome' => 'Flávia Cypreste', 'Email' => 'flavia.cypreste'),
          	65 => array('Cargo' => 'Administrativo', 'Unidade' => 'Vitória', 'Setor' => 'RH', 'Nome' => 'Edilson Lima', 'Email' => 'dp'),
          	66 => array('Cargo' => 'Administrativo', 'Unidade' => 'Vitória', 'Setor' => 'RH', 'Nome' => 'Luciana Rocha', 'Email' => 'dp2'),
          	68 => array('Cargo' => 'Técnico', 'Unidade' => 'Vitória', 'Setor' => 'Técnico', 'Nome' => 'Diego Souza', 'Email' => 'diego.souza'),
          	69 => array('Cargo' => 'Técnico', 'Unidade' => 'Vitória', 'Setor' => 'Técnico', 'Nome' => 'Fellipe Freitas', 'Email' => 'fellipe.freitas'),
          	70 => array('Cargo' => 'Técnico', 'Unidade' => 'Vitória', 'Setor' => 'Técnico', 'Nome' => 'Geovani Charpinel', 'Email' => 'geovani.charpinel'),
          	71 => array('Cargo' => 'Técnico', 'Unidade' => 'Serra', 'Setor' => 'Técnico', 'Nome' => 'Gizelle Rodrigues', 'Email' => 'gizelle.rodrigues'),
          	72 => array('Cargo' => 'Técnico', 'Unidade' => 'Vitória', 'Setor' => 'Técnico', 'Nome' => 'Leonardo Araújp', 'Email' => 'leonardo.araujo'),
          	73 => array('Cargo' => 'Técnico', 'Unidade' => 'Vitória', 'Setor' => 'Técnico', 'Nome' => 'Nadine', 'Email' => 'nadine.lodi'),
          	74 => array('Cargo' => 'Técnico', 'Unidade' => 'Serra', 'Setor' => 'Técnico', 'Nome' => 'Rebeca Senara', 'Email' => 'rebeca.senara'),
          	75 => array('Cargo' => 'Técnico', 'Unidade' => 'Vitória', 'Setor' => 'Técnico', 'Nome' => 'Dávila Souza', 'Email' => 'davila.souza'),
          	76 => array('Cargo' => 'Técnico', 'Unidade' => 'Vitória', 'Setor' => 'Técnico', 'Nome' => 'Emyle Almeida', 'Email' => 'emyle.almeida'),
          	77 => array('Cargo' => 'Técnico', 'Unidade' => 'Vitória', 'Setor' => 'Técnico', 'Nome' => 'Felipe Batista', 'Email' => 'felipe.batista'),
          	78 => array('Cargo' => 'Técnico', 'Unidade' => 'Vitória', 'Setor' => 'Técnico', 'Nome' => 'Igor Bianchi', 'Email' => 'igor.bianchi'),
          	79 => array('Cargo' => 'Técnico', 'Unidade' => 'Vitória', 'Setor' => 'Técnico', 'Nome' => 'Beatriz Crespo', 'Email' => 'beatrz.crespo'),
          	80 => array('Cargo' => 'Técnico', 'Unidade' => 'Vitória', 'Setor' => 'Técnico', 'Nome' => 'Débora Monteiro', 'Email' => 'debora.monteiro'),
          	81 => array('Cargo' => 'Técnico', 'Unidade' => 'Vitória', 'Setor' => 'Técnico', 'Nome' => 'Ingrid Rubenich', 'Email' => 'ingrid.rubenich'),
          	82 => array('Cargo' => 'Técnico', 'Unidade' => 'Vitória', 'Setor' => 'Técnico', 'Nome' => 'Bruna Oliveira', 'Email' => 'brunna.oliveira'),
          	83 => array('Cargo' => 'Técnico', 'Unidade' => 'Vitória', 'Setor' => 'Técnico', 'Nome' => 'Karla Marques', 'Email' => 'karla.marques'),
          	84 => array('Cargo' => 'Técnico', 'Unidade' => 'Vitória', 'Setor' => 'Técnico', 'Nome' => 'Amanda Rodrigues', 'Email' => 'amanda.rodrigues'),
          	85 => array('Cargo' => 'Técnico', 'Unidade' => 'Vitória', 'Setor' => 'Técnico', 'Nome' => 'Júlio Félix', 'Email' => 'julio.felix'),
          	86 => array('Cargo' => 'Técnico', 'Unidade' => 'Vitória', 'Setor' => 'Técnico', 'Nome' => 'Igor Rocha', 'Email' => 'igor.rocha'),
          	88 => array('Cargo' => 'Suporte SOC', 'Unidade' => 'Vitória', 'Setor' => 'Tecnologia da Informação', 'Nome' => 'Ely Reis', 'Email' => 'ely.reis'),
          	90 => array('Cargo' => 'Infraestrutura', 'Unidade' => 'Vitória', 'Setor' => 'Tecnologia da Informação', 'Nome' => 'Vinycius Alves', 'Email' => 'vinycius.alves'),

            90 => array('Cargo' => 'Infraestrutura', 'Unidade' => 'Vitória', 'Setor' => 'Tecnologia da Informação', 'Nome' => 'André Tavares', 'Email' => 'andre.tavares'),
            90 => array('Cargo' => 'Infraestrutura', 'Unidade' => 'Vitória', 'Setor' => 'Tecnologia da Informação', 'Nome' => 'Arthur Gonçalves', 'Email' => 'arthur.goncalves'),

            91 => array('Cargo' => 'Administrativo', 'Unidade' => 'Vitória', 'Setor' => 'Treinamentos', 'Nome' => 'Sabrina Oliveira', 'Email' => 'treinamentos'),
          );

        //$users = explode(',', $users);

        foreach ($users as $key => $user) {

          //$faker = Faker\Factory::create();

          $userMail = User::where('email', '=', trim($user['Email']))->first();
          if ($userMail === null) {

              //$uName = str_replace(['@provider-es.com.br', '.'], ['', ' '], trim($userEmail));
              //$login= str_replace(['@provider-es.com.br', ' '], ['', '.'], trim($userEmail));
              //$uName = ucwords($uName);

              //$name = $uName;

              echo 'creating user '. $user['Nome'] . PHP_EOL;

              $avatar = \Avatar::create($user['Nome'])->toBase64();

              $hasDepto = Department::where('name', $user['Setor'])->first();

              if(!$hasDepto) {
                  $department = Department::create([
                    'name' => $user['Setor']
                  ]);
              } else {
                $department = $hasDepto;
              }

              $hasOccupation = Occupation::where('name', $user['Cargo'])->where('department_id', $user['Setor'])->first();

              if(!$hasOccupation) {
                  $occupation = Occupation::create([
                    'name' => $user['Cargo'],
                    'department_id' => $department->id
                  ]);
              } else {
                $occupation = $hasOccupation;
              }

              $hasUnit = Unit::where('name', $user['Unidade'])->first();

              if(!$hasUnit) {
                  $unit = Unit::create([
                    'name' => $user['Unidade']
                  ]);
              } else {
                $unit = $hasUnit;
              }

              $person = People::create([
                'name' => $user['Nome'],
                'birthday' => '',
                'department_id'=> $department->id,
                'unit_id'=> $unit->id,
                'occupation_id'=> $occupation->id,
                'cpf' => ''
              ]);

              $emailFormated = trim($user['Email']) . '@provider-es.com.br';

              $user = User::create([
                'nick'                           => $user['Email'],
                'email'                          => $emailFormated,
                'password'                       => Hash::make('Provider@123'),
                'avatar' => $avatar,
                'person_id' => $person->id,
                'email_verified_at' => now(),
                'login_soc' => '',
                'password_soc' => '',
                'id_soc' => '',
                'api_token' => str_random(60)

              ]);

              //$user->api_token = $user->createToken('Provider')->accessToken;

              //$user->profile()->save(new Profile());
              $user->attachRole($userRole);

              if($adminRole->id == 1) {
                  $user->syncPermissions($permissions);
              }

              $permissionForRole = RoleDefaultPermissions::where('role_id', $userRole->id)
              ->pluck('permission_id');

              $user->syncPermissions($permissionForRole);

              $user->save();
          }
          // code...
        }

    }
}
