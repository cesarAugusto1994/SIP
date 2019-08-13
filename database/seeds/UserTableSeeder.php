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

            $avatar = 'defaults/avatar.jpg';
/*
            $unit = Unit::create([
              'name' => 'Vitória'
            ]);
*/
            $department = Department::create([
              'name' => 'Sistema'
            ]);

            $occupation = Occupation::create([
              'name' => 'Administrador',
              'department_id' => $department->id
            ]);

            $person = People::create([
              'name' => 'Administrador',
              'department_id'=> $department->id,
              'unit_id'=> 1,
              'occupation_id'=> $occupation->id,
              'birthday' => '1994-07-15',
              'cpf' => '12345678987'
            ]);

            $user = User::create([
              'nick'                           => 'admin',
              'email'                          => $seededAdminEmail,
              'password'                       => Hash::make('123'),
              'avatar_type' => 'upload',
              'avatar' => $avatar,
              'do_task' => false,
              'person_id' => $person->id,
              'email_verified_at' => now(),
              'login_soc' => '',
              'password_soc' => '',
              'password_email' => null,
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
          	0 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => 3579, 'Cargo' => 'Coordenador', 'Unidade' => 'Vitória', 'Setor' => 'Tecnologia da Informação', 'Nome' => 'César Augusto Sousa', 'Email' => 'cesar.sousa'),
          	2 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => 3596, 'Cargo' => 'Atendente', 'Unidade' => 'Vitória', 'Setor' => 'Atendimento', 'Nome' => 'Atendimento Cariacica', 'Email' => 'atendimento.cariacica'),
            2 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => 3550, 'Cargo' => 'Secretária', 'Unidade' => 'Vitória', 'Setor' => 'Atendimento', 'Nome' => 'Raíra Bonfim', 'Email' => 'secretaria'),
          	3 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => 3592, 'Cargo' => 'Atendente', 'Unidade' => 'Serra', 'Setor' => 'Atendimento', 'Nome' => 'Atendimento Serra', 'Email' => 'atendimento.serra'),
          	4 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => 3581, 'Cargo' => 'Atendente', 'Unidade' => 'Vila Velha Centro', 'Setor' => 'Atendimento', 'Nome' => 'Atendimento Vila Velha Centro', 'Email' => 'atendimento.vilavelha.centro'),
          	5 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => 3588, 'Cargo' => 'Atendente', 'Unidade' => 'Vila Velha Ibes', 'Setor' => 'Atendimento', 'Nome' => 'Atendimento Vila Velha Ibes', 'Email' => 'atendimento.vilavelha.ibes'),
          	6 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => 3570, 'Cargo' => 'Atendente', 'Unidade' => 'Vitória', 'Setor' => 'Atendimento', 'Nome' => 'Atendimento Vitória', 'Email' => 'atendimento.vitoria'),
          	7 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => 3571, 'Cargo' => 'Atendente', 'Unidade' => 'Vitória', 'Setor' => 'Atendimento', 'Nome' => 'Denise Pereira', 'Email' => 'denise.pereira'),
          	8 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => null, 'Cargo' => 'Atendente', 'Unidade' => 'Baixo Guandú', 'Setor' => 'Atendimento', 'Nome' => 'Atendimento Baixo Guandú', 'Email' => 'atendimento.baixoguando'),
          	9 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => null, 'Cargo' => 'Administrativo', 'Unidade' => 'Baixo Guandú', 'Setor' => 'Atendimento', 'Nome' => 'Karina Barteli', 'Email' => 'karina.barteli'),
          	10 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => null, 'Cargo' => 'Administrativo', 'Unidade' => 'Baixo Guandú', 'Setor' => 'Técnico em Segurança do Trabalho', 'Nome' => 'Rodrigo Alcides', 'Email' => 'rodrigo.alcides'),
          	11 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => 3596, 'Cargo' => 'Coleta', 'Unidade' => 'Cariacica', 'Setor' => 'Coleta', 'Nome' => 'Coleta Cariacica', 'Email' => 'coleta.cariacica'),
          	12 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => null, 'Cargo' => 'Coleta', 'Unidade' => 'Serra', 'Setor' => 'Coleta', 'Nome' => 'Coleta Serra', 'Email' => 'coleta.serra'),
          	13 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => null, 'Cargo' => 'Coleta', 'Unidade' => 'Vila Velha Ibes', 'Setor' => 'Coleta', 'Nome' => 'Coleta Vila Velha IBES', 'Email' => 'coleta.vilavelha.ibes'),
          	14 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => null, 'Cargo' => 'Coleta', 'Unidade' => 'Vitória', 'Setor' => 'Coleta', 'Nome' => 'Coleta Vitória', 'Email' => 'coleta.vitoria'),
          	15 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => null, 'Cargo' => 'Coleta', 'Unidade' => 'Vila Velha Centro', 'Setor' => 'Coleta', 'Nome' => 'Coleta Vila Velha Centro', 'Email' => 'coleta.vilavelha.centro'),
          	17 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => 3565, 'Cargo' => 'Administrativo', 'Unidade' => 'Vitória', 'Setor' => 'Comercial', 'Nome' => 'Ricardo Castro', 'Email' => 'comercial'),
          	18 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => null, 'Cargo' => 'Aprendiz', 'Unidade' => 'Vitória', 'Setor' => 'Comercial', 'Nome' => 'Apoio', 'Email' => 'comercial3'),
          	20 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => 3560, 'Cargo' => 'Administrativo', 'Unidade' => 'Vitória', 'Setor' => 'Marketing', 'Nome' => 'Marketing', 'Email' => 'marketing'),
          	21 => array('PHONE_CODE' => 137, 'PHONE_PASS' => 55317, 'PHONE_CALL' => 106,'Ramal' => 3574, 'Cargo' => 'Supervidor', 'Unidade' => 'Vitória', 'Setor' => 'Exames', 'Nome' => 'Simone Coelho', 'Email' => 'simone.coelho'),
          	22 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => 3580, 'Cargo' => 'Diretor', 'Unidade' => 'Vitória', 'Setor' => 'Diretoria', 'Nome' => 'Carlos César Sad', 'Email' => 'cesar.sad'),
          	23 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => 3562, 'Cargo' => 'Diretor', 'Unidade' => 'Vitória', 'Setor' => 'Documentação', 'Nome' => 'Deyvd Soares', 'Email' => 'deyvd.soares'),
          	24 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => null, 'Cargo' => 'Diretor', 'Unidade' => 'Vitória', 'Setor' => 'Recursos Humanos', 'Nome' => 'Wesley Damásio', 'Email' => 'wesley.damasio'),
          	25 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => null, 'Cargo' => 'Enfermeiro', 'Unidade' => 'Vitória', 'Setor' => 'Enfermagem', 'Nome' => 'Cristinete Silva', 'Email' => 'cristinete.silva'),
          	26 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => 3601, 'Cargo' => 'Enfermeiro', 'Unidade' => 'Vitória', 'Setor' => 'Enfermagem', 'Nome' => 'Ana Florentino', 'Email' => 'enfermagem.trabalho'),
          	27 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => null, 'Cargo' => 'Enfermeiro', 'Unidade' => 'Cariacica', 'Setor' => 'Enfermagem', 'Nome' => 'Fernando Rodrigues', 'Email' => 'enfermagem.cariacica'),
          	28 => array('PHONE_CODE' => 117, 'PHONE_PASS' => 39137, 'PHONE_CALL' => null,'Ramal' => 3555, 'Cargo' => 'Higiene Ocupacional', 'Unidade' => 'Vitória', 'Setor' => 'Técnico em Segurança do Trabalho', 'Nome' => 'Ariane Pina', 'Email' => 'ariane.pina'),
          	29 => array('PHONE_CODE' => 116, 'PHONE_PASS' => 38328, 'PHONE_CALL' => null,'Ramal' => 3555, 'Cargo' => 'Higiene Ocupacional', 'Unidade' => 'Vitória', 'Setor' => 'Técnico em Segurança do Trabalho', 'Nome' => 'Sara Tavares', 'Email' => 'sara.tavares'),
          	30 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => 3584, 'Cargo' => 'Administrativo', 'Unidade' => 'Vila Velha Centro', 'Setor' => 'Financeiro', 'Nome' => 'Larissa Brandão', 'Email' => 'financeiro2'),
          	31 => array('PHONE_CODE' => 108, 'PHONE_PASS' => 31856, 'PHONE_CALL' => null,'Ramal' => null, 'Cargo' => 'Credenciamento', 'Unidade' => 'Vitória', 'Setor' => 'Exames', 'Nome' => 'Karoline', 'Email' => 'credenciamento2'),
          	32 => array('PHONE_CODE' => 106, 'PHONE_PASS' => 30238, 'PHONE_CALL' => null,'Ramal' => null, 'Cargo' => 'Credenciamento', 'Unidade' => 'Vitória', 'Setor' => 'Exames', 'Nome' => 'Thais Bragança', 'Email' => 'credenciamento3'),
          	33 => array('PHONE_CODE' => 107, 'PHONE_PASS' => 31047, 'PHONE_CALL' => null,'Ramal' => null, 'Cargo' => 'Credenciamento', 'Unidade' => 'Vitória', 'Setor' => 'Exames', 'Nome' => 'Gierke', 'Email' => 'credenciamento4'),
          	34 => array('PHONE_CODE' => 109, 'PHONE_PASS' => 32665, 'PHONE_CALL' => null,'Ramal' => null, 'Cargo' => 'Credenciamento', 'Unidade' => 'Vitória', 'Setor' => 'Exames', 'Nome' => 'Lucas Castelan', 'Email' => 'credenciamento5'),
            35 => array('PHONE_CODE' => 104, 'PHONE_PASS' => 28620, 'PHONE_CALL' => null,'Ramal' => null, 'Cargo' => 'Expedição', 'Unidade' => 'Vitória', 'Setor' => 'Exames', 'Nome' => 'Stela Oliveira', 'Email' => 'expedicao'),
          	36 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => null, 'Cargo' => 'Liberação', 'Unidade' => 'Vitória', 'Setor' => 'Exames', 'Nome' => 'Débora Spadetto', 'Email' => 'liberacao'),
          	37 => array('PHONE_CODE' => 105, 'PHONE_PASS' => 29429, 'PHONE_CALL' => null,'Ramal' => null, 'Cargo' => 'Liberação', 'Unidade' => 'Vitória', 'Setor' => 'Exames', 'Nome' => 'Nathiely Mello', 'Email' => 'liberacao2'),
          	38 => array('PHONE_CODE' => 136, 'PHONE_PASS' => 54508, 'PHONE_CALL' => null,'Ramal' => null, 'Cargo' => 'Liberação', 'Unidade' => 'Vitória', 'Setor' => 'Exames', 'Nome' => 'Hevillin Dourado', 'Email' => 'liberacao3'),
          	39 => array('PHONE_CODE' => 102, 'PHONE_PASS' => 27002, 'PHONE_CALL' => null,'Ramal' => null, 'Cargo' => 'Liberação', 'Unidade' => 'Vitória', 'Setor' => 'Exames', 'Nome' => 'Charles Barbosa', 'Email' => 'liberacao4'),
          	42 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => null, 'Cargo' => 'UMAP', 'Unidade' => 'Vitória', 'Setor' => 'Exames', 'Nome' => 'UMAP', 'Email' => 'umap'),
            43 => array('PHONE_CODE' => 100, 'PHONE_PASS' => 25384, 'PHONE_CALL' => null,'Ramal' => null, 'Cargo' => 'Triagem', 'Unidade' => 'Vitória', 'Setor' => 'Exames', 'Nome' => 'Ana Carolina', 'Email' => 'ana.carolina'),
          	44 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => null, 'Cargo' => 'Administrativo', 'Unidade' => 'Vitória', 'Setor' => 'Comercial', 'Nome' => 'Carlos Eduardo', 'Email' => 'carlos.eduardo'),
          	45 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => null, 'Cargo' => 'Atendente', 'Unidade' => 'Vitória', 'Setor' => 'Atendimento', 'Nome' => 'Joseth Cardozo', 'Email' => 'joseth.cardoso'),
          	46 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => 3584, 'Cargo' => 'Diretor', 'Unidade' => 'Vila Velha Centro', 'Setor' => 'Financeiro', 'Nome' => 'Mariana Pazolini', 'Email' => 'mariana.pazolini'),
          	47 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => 3585, 'Cargo' => 'Compras', 'Unidade' => 'Vila Velha Centro', 'Setor' => 'Financeiro', 'Nome' => 'Laryssa', 'Email' => 'compras'),
          	48 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => 3586, 'Cargo' => 'Faturamento', 'Unidade' => 'Vila Velha Centro', 'Setor' => 'Financeiro', 'Nome' => 'Roberta', 'Email' => 'faturamento'),
          	50 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => 3586, 'Cargo' => 'Faturamento', 'Unidade' => 'Vila Velha Centro', 'Setor' => 'Financeiro', 'Nome' => 'Viviane Neves', 'Email' => 'cobranca'),
          	51 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => null, 'Cargo' => 'Fonoaudiólogo', 'Unidade' => 'Cariacica', 'Setor' => 'Fonoaudiologia', 'Nome' => 'Fono Cariacica', 'Email' => 'bianca.kaiser'),
          	52 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => null, 'Cargo' => 'Fonoaudiólogo', 'Unidade' => 'Cariacica', 'Setor' => 'Fonoaudiologia', 'Nome' => 'Gleice', 'Email' => 'fono.caricacica'),
          	53 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => null, 'Cargo' => 'Fonoaudiólogo', 'Unidade' => 'Serra', 'Setor' => 'Fonoaudiologia', 'Nome' => 'Fono Serra', 'Email' => 'fono.serra'),
          	54 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => null, 'Cargo' => 'Fonoaudiólogo', 'Unidade' => 'Vila Velha Ibes', 'Setor' => 'Fonoaudiologia', 'Nome' => 'Fono Vila Velha IBES', 'Email' => 'fono.vilavelha.ibes'),
          	55 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => null, 'Cargo' => 'Fonoaudiólogo', 'Unidade' => 'Vitória', 'Setor' => 'Fonoaudiologia', 'Nome' => 'Fono Vtória', 'Email' => 'fono.vitoria'),
          	56 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => null, 'Cargo' => 'Fonoaudiólogo', 'Unidade' => 'Vitória', 'Setor' => 'Fonoaudiologia', 'Nome' => 'Fono Vitória', 'Email' => 'fono2.vitoria'),
          	58 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => 3589, 'Cargo' => 'Administrativo', 'Unidade' => 'Vila Velha Ibes', 'Setor' => 'Administrativo', 'Nome' => 'Mariana Coelho', 'Email' => 'mariana.coelho'),
          	59 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => 3590, 'Cargo' => 'Administrativo', 'Unidade' => 'Vila Velha Ibes', 'Setor' => 'Administrativo', 'Nome' => 'Paola neves', 'Email' => 'paola.neves'),
          	60 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => null, 'Cargo' => 'Instrutor de Treinamentos', 'Unidade' => 'Vitória', 'Setor' => 'Treinamentos', 'Nome' => 'Aeliton Silva', 'Email' => 'aeliton.silva'),
          	61 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => null, 'Cargo' => 'Advogado', 'Unidade' => 'Vitória', 'Setor' => 'Juridico', 'Nome' => 'Andréia Botelho', 'Email' => 'juridico'),
          	62 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => 3601, 'Cargo' => 'Administrativo', 'Unidade' => 'Vitória', 'Setor' => 'Laboratório', 'Nome' => 'Daniele', 'Email' => 'laboratorio'),
          	63 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => 3561, 'Cargo' => 'Psicologo', 'Unidade' => 'Vitória', 'Setor' => 'Psicologia', 'Nome' => 'Psicologia', 'Email' => 'psicologia'),
          	64 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => 3561, 'Cargo' => 'Psicologo', 'Unidade' => 'Vitória', 'Setor' => 'Psicologia', 'Nome' => 'Flávia Cypreste', 'Email' => 'flavia.cypreste'),
          	65 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => 3602, 'Cargo' => 'Administrativo', 'Unidade' => 'Vitória', 'Setor' => 'Recursos Humanos', 'Nome' => 'Edilson Lima', 'Email' => 'dp'),
          	66 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => 3602, 'Cargo' => 'Administrativo', 'Unidade' => 'Vitória', 'Setor' => 'Recursos Humanos', 'Nome' => 'Luciana Rocha', 'Email' => 'dp2'),
          	68 => array('PHONE_CODE' => 132, 'PHONE_PASS' => 51272, 'PHONE_CALL' => null,'Ramal' => 3606, 'Cargo' => 'Higiene Ocupacional', 'Unidade' => 'Vitória', 'Setor' => 'Técnico em Segurança do Trabalho', 'Nome' => 'Diego Souza', 'Email' => 'diego.souza'),
          	69 => array('PHONE_CODE' => 127, 'PHONE_PASS' => 47227, 'PHONE_CALL' => null,'Ramal' => 3606, 'Cargo' => 'Higiene Ocupacional', 'Unidade' => 'Vitória', 'Setor' => 'Técnico em Segurança do Trabalho', 'Nome' => 'Fellipe Freitas', 'Email' => 'fellipe.freitas'),
          	70 => array('PHONE_CODE' => 129, 'PHONE_PASS' => 48845, 'PHONE_CALL' => null,'Ramal' => 3606, 'Cargo' => 'Higiene Ocupacional', 'Unidade' => 'Vitória', 'Setor' => 'Técnico em Segurança do Trabalho', 'Nome' => 'Geovani Charpinel', 'Email' => 'geovani.charpinel'),
          	71 => array('PHONE_CODE' => 118, 'PHONE_PASS' => 39946, 'PHONE_CALL' => null,'Ramal' => 3606, 'Cargo' => 'Inspeção', 'Unidade' => 'Serra', 'Setor' => 'Técnico em Segurança do Trabalho', 'Nome' => 'Gizelle Rodrigues', 'Email' => 'gizelle.rodrigues'),
          	72 => array('PHONE_CODE' => 121, 'PHONE_PASS' => 42373, 'PHONE_CALL' => null,'Ramal' => 3606, 'Cargo' => 'Inspeção', 'Unidade' => 'Vitória', 'Setor' => 'Técnico em Segurança do Trabalho', 'Nome' => 'Leonardo Araújp', 'Email' => 'leonardo.araujo'),
          	73 => array('PHONE_CODE' => 124, 'PHONE_PASS' => 44800, 'PHONE_CALL' => null,'Ramal' => null, 'Cargo' => 'Laudo', 'Unidade' => 'Vitória', 'Setor' => 'Técnico em Segurança do Trabalho', 'Nome' => 'Nadine', 'Email' => 'nadine.lodi'),
          	74 => array('PHONE_CODE' => 120, 'PHONE_PASS' => 41564, 'PHONE_CALL' => null,'Ramal' => null, 'Cargo' => 'Inspeção', 'Unidade' => 'Serra', 'Setor' => 'Técnico em Segurança do Trabalho', 'Nome' => 'Rebeca Senara', 'Email' => 'rebeca.senara'),
          	75 => array('PHONE_CODE' => 115, 'PHONE_PASS' => 37519, 'PHONE_CALL' => null,'Ramal' => 3562, 'Cargo' => 'Documentação', 'Unidade' => 'Vitória', 'Setor' => 'Técnico em Segurança do Trabalho', 'Nome' => 'Dávila Souza', 'Email' => 'davila.souza'),
          	//76 => array('PHONE_CODE' => 119, 'PHONE_PASS' => 40755, 'PHONE_CALL' => null,'Ramal' => 3551, 'Cargo' => 'Inspeção', 'Unidade' => 'Vitória', 'Setor' => 'Técnico em Segurança do Trabalho', 'Nome' => 'Emyle Almeida', 'Email' => 'emyle.almeida'),
          	77 => array('PHONE_CODE' => 127, 'PHONE_PASS' => 47227, 'PHONE_CALL' => null,'Ramal' => 3606, 'Cargo' => 'Higiene Ocupacional', 'Unidade' => 'Vitória', 'Setor' => 'Técnico em Segurança do Trabalho', 'Nome' => 'Felipe Batista', 'Email' => 'felipe.batista'),
            77 => array('PHONE_CODE' => 127, 'PHONE_PASS' => 47227, 'PHONE_CALL' => null,'Ramal' => 3606, 'Cargo' => 'Higiene Ocupacional', 'Unidade' => 'Vitória', 'Setor' => 'Técnico em Segurança do Trabalho', 'Nome' => 'Weberson Santos', 'Email' => 'weberson.santos'),
            //78 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => 3551, 'Cargo' => 'Inspeção', 'Unidade' => 'Vitória', 'Setor' => 'Técnico em Segurança do Trabalho', 'Nome' => 'Igor Bianchi', 'Email' => 'igor.bianchi'),
          	79 => array('PHONE_CODE' => 134, 'PHONE_PASS' => 52890, 'PHONE_CALL' => null,'Ramal' => 3557, 'Cargo' => 'Agendamento', 'Unidade' => 'Vitória', 'Setor' => 'Treinamentos', 'Nome' => 'Beatriz Crespo', 'Email' => 'beatriz.crespo'),
          	80 => array('PHONE_CODE' => 133, 'PHONE_PASS' => 52081, 'PHONE_CALL' => null,'Ramal' => 3606, 'Cargo' => 'Higiene Ocupacional', 'Unidade' => 'Vitória', 'Setor' => 'Técnico em Segurança do Trabalho', 'Nome' => 'Débora Monteiro', 'Email' => 'deborah.monteiro'),
          	81 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => null, 'Cargo' => 'Inspeção', 'Unidade' => 'Vitória', 'Setor' => 'Técnico em Segurança do Trabalho', 'Nome' => 'Ingrid Rubenich', 'Email' => 'ingrid.rubenich'),
          	83 => array('PHONE_CODE' => 123, 'PHONE_PASS' => 43991, 'PHONE_CALL' => null,'Ramal' => 3607, 'Cargo' => 'Laudo', 'Unidade' => 'Vitória', 'Setor' => 'Técnico em Segurança do Trabalho', 'Nome' => 'Karla Marques', 'Email' => 'karla.marques'),
          	84 => array('PHONE_CODE' => 113, 'PHONE_PASS' => 35901, 'PHONE_CALL' => null,'Ramal' => 3607, 'Cargo' => 'Documentação', 'Unidade' => 'Vitória', 'Setor' => 'Técnico em Segurança do Trabalho', 'Nome' => 'Amanda Rodrigues', 'Email' => 'amanda.rodrigues'),
          	85 => array('PHONE_CODE' => 111, 'PHONE_PASS' => 34283, 'PHONE_CALL' => null,'Ramal' => 3562, 'Cargo' => 'Documentação', 'Unidade' => 'Vitória', 'Setor' => 'Técnico em Segurança do Trabalho', 'Nome' => 'Júlio Félix', 'Email' => 'julio.felix'),
          	86 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => 3551, 'Cargo' => 'Enfermeiro', 'Unidade' => 'Vitória', 'Setor' => 'Enfermagem', 'Nome' => 'Igor Rocha', 'Email' => 'igor.rocha'),
            88 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => 3578, 'Cargo' => 'Suporte SOC', 'Unidade' => 'Vitória', 'Setor' => 'Tecnologia da Informação', 'Nome' => 'Ely Reis', 'Email' => 'ely.reis'),
          	90 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => 3579, 'Cargo' => 'Infraestrutura', 'Unidade' => 'Vitória', 'Setor' => 'Tecnologia da Informação', 'Nome' => 'Vinycius Alves', 'Email' => 'vinycius.alves'),
            93 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => 3557, 'Cargo' => 'Agendamento', 'Unidade' => 'Vitória', 'Setor' => 'Treinamentos', 'Nome' => 'Sabrina Oliveira', 'Email' => 'treinamentos'),

            94 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => null, 'Cargo' => 'Entregador', 'Unidade' => 'Vitória', 'Setor' => 'Expedição', 'Nome' => 'Entregador 1', 'Email' => 'entregador'),
            95 => array('PHONE_CODE' => null, 'PHONE_PASS' => null, 'PHONE_CALL' => null,'Ramal' => null, 'Cargo' => 'Entregador', 'Unidade' => 'Vitória', 'Setor' => 'Expedição', 'Nome' => 'Entregador 2', 'Email' => 'entregador2'),
          );

        //$users = explode(',', $users);

        foreach ($users as $key => $user) {

          //if($key > 5 && config('app.env') == 'local') {
            //break;
          //}

          //$faker = Faker\Factory::create();

          $userMail = User::where('email', '=', trim($user['Email']))->first();
          if ($userMail === null) {

              //$uName = str_replace(['@provider-es.com.br', '.'], ['', ' '], trim($userEmail));
              //$login= str_replace(['@provider-es.com.br', ' '], ['', '.'], trim($userEmail));
              //$uName = ucwords($uName);

              //$name = $uName;

              echo 'creating user '. $user['Nome'] . PHP_EOL;

              //$avatar = \Avatar::create($user['Nome'])->toBase64();

              $avatar = 'defaults/avatar.jpg';

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
                'birthday' => now(),
                'department_id'=> $department->id,
                'unit_id'=> $unit->id,
                'occupation_id'=> $occupation->id,
                'cpf' => '',
                'branch' => $user['Ramal'],
                'phone_code' => $user['PHONE_CODE'],
                'phone_password' => $user['PHONE_PASS'],
                'phone_callcenter_code' => $user['PHONE_CALL'],
              ]);

              $emailFormated = trim($user['Email']) . '@provider-es.com.br';

              $user = User::create([
                'nick'                           => $user['Email'],
                'email'                          => $emailFormated,
                //'password'                       => Hash::make('Provider@123'),
                'password'                       => Hash::make(str_random(20)),
                'avatar_type' => 'upload',
                'avatar' => $avatar,
                'person_id' => $person->id,
                'email_verified_at' => now(),
                'login_soc' => '',
                'password_soc' => '',
                'password_email' => 'Provider@123',
                'id_soc' => '',
                'api_token' => str_random(60),
                'change_password' => true
              ]);

              $user->attachRole($userRole);

              $permissionForRole = RoleDefaultPermissions::where('role_id', $userRole->id)
              ->pluck('permission_id');

              $user->syncPermissions($permissionForRole);

              $user->save();
          }

        }

    }
}
