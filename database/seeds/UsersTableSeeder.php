<?php

namespace Database\Seeds;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userRole = config('roles.models.role')::where('name', '=', 'User')->first();
        $adminRole = config('roles.models.role')::where('name', '=', 'Admin')->first();
        $permissions = config('roles.models.permission')::all();

        /*
         * Add Users
         *
         */
        if (config('roles.defaultUserModel')::where('email', '=', 'admin@admin.com')->first() === null) {
            $newUser = config('roles.defaultUserModel')::create([
                'name'     => 'Admin',
                'email'    => 'admin@admin.com',
                'password' => bcrypt('password'),
            ]);

            $newUser->attachRole($adminRole);
            foreach ($permissions as $permission) {
                $newUser->attachPermission($permission);
            }
        }

        if (config('roles.defaultUserModel')::where('email', '=', 'user@user.com')->first() === null) {
            $newUser = config('roles.defaultUserModel')::create([
                'name'     => 'User',
                'email'    => 'user@user.com',
                'password' => bcrypt('password'),
            ]);

            $newUser;
            $newUser->attachRole($userRole);
        }

        /*
adinuza.lopes
administrativo.gerencia
administrativo3
administrativo
aeliton.silva
aigline.pereira
alice.campos
aliny
anacarolina
andre.tavares
ariane.pina
arquivo
atendimento01
atendimento02
atendimento03
atendimento
atendimentocariacica
atendimentoserra
atendimentovilavelha2
autoglass
bianca.kaiser
carina
carlos
cesar.sousa
cintia.souza
coletacariacica
coletaserra
coletavilavelha2
coletavitoria
comercial01
comercial02
coordenacaosms
credenciamento01
credenciamento02
credenciamento03
credenciamento04
creuza.ribeiro
cristinete.silva
cyntia.celante
daniel.freitas
daniele
denise.pereira
deyvd
diegosouza
diretoria
dpessoal
ely.reis
emerson.pereira
enfermagem.autoglass
enfermagem
enfermagemdotrabalho
erli.junior
exames
expedicao01
expedicao02
faturamento.ti
faturamento
fellipe.freitas
fernanda.costalonga
fernando.rodrigues
financeiro
flavia
fono1
george.silva
geovani
germana.rodrigues
gestaocontratos
gizelle.rodrigues
gleice
gustavo.vieira
igor.rocha
itamar.nicolini
izabel
jelia.santos
jessica.nogueira
jorge.oliveira
jose.menon
joseth
jovem.aprendiz
karina.barteli
karoline.alves
katsciane.rodrigues
laboratorio
leonardo.araujo
liberacao01
liberacao02
liberacao03
liberacao04
liberacao05
liberacao06
luana.melo
lucas.santos
luciana.rocha
luiz.souza
marianacoelho
marketing
mauriciodallorto
mayko.bernard
nadine.lodi
paola.neves
paula.albertino
paulo.vinicius
pericias
processos
psicologia01
psicologia02
rebeca
renan
renato.benedito
rh
roberto.melo
rodrigo.alcides
sabrina.vieira
samuel.medeiros
simone.coelho
solange.jesus
suelem.vitor
suporteti
suzanne.paula
tecnico10
tecnico11
tecnico12
tecnico14
tecnico19
tecnico20
tecnico21
tecnico22
tecnico27
tecnico28
tecnico29
tecnico2
tecnico30
tecnico4
tecnico5
telefonista
treinamentos
umap02
vinycius.alves
vivianeamorim
vivyane.oliveira
wesley.damasio
weslley.lucio
        */
    }
}
