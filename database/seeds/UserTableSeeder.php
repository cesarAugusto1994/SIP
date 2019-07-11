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
          	0 => array('Ramal' => 3579, 'Cargo' => 'Coordenador', 'Unidade' => 'Vitória', 'Setor' => 'Tecnologia da Informação', 'Nome' => 'César Augusto Sousa', 'Email' => 'cesar.sousa'),
          	1 => array('Ramal' => null, 'Cargo' => 'Arquivo', 'Unidade' => 'Vitória', 'Setor' => 'Arquivo', 'Nome' => 'Arquivo', 'Email' => 'arquivo'),
          	2 => array('Ramal' => 3596, 'Cargo' => 'Atendente', 'Unidade' => 'Vitória', 'Setor' => 'Atendimento', 'Nome' => 'Atendimento Cariacica', 'Email' => 'atendimento.cariacica'),

            2 => array('Ramal' => 3550, 'Cargo' => 'Secretária', 'Unidade' => 'Vitória', 'Setor' => 'Atendimento', 'Nome' => 'Raíra Bonfim', 'Email' => 'secretaria'),

          	3 => array('Ramal' => 3592, 'Cargo' => 'Atendente', 'Unidade' => 'Serra', 'Setor' => 'Atendimento', 'Nome' => 'Atendimento Serra', 'Email' => 'atendimento.serra'),
          	4 => array('Ramal' => 3581, 'Cargo' => 'Atendente', 'Unidade' => 'Vila Velha Centro', 'Setor' => 'Atendimento', 'Nome' => 'Atendimento Vila Velha Centro', 'Email' => 'atendimento.vilavelha.centro'),
          	5 => array('Ramal' => 3588, 'Cargo' => 'Atendente', 'Unidade' => 'Vila Velha Ibes', 'Setor' => 'Atendimento', 'Nome' => 'Atendimento Vila Velha Ibes', 'Email' => 'atendimento.vilavelha.ibes'),
          	6 => array('Ramal' => 3570, 'Cargo' => 'Atendente', 'Unidade' => 'Vitória', 'Setor' => 'Atendimento', 'Nome' => 'Atendimento Vitória', 'Email' => 'atendimento.vitoria'),
          	7 => array('Ramal' => 3571, 'Cargo' => 'Atendente', 'Unidade' => 'Vitória', 'Setor' => 'Atendimento', 'Nome' => 'Denise Pereira', 'Email' => 'denise.pereira'),
          	8 => array('Ramal' => null, 'Cargo' => 'Atendente', 'Unidade' => 'Baixo Guandú', 'Setor' => 'Atendimento', 'Nome' => 'Atendimento Baixo Guandú', 'Email' => 'atendimento.baixoguando'),
          	9 => array('Ramal' => null, 'Cargo' => 'Administrativo', 'Unidade' => 'Baixo Guandú', 'Setor' => 'Atendimento', 'Nome' => 'Karina Barteli', 'Email' => 'karina.barteli'),
          	10 => array('Ramal' => null, 'Cargo' => 'Administrativo', 'Unidade' => 'Baixo Guandú', 'Setor' => 'Técnico', 'Nome' => 'Rodrigo Alcides', 'Email' => 'rodrigo.alcides'),
          	11 => array('Ramal' => 3596, 'Cargo' => 'Coleta', 'Unidade' => 'Cariacica', 'Setor' => 'Coleta', 'Nome' => 'Coleta Cariacica', 'Email' => 'coleta.cariacica'),
          	12 => array('Ramal' => null, 'Cargo' => 'Coleta', 'Unidade' => 'Serra', 'Setor' => 'Coleta', 'Nome' => 'Coleta Serra', 'Email' => 'coleta.serra'),
          	13 => array('Ramal' => null, 'Cargo' => 'Coleta', 'Unidade' => 'Vila Velha Ibes', 'Setor' => 'Coleta', 'Nome' => 'Coleta Vila Velha IBES', 'Email' => 'coleta.vilavelha.ibes'),
          	14 => array('Ramal' => null, 'Cargo' => 'Coleta', 'Unidade' => 'Vitória', 'Setor' => 'Coleta', 'Nome' => 'Coleta Vitória', 'Email' => 'coleta.vitoria'),
          	15 => array('Ramal' => null, 'Cargo' => 'Coleta', 'Unidade' => 'Vila Velha Centro', 'Setor' => 'Coleta', 'Nome' => 'Coleta Vila Velha Centro', 'Email' => 'coleta.vilavelha.centro'),
          	16 => array('Ramal' => 3575, 'Cargo' => 'Administrativo', 'Unidade' => 'Vitória', 'Setor' => 'Comercial', 'Nome' => 'Herlan Gonçalves', 'Email' => 'comercial'),
          	17 => array('Ramal' => 3565, 'Cargo' => 'Administrativo', 'Unidade' => 'Vitória', 'Setor' => 'Comercial', 'Nome' => 'Ricardo Castro', 'Email' => 'comercial2'),
          	18 => array('Ramal' => null, 'Cargo' => 'Aprendiz', 'Unidade' => 'Vitória', 'Setor' => 'Comercial', 'Nome' => 'Apoio', 'Email' => 'comercial3'),
          	20 => array('Ramal' => 3560, 'Cargo' => 'Administrativo', 'Unidade' => 'Vitória', 'Setor' => 'Marketing', 'Nome' => 'Marketing', 'Email' => 'marketing'),
          	21 => array('Ramal' => 3574, 'Cargo' => 'Administrativo', 'Unidade' => 'Vitória', 'Setor' => 'Exames', 'Nome' => 'Simone Coelho', 'Email' => 'simone.coelho'),
          	22 => array('Ramal' => 3580, 'Cargo' => 'Diretor', 'Unidade' => 'Vitória', 'Setor' => 'Diretoria', 'Nome' => 'Carlos César Sad', 'Email' => 'cesar.sad'),
          	23 => array('Ramal' => 3562, 'Cargo' => 'Diretor', 'Unidade' => 'Vitória', 'Setor' => 'Técnico', 'Nome' => 'Deyvd Soares', 'Email' => 'deyvd.soares'),
          	24 => array('Ramal' => null, 'Cargo' => 'Diretor', 'Unidade' => 'Vitória', 'Setor' => 'RH', 'Nome' => 'Wesley Damásio', 'Email' => 'wesley.damasio'),
          	25 => array('Ramal' => null, 'Cargo' => 'Enfermeiro', 'Unidade' => 'Vitória', 'Setor' => 'Enfermagem', 'Nome' => 'Cristinete Silva', 'Email' => 'cristinete.silva'),
          	26 => array('Ramal' => 3601, 'Cargo' => 'Enfermeiro', 'Unidade' => 'Vitória', 'Setor' => 'Enfermagem', 'Nome' => 'Ana Florentino', 'Email' => 'enfermagem.trabalho'),
          	27 => array('Ramal' => null, 'Cargo' => 'Enfermeiro', 'Unidade' => 'Cariacica', 'Setor' => 'Enfermagem', 'Nome' => 'Fernando Rodrigues', 'Email' => 'enfermagem.cariacica'),
          	28 => array('Ramal' => 3555, 'Cargo' => 'E-Social', 'Unidade' => 'Vitória', 'Setor' => 'Técnico', 'Nome' => 'Ariane Pina', 'Email' => 'ariane.pina'),
          	29 => array('Ramal' => 3555, 'Cargo' => 'E-Social', 'Unidade' => 'Vitória', 'Setor' => 'Técnico', 'Nome' => 'Sara Tavares', 'Email' => 'sara.tavares'),
          	30 => array('Ramal' => 3584, 'Cargo' => 'Administrativo', 'Unidade' => 'Vila Velha Centro', 'Setor' => 'Financeiro', 'Nome' => 'Larissa', 'Email' => 'financeiro2'),
          	31 => array('Ramal' => null, 'Cargo' => 'Credenciamento', 'Unidade' => 'Vitória', 'Setor' => 'Exames', 'Nome' => 'Karoline', 'Email' => 'credenciamento2'),
          	32 => array('Ramal' => null, 'Cargo' => 'Credenciamento', 'Unidade' => 'Vitória', 'Setor' => 'Exames', 'Nome' => 'Monarah', 'Email' => 'credenciamento3'),
          	33 => array('Ramal' => null, 'Cargo' => 'Credenciamento', 'Unidade' => 'Vitória', 'Setor' => 'Exames', 'Nome' => 'Gierke', 'Email' => 'credenciamento4'),
          	34 => array('Ramal' => null, 'Cargo' => 'Credenciamento', 'Unidade' => 'Vitória', 'Setor' => 'Exames', 'Nome' => 'Lucas', 'Email' => 'credenciamento5'),
          	35 => array('Ramal' => null, 'Cargo' => 'Expedição', 'Unidade' => 'Vitória', 'Setor' => 'Exames', 'Nome' => 'Stela', 'Email' => 'expedicao'),
          	36 => array('Ramal' => null, 'Cargo' => 'Liberação', 'Unidade' => 'Vitória', 'Setor' => 'Exames', 'Nome' => 'Débora', 'Email' => 'liberacao'),
          	37 => array('Ramal' => null, 'Cargo' => 'Liberação', 'Unidade' => 'Vitória', 'Setor' => 'Exames', 'Nome' => 'Nathiely', 'Email' => 'liberacao2'),
          	38 => array('Ramal' => null, 'Cargo' => 'Liberação', 'Unidade' => 'Vitória', 'Setor' => 'Exames', 'Nome' => 'Hevellyn', 'Email' => 'liberacao3'),
          	39 => array('Ramal' => null, 'Cargo' => 'Liberação', 'Unidade' => 'Vitória', 'Setor' => 'Exames', 'Nome' => 'Charles', 'Email' => 'liberacao4'),
          	40 => array('Ramal' => null, 'Cargo' => 'Liberação', 'Unidade' => 'Vitória', 'Setor' => 'Exames', 'Nome' => 'Alex Sander', 'Email' => 'liberacao5'),
          	41 => array('Ramal' => null, 'Cargo' => 'Triagem', 'Unidade' => 'Vitória', 'Setor' => 'Exames', 'Nome' => 'Paulo Vinicius', 'Email' => 'triagem'),
          	42 => array('Ramal' => null, 'Cargo' => 'UMAP', 'Unidade' => 'Vitória', 'Setor' => 'Exames', 'Nome' => 'Thais', 'Email' => 'umap'),
          	43 => array('Ramal' => null, 'Cargo' => 'Triagem', 'Unidade' => 'Vitória', 'Setor' => 'Exames', 'Nome' => 'Ana Carolina', 'Email' => 'ana.carolina'),
          	44 => array('Ramal' => null, 'Cargo' => 'Administrativo', 'Unidade' => 'Vitória', 'Setor' => 'Comercial', 'Nome' => 'Carlos Eduardo', 'Email' => 'carlos.eduardo'),
          	45 => array('Ramal' => null, 'Cargo' => 'Atendente', 'Unidade' => 'Vitória', 'Setor' => 'Atendimento', 'Nome' => 'Joseth Cardozo', 'Email' => 'joseth.cardoso'),
          	46 => array('Ramal' => 3584, 'Cargo' => 'Administrativo', 'Unidade' => 'Vila Velha Centro', 'Setor' => 'Financeiro', 'Nome' => 'Mariana Pazolini', 'Email' => 'mariana.pazolini'),
          	47 => array('Ramal' => 3585, 'Cargo' => 'Administrativo', 'Unidade' => 'Vila Velha Centro', 'Setor' => 'Financeiro', 'Nome' => 'Laryssa', 'Email' => 'compras'),
          	48 => array('Ramal' => 3586, 'Cargo' => 'Administrativo', 'Unidade' => 'Vila Velha Centro', 'Setor' => 'Financeiro', 'Nome' => 'Roberta', 'Email' => 'faturamento'),
          	50 => array('Ramal' => 3586, 'Cargo' => 'Administrativo', 'Unidade' => 'Vila Velha Centro', 'Setor' => 'Financeiro', 'Nome' => 'Viviane Neves', 'Email' => 'cobranca'),
          	51 => array('Ramal' => null, 'Cargo' => 'Fonoaudiólogo', 'Unidade' => 'Cariacica', 'Setor' => 'Fono', 'Nome' => 'Fono Cariacica', 'Email' => 'bianca.kaiser'),
          	52 => array('Ramal' => null, 'Cargo' => 'Fonoaudiólogo', 'Unidade' => 'Cariacica', 'Setor' => 'Fono', 'Nome' => 'Gleice', 'Email' => 'fono.caricacica'),
          	53 => array('Ramal' => null, 'Cargo' => 'Fonoaudiólogo', 'Unidade' => 'Serra', 'Setor' => 'Fono', 'Nome' => 'Fono Serra', 'Email' => 'fono.serra'),
          	54 => array('Ramal' => null, 'Cargo' => 'Fonoaudiólogo', 'Unidade' => 'Vila Velha Ibes', 'Setor' => 'Fono', 'Nome' => 'Fono Vila Velha IBES', 'Email' => 'fono.vilavelha.ibes'),
          	55 => array('Ramal' => null, 'Cargo' => 'Fonoaudiólogo', 'Unidade' => 'Vitória', 'Setor' => 'Fono', 'Nome' => 'Fono Vtória', 'Email' => 'fono.vitoria'),
          	56 => array('Ramal' => null, 'Cargo' => 'Fonoaudiólogo', 'Unidade' => 'Vitória', 'Setor' => 'Fono', 'Nome' => 'Fono Vitória', 'Email' => 'fono2.vitoria'),
          	58 => array('Ramal' => 3589, 'Cargo' => 'Administrativo', 'Unidade' => 'Vila Velha Ibes', 'Setor' => 'Administrativo', 'Nome' => 'Mariana Coelho', 'Email' => 'mariana.coelho'),
          	59 => array('Ramal' => 3590, 'Cargo' => 'Administrativo', 'Unidade' => 'Vila Velha Ibes', 'Setor' => 'Administrativo', 'Nome' => 'Paola neves', 'Email' => 'paola.neves'),
          	60 => array('Ramal' => null, 'Cargo' => 'Instrutor de Treinamentos', 'Unidade' => 'Vitória', 'Setor' => 'Treinamentos', 'Nome' => 'Aeliton Silva', 'Email' => 'aeliton.silva'),

          	61 => array('Ramal' => null, 'Cargo' => 'Advogado', 'Unidade' => 'Vitória', 'Setor' => 'Juridico', 'Nome' => 'Andréia Botelho', 'Email' => 'juridico'),
          	62 => array('Ramal' => 3601, 'Cargo' => 'Administrativo', 'Unidade' => 'Vitória', 'Setor' => 'Laboratório', 'Nome' => 'Daniele', 'Email' => 'laboratorio'),
          	63 => array('Ramal' => 3561, 'Cargo' => 'Psicologo', 'Unidade' => 'Vitória', 'Setor' => 'Psicologia', 'Nome' => 'Psicologia', 'Email' => 'psicologia'),
          	64 => array('Ramal' => 3561, 'Cargo' => 'Psicologo', 'Unidade' => 'Vitória', 'Setor' => 'Psicologia', 'Nome' => 'Flávia Cypreste', 'Email' => 'flavia.cypreste'),
          	65 => array('Ramal' => 3602, 'Cargo' => 'Administrativo', 'Unidade' => 'Vitória', 'Setor' => 'RH', 'Nome' => 'Edilson Lima', 'Email' => 'dp'),
          	66 => array('Ramal' => 3602, 'Cargo' => 'Administrativo', 'Unidade' => 'Vitória', 'Setor' => 'RH', 'Nome' => 'Luciana Rocha', 'Email' => 'dp2'),
          	68 => array('Ramal' => 3606, 'Cargo' => 'Técnico', 'Unidade' => 'Vitória', 'Setor' => 'Técnico', 'Nome' => 'Diego Souza', 'Email' => 'diego.souza'),
          	69 => array('Ramal' => 3606, 'Cargo' => 'Técnico', 'Unidade' => 'Vitória', 'Setor' => 'Técnico', 'Nome' => 'Fellipe Freitas', 'Email' => 'fellipe.freitas'),
          	70 => array('Ramal' => 3606, 'Cargo' => 'Técnico', 'Unidade' => 'Vitória', 'Setor' => 'Técnico', 'Nome' => 'Geovani Charpinel', 'Email' => 'geovani.charpinel'),
          	71 => array('Ramal' => 3606, 'Cargo' => 'Técnico', 'Unidade' => 'Serra', 'Setor' => 'Técnico', 'Nome' => 'Gizelle Rodrigues', 'Email' => 'gizelle.rodrigues'),
          	72 => array('Ramal' => 3606, 'Cargo' => 'Técnico', 'Unidade' => 'Vitória', 'Setor' => 'Técnico', 'Nome' => 'Leonardo Araújp', 'Email' => 'leonardo.araujo'),
          	73 => array('Ramal' => null, 'Cargo' => 'Técnico', 'Unidade' => 'Vitória', 'Setor' => 'Técnico', 'Nome' => 'Nadine', 'Email' => 'nadine.lodi'),
          	74 => array('Ramal' => null, 'Cargo' => 'Técnico', 'Unidade' => 'Serra', 'Setor' => 'Técnico', 'Nome' => 'Rebeca Senara', 'Email' => 'rebeca.senara'),
          	75 => array('Ramal' => 3562, 'Cargo' => 'Técnico', 'Unidade' => 'Vitória', 'Setor' => 'Técnico', 'Nome' => 'Dávila Souza', 'Email' => 'davila.souza'),
          	76 => array('Ramal' => 3551, 'Cargo' => 'Técnico', 'Unidade' => 'Vitória', 'Setor' => 'Técnico', 'Nome' => 'Emyle Almeida', 'Email' => 'emyle.almeida'),
          	77 => array('Ramal' => 3606, 'Cargo' => 'Técnico', 'Unidade' => 'Vitória', 'Setor' => 'Técnico', 'Nome' => 'Felipe Batista', 'Email' => 'felipe.batista'),
          	78 => array('Ramal' => 3551, 'Cargo' => 'Técnico', 'Unidade' => 'Vitória', 'Setor' => 'Técnico', 'Nome' => 'Igor Bianchi', 'Email' => 'igor.bianchi'),
          	79 => array('Ramal' => null, 'Cargo' => 'Técnico', 'Unidade' => 'Vitória', 'Setor' => 'Técnico', 'Nome' => 'Beatriz Crespo', 'Email' => 'beatrz.crespo'),
          	80 => array('Ramal' => 3606, 'Cargo' => 'Técnico', 'Unidade' => 'Vitória', 'Setor' => 'Técnico', 'Nome' => 'Débora Monteiro', 'Email' => 'debora.monteiro'),
          	81 => array('Ramal' => null, 'Cargo' => 'Técnico', 'Unidade' => 'Vitória', 'Setor' => 'Técnico', 'Nome' => 'Ingrid Rubenich', 'Email' => 'ingrid.rubenich'),
          	82 => array('Ramal' => null, 'Cargo' => 'Técnico', 'Unidade' => 'Vitória', 'Setor' => 'Técnico', 'Nome' => 'Bruna Oliveira', 'Email' => 'brunna.oliveira'),
          	83 => array('Ramal' => 3607, 'Cargo' => 'Técnico', 'Unidade' => 'Vitória', 'Setor' => 'Técnico', 'Nome' => 'Karla Marques', 'Email' => 'karla.marques'),
          	84 => array('Ramal' => 3607, 'Cargo' => 'Técnico', 'Unidade' => 'Vitória', 'Setor' => 'Técnico', 'Nome' => 'Amanda Rodrigues', 'Email' => 'amanda.rodrigues'),
          	85 => array('Ramal' => 3562, 'Cargo' => 'Técnico', 'Unidade' => 'Vitória', 'Setor' => 'Técnico', 'Nome' => 'Júlio Félix', 'Email' => 'julio.felix'),
          	86 => array('Ramal' => 3551, 'Cargo' => 'Técnico', 'Unidade' => 'Vitória', 'Setor' => 'Técnico', 'Nome' => 'Igor Rocha', 'Email' => 'igor.rocha'),
          	88 => array('Ramal' => 3578, 'Cargo' => 'Suporte SOC', 'Unidade' => 'Vitória', 'Setor' => 'Tecnologia da Informação', 'Nome' => 'Ely Reis', 'Email' => 'ely.reis'),
          	90 => array('Ramal' => 3579, 'Cargo' => 'Infraestrutura', 'Unidade' => 'Vitória', 'Setor' => 'Tecnologia da Informação', 'Nome' => 'Vinycius Alves', 'Email' => 'vinycius.alves'),

            91 => array('Ramal' => null, 'Cargo' => 'Infraestrutura', 'Unidade' => 'Vitória', 'Setor' => 'Tecnologia da Informação', 'Nome' => 'André Tavares', 'Email' => 'andre.tavares'),
            92 => array('Ramal' => null, 'Cargo' => 'Infraestrutura', 'Unidade' => 'Vitória', 'Setor' => 'Tecnologia da Informação', 'Nome' => 'Arthur Gonçalves', 'Email' => 'arthur.goncalves'),

            93 => array('Ramal' => 3557, 'Cargo' => 'Administrativo', 'Unidade' => 'Vitória', 'Setor' => 'Treinamentos', 'Nome' => 'Sabrina Oliveira', 'Email' => 'treinamentos'),
          );

        //$users = explode(',', $users);

        foreach ($users as $key => $user) {

          if($key > 10) {
            break;
          }

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

              $hasOccupation = Occupation::where('name', $user['Cargo'])->where('department_id', $department->id)->first();

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
                'cpf' => '',
                'branch' => $user['Ramal']
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
