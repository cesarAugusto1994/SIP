<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Models\People;
use App\Models\RoleDefaultPermissions;
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Models\Permission;
use App\Models\Department;

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
        $seededAdminEmail = 'cesar.sousa@provider-es.com.br';
        $user = User::where('email', '=', $seededAdminEmail)->first();
        if ($user === null) {

            $name = 'Cesar Augusto Sousa';

            $avatar = \Avatar::create($name)->toBase64();

            $person = People::create([
              'name' => 'Cesar Sousa',
              'department_id'=> 5,
              'occupation_id'=> 1,
              'birthday' => '1994-07-19',
              'cpf' => '12345678987'
            ]);

            $user = User::create([
              'nick'                           => 'cesar.sousa',
              'email'                          => $seededAdminEmail,
              'password'                       => Hash::make('123123'),
              'avatar' => $avatar,
              'do_task' => false,
              'person_id' => $person->id,
              'email_verified_at' => now(),
              'login_soc' => 'cesar.sousa',
              'password_soc' => 'cesar1507',
              'id_soc' => '6662',
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
          	0 => array('Setor' => 'Aprendiz', 'Nome' => 'Jovem Aprendiz', 'Email' => 'jovem.aprendiz'),
          	1 => array('Setor' => 'Arquivo', 'Nome' => 'Arquivo', 'Email' => 'arquivo'),
          	2 => array('Setor' => 'Atendimento', 'Nome' => 'Atendimento Cariacica', 'Email' => 'atendimento.cariacica'),
          	3 => array('Setor' => 'Atendimento', 'Nome' => 'Atendimento Serra', 'Email' => 'atendimento.serra'),
          	4 => array('Setor' => 'Atendimento', 'Nome' => 'Atendimento Vila Velha Centro', 'Email' => 'atendimento.vilavelha.centro'),
          	5 => array('Setor' => 'Atendimento', 'Nome' => 'Atendimento Vila Velha Ibes', 'Email' => 'atendimento.vilavelha.ibes'),
          	6 => array('Setor' => 'Atendimento', 'Nome' => 'Atendimento Vitória', 'Email' => 'atendimento.vitoria'),
          	7 => array('Setor' => 'Atendimento', 'Nome' => 'Denise Pereira', 'Email' => 'denise.pereira'),
          	8 => array('Setor' => 'Atendimento', 'Nome' => 'Atendimento Baixo Guandú', 'Email' => 'atendimento.baixoguando'),
          	9 => array('Setor' => 'Baixo Guandú', 'Nome' => 'Karina Barteli', 'Email' => 'karina.barteli'),
          	10 => array('Setor' => 'Baixo Guandú', 'Nome' => 'Rodrigo Alcides', 'Email' => 'rodrigo.alcides'),
          	11 => array('Setor' => 'Coleta', 'Nome' => 'Coleta Cariacica', 'Email' => 'coleta.cariacica'),
          	12 => array('Setor' => 'Coleta', 'Nome' => 'Coleta Serra', 'Email' => 'coleta.serra'),
          	13 => array('Setor' => 'Coleta', 'Nome' => 'Coleta Vila Velha IBES', 'Email' => 'coleta.vilavelha.ibes'),
          	14 => array('Setor' => 'Coleta', 'Nome' => 'Coleta Vitória', 'Email' => 'coleta.vitoria'),
          	15 => array('Setor' => 'Coleta', 'Nome' => 'Coleta Vila Velha Centro', 'Email' => 'coleta.vilavelha.centro'),
          	16 => array('Setor' => 'Comercial', 'Nome' => 'Herlan Gonçalves', 'Email' => 'comercial'),
          	17 => array('Setor' => 'Comercial', 'Nome' => 'Ricardo Castro', 'Email' => 'comercial2'),
          	18 => array('Setor' => 'Comercial', 'Nome' => 'Apoio', 'Email' => 'comercial3'),
          	19 => array('Setor' => 'Comercial', 'Nome' => 'Gestçao Contratos', 'Email' => 'gestao.contratos'),
          	20 => array('Setor' => 'Comercial', 'Nome' => 'Marketing', 'Email' => 'marketing'),
          	21 => array('Setor' => 'Exames', 'Nome' => 'Simone Coelho', 'Email' => 'simone.coelho'),
          	22 => array('Setor' => 'Diretor', 'Nome' => 'Carlos César Sad', 'Email' => 'cesar.sad'),
          	23 => array('Setor' => 'Técnico', 'Nome' => 'Deyvd Soares', 'Email' => 'deyvd.soares'),
          	24 => array('Setor' => 'RH', 'Nome' => 'Wesley Damásio', 'Email' => 'wesley.damasio'),
          	25 => array('Setor' => 'Enfermeiro', 'Nome' => 'Cristinete Silva', 'Email' => 'cristinete.silva'),
          	26 => array('Setor' => 'Enfermeiro', 'Nome' => 'Ana Florentino', 'Email' => 'enfermagem.trabalho'),
          	27 => array('Setor' => 'Enfermeiro Cariacica', 'Nome' => 'Fernando Rodrigues', 'Email' => 'enfermagem.cariacica'),
          	28 => array('Setor' => 'E-Social', 'Nome' => 'Ariane Pina', 'Email' => 'ariane.pina'),
          	29 => array('Setor' => 'E-Social', 'Nome' => 'Sara Tavares', 'Email' => 'sara.tavares'),
          	30 => array('Setor' => 'Financeiro', 'Nome' => 'Larissa', 'Email' => 'financeiro2'),
          	31 => array('Setor' => 'Exames', 'Nome' => 'Karoline', 'Email' => 'credenciamento2'),
          	32 => array('Setor' => 'Exames', 'Nome' => 'Monarah', 'Email' => 'credenciamento3'),
          	33 => array('Setor' => 'Exames', 'Nome' => 'Gierke', 'Email' => 'credenciamento4'),
          	34 => array('Setor' => 'Exames', 'Nome' => 'Lucas', 'Email' => 'credenciamento5'),
          	35 => array('Setor' => 'Exames', 'Nome' => 'Stela', 'Email' => 'expedicao'),
          	36 => array('Setor' => 'Exames', 'Nome' => 'Débora', 'Email' => 'liberacao'),
          	37 => array('Setor' => 'Exames', 'Nome' => 'Nathiely', 'Email' => 'liberacao2'),
          	38 => array('Setor' => 'Exames', 'Nome' => 'Hevellyn', 'Email' => 'liberacao3'),
          	39 => array('Setor' => 'Exames', 'Nome' => 'Charles', 'Email' => 'liberacao4'),
          	40 => array('Setor' => 'Exames', 'Nome' => 'Alex Sander', 'Email' => 'liberacao5'),
          	41 => array('Setor' => 'Exames', 'Nome' => 'Paulo Vinicius', 'Email' => 'triagem'),
          	42 => array('Setor' => 'Exames', 'Nome' => 'Thais', 'Email' => 'umap'),
          	43 => array('Setor' => 'Exames', 'Nome' => 'Ana Carolina', 'Email' => 'ana.carolina'),
          	44 => array('Setor' => 'Comercial', 'Nome' => 'Carlos Eduardo', 'Email' => 'carlos.eduardo'),
          	45 => array('Setor' => 'Atendimento', 'Nome' => 'Joseth Cardozo', 'Email' => 'joseth.cardoso'),
          	46 => array('Setor' => 'Financeiro', 'Nome' => 'Mariana Pazolini', 'Email' => 'mariana.pazolini'),
          	47 => array('Setor' => 'Financeiro', 'Nome' => 'Laryssa', 'Email' => 'compras'),
          	48 => array('Setor' => 'Financeiro', 'Nome' => 'Roberta', 'Email' => 'faturamento'),
          	49 => array('Setor' => 'Financeiro', 'Nome' => 'Paulo', 'Email' => 'financeiro'),
          	50 => array('Setor' => 'Financeiro', 'Nome' => 'Viviane Neves', 'Email' => 'cobranca'),
          	51 => array('Setor' => 'Fono', 'Nome' => 'Fono Cariacica', 'Email' => 'bianca.kaiser'),
          	52 => array('Setor' => 'Fono', 'Nome' => 'Gleice', 'Email' => 'fono.caricacica'),
          	53 => array('Setor' => 'Fono', 'Nome' => 'Fono Serra', 'Email' => 'fono.serra'),
          	54 => array('Setor' => 'Fono', 'Nome' => 'Fono Vila Velha IBES', 'Email' => 'fono.vilavelha.ibes'),
          	55 => array('Setor' => 'Fono', 'Nome' => 'Fono Vtória', 'Email' => 'fono.vitoria'),
          	56 => array('Setor' => 'Fono', 'Nome' => 'Fono Vitória', 'Email' => 'fono2.vitoria'),
          	58 => array('Setor' => 'IBES', 'Nome' => 'Mariana Coelho', 'Email' => 'mariana.coelho'),
          	59 => array('Setor' => 'IBES', 'Nome' => 'Paola neves', 'Email' => 'paola.neves'),
          	60 => array('Setor' => 'Instrutor Treinamentos', 'Nome' => 'Aeliton Silva', 'Email' => 'aeliton.silva'),
          	61 => array('Setor' => 'Juridico', 'Nome' => 'Perícias', 'Email' => 'juridico'),
          	62 => array('Setor' => 'Laboratório', 'Nome' => 'Daniele', 'Email' => 'laboratorio'),
          	63 => array('Setor' => 'Psicologia', 'Nome' => 'Psicologia', 'Email' => 'psicologia'),
          	64 => array('Setor' => 'Psicologo', 'Nome' => 'Flávia Cypreste', 'Email' => 'flavia.cypreste'),
          	65 => array('Setor' => 'RH', 'Nome' => 'Edilson Lima', 'Email' => 'dp'),
          	66 => array('Setor' => 'RH', 'Nome' => 'Luciana Rocha', 'Email' => 'dp2'),
          	67 => array('Setor' => 'RH', 'Nome' => 'Curriculos', 'Email' => 'curriculos'),
          	68 => array('Setor' => 'Técnico', 'Nome' => 'Diego Souza', 'Email' => 'diego.souza'),
          	69 => array('Setor' => 'Técnico', 'Nome' => 'Fellipe Freitas', 'Email' => 'fellipe.freitas'),
          	70 => array('Setor' => 'Técnico', 'Nome' => 'Geovani Charpinel', 'Email' => 'geovani.charpinel'),
          	71 => array('Setor' => 'Técnico', 'Nome' => 'Gizelle Rodrigues', 'Email' => 'gizelle.rodrigues'),
          	72 => array('Setor' => 'Técnico', 'Nome' => 'Leonardo Araújp', 'Email' => 'leonardo.araujo'),
          	73 => array('Setor' => 'Técnico', 'Nome' => 'Nadine', 'Email' => 'nadine.lodi'),
          	74 => array('Setor' => 'Técnico', 'Nome' => 'Rebeca Senara', 'Email' => 'rebeca.senara'),
          	75 => array('Setor' => 'Técnico', 'Nome' => 'Dávila Souza', 'Email' => 'davila.souza'),
          	76 => array('Setor' => 'Técnico', 'Nome' => 'Emyli Almeida', 'Email' => 'emyle.almeida'),
          	77 => array('Setor' => 'Técnico', 'Nome' => 'Felipe Batista', 'Email' => 'felipe.batista'),
          	78 => array('Setor' => 'Técnico', 'Nome' => 'Igor Bianchi', 'Email' => 'igor.bianchi'),
          	79 => array('Setor' => 'Técnico', 'Nome' => 'Beatriz Crespo', 'Email' => 'beatrz.crespo'),
          	80 => array('Setor' => 'Técnico', 'Nome' => 'Débora Monteiro', 'Email' => 'debora.monteiro'),
          	81 => array('Setor' => 'Técnico', 'Nome' => 'Ingrid Rubenich', 'Email' => 'ingrid.rubenich'),
          	82 => array('Setor' => 'Técnico', 'Nome' => 'Bruna Oliveira', 'Email' => 'brunna.oliveira'),
          	83 => array('Setor' => 'Técnico', 'Nome' => 'Karla Marques', 'Email' => 'karla.marques'),
          	84 => array('Setor' => 'Técnico', 'Nome' => 'Amanda Rodrigues', 'Email' => 'amanda.rodrigues'),
          	85 => array('Setor' => 'Técnico', 'Nome' => 'Júlio Félix', 'Email' => 'julio.felix'),
          	86 => array('Setor' => 'Técnico', 'Nome' => 'Igor Rocha', 'Email' => 'igor.rocha'),
          	88 => array('Setor' => 'TI', 'Nome' => 'Ely Reis', 'Email' => 'ely.reis'),
          	89 => array('Setor' => 'TI', 'Nome' => 'Suporte TI', 'Email' => 'suporteti'),
          	90 => array('Setor' => 'TI', 'Nome' => 'Vinycius Alves', 'Email' => 'vinycius.alves'),
          	91 => array('Setor' => 'Treinamentos', 'Nome' => 'Sabrina Oliveira', 'Email' => 'treinamentos'),
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

              $person = People::create([
                'name' => $user['Nome'],
                'birthday' => '',
                'department_id'=> $department->id,
                'occupation_id'=> 1,
                'cpf' => ''
              ]);

              $emailFormated = trim($user['Email']) . '@provider-es.com.br';

              $user = User::create([
                'nick'                           => str_slug($user['Nome'], '.'),
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
