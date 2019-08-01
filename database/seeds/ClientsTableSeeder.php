<?php

use Illuminate\Database\Seeder;
use App\Models\{Client, Contract};
use App\Models\Client\{Email, Phone, Employee, Occupation};

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /*factory('App\Models\Client', 5)
        ->create()
        ->each(function ($client) {
            $client->addresses()->save(factory(App\Models\Client\Address::class)->make());
            $client->employees()->save(factory(App\Models\Client\Employee::class)->make());
            $client->employees()->save(factory(App\Models\Client\Employee::class)->make());
            $client->employees()->save(factory(App\Models\Client\Employee::class)->make());
        });;*/

      $array = array(
        array(
            "Código" => 522506,
            "Empresa" => " AMG MEDICINA E SAUDE (SOCNET) ",
            "E-mail.Contato" => "",
            "CNPJ" => "",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONVENIOS SOCNET"),
        array(
            "Código" => 433664,
            "Empresa" => "(NÃO USAR) HORTIGIL HORTIFRUTI S/A ",
            "E-mail.Contato" => "",
            "CNPJ" => "31.487.473/0001-99",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 409278,
            "Empresa" => "*MRV PRINCIPAL (SOCNET) ",
            "E-mail.Contato" => "",
            "CNPJ" => "",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONVENIOS SOCNET"),
        array(
            "Código" => 682401,
            "Empresa" => "2 M SUPRIMENTOS ",
            "E-mail.Contato" => "recepcao@2msuprimentos.com.br
    ",
            "CNPJ" => "10.489.855/0001-81",
            "Tel.Contato" => "(27) 3327-2844
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 319684,
            "Empresa" => "3 RDS INSTALACAO E MANUTENCAO DE EQUIPAMENTOS PARA GAS",
            "E-mail.Contato" => "fabiane.bulhoes@rdsgas.com.br
    ",
            "CNPJ" => "21.518.132/0001-80",
            "Tel.Contato" => "(27) 3072-7816
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 668819,
            "Empresa" => "5 ESTRELAS SPECIAL SERVICE SUL SUDESTE SERVICOS DE LIMPEZA",
            "E-mail.Contato" => "contasapagar@5ss.com.br
    ",
            "CNPJ" => "11.312.655/0002-00",
            "Tel.Contato" => "(62) 3230-2823
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 504396,
            "Empresa" => "A B CONSTRUTORA E EMPREENDIMENTOS EIRELI",
            "E-mail.Contato" => "financeiro@abconstrutora.com
    compras@abconstrutora.com
    ",
            "CNPJ" => "00.541.981/0001-84",
            "Tel.Contato" => "
    (27) 3025-7999
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 244936,
            "Empresa" => "A F COMERCIO E TURISMO EIRELI - EPP - HARUS MOTEL",
            "E-mail.Contato" => "contatos@harusmotel.com.br
    vizzoni@ig.com.br
    ",
            "CNPJ" => "02.607.151/0001-38",
            "Tel.Contato" => "(27) 3338-7005
    (27) 3389-3417
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 580729,
            "Empresa" => "A L M SUPERMERCADOS EIRELI - SUP. NOROESTE",
            "E-mail.Contato" => "",
            "CNPJ" => "26.581.947/0001-27",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 602020,
            "Empresa" => "A. B. MOVEIS E DECORACOES LTDA ",
            "E-mail.Contato" => "tellescontabilidade@terra.com.br",
            "CNPJ" => "07.767.448/0001-84",
            "Tel.Contato" => "(27) 3345-3431, (27) 3223-2368, (27) 3075-8383",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 579776,
            "Empresa" => "JP BAR E RESTAURANTE ",
            "E-mail.Contato" => "jprestaurante2015@gmail.com",
            "CNPJ" => "28.552.931/0001-11",
            "Tel.Contato" => "(27) 99285-2646",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 245325,
            "Empresa" => "AB COMERCIO DE VEICULOS LTDA (OSAKA)",
            "E-mail.Contato" => "",
            "CNPJ" => "07.124.577/0001-54",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 279788,
            "Empresa" => "ACIMAQ EQUIPAMENTOS INDUSTRIAIS E COMERCIAIS LTDA ",
            "E-mail.Contato" => "rh@acimaq.com.br",
            "CNPJ" => "31.780.992/0001-40",
            "Tel.Contato" => "(27) 3346-5132",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 387605,
            "Empresa" => "TRANSPORTES PALMEIRA",
            "E-mail.Contato" => "",
            "CNPJ" => "21.773.582/0001-19",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 502539,
            "Empresa" => "HOSPITAL SANTA RITA DE CASSIA ",
            "E-mail.Contato" => "sesmt@santarita.org.brafecc@santarita.org.br",
            "CNPJ" => "28.137.925/0001-06",
            "Tel.Contato" => "(27) 3334-8104, (27) 3334-8058",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 508391,
            "Empresa" => "AGIL EDIFICACOES E EMPREENDIMENTOS LTDA",
            "E-mail.Contato" => "natan09@live.com",
            "CNPJ" => "21.111.675/0001-88",
            "Tel.Contato" => "(27) 99632-5550",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 620632,
            "Empresa" => "AGIMED MEDICINA OCUPACIONAL LTDA - ME",
            "E-mail.Contato" => "sac@omnilink.com.br, sac@omnilink.com.br
    ",
            "CNPJ" => "23.801.569/0001-51",
            "Tel.Contato" => "(11) 2729-0198
    (11) 3025-0304
    ",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 354427,
            "Empresa" => "AGORACRED S/A SOCIEDADE DE CREDITO",
            "E-mail.Contato" => "aretuza.robadel@agoracred.com.br
    natache.barros@agoracred.com.br
    ",
            "CNPJ" => "36.321.990/0001-07",
            "Tel.Contato" => "(27) 4009-0213
    (27) 4009-0200
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 423048,
            "Empresa" => "AGOSTINHO MIRANDA ROCHA (CARTONAGEM ROCHA)",
            "E-mail.Contato" => "adm@cartonagemrocha.com.br
    cartonagemmaifredo@gmail.com
    ",
            "CNPJ" => "27.914.036/0001-37",
            "Tel.Contato" => "(27) 3244-5081
    (27) 99851-2908
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 522512,
            "Empresa" => "AGR CONSTRUCOES EIRELI ",
            "E-mail.Contato" => "",
            "CNPJ" => "04.740.879/0001-69",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 653975,
            "Empresa" => "PRODUTOS AGUA NA BOCA",
            "E-mail.Contato" => "kayena_alimentos@hotmail.com
    ",
            "CNPJ" => "36.337.756/0001-78",
            "Tel.Contato" => "(27) 3391-5235
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 586990,
            "Empresa" => "ALBERTO DE FREITAS PADILHA (SO GRANITOS)",
            "E-mail.Contato" => "",
            "CNPJ" => "31.484.512/0001-02",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 513694,
            "Empresa" => "SAUDE E PREVENCAO - CORPORATIVO",
            "E-mail.Contato" => "corporativo@globo.com
    ",
            "CNPJ" => "29.018.680/0001-52",
            "Tel.Contato" => "(27) 3019-4138
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 604170,
            "Empresa" => "ALFA CALDEIRARIA E MONTAGENS LTDA ",
            "E-mail.Contato" => "diego.santos@alfacal.com.br
    frederico.farias@alfacal.com.br
    sabrina.coelho@alfacal.com.br
    sergio.silva@alfacal.com.br
    ",
            "CNPJ" => "65.285.462/0004-90",
            "Tel.Contato" => "(37) 3249-4111
    (37) 3249-4111
    (37) 3249-4111
    (27) 3249-4111
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 513508,
            "Empresa" => "ALIMENTOS TRIGOMAIS INDUSTRIA E COMERCIO LTDA ",
            "E-mail.Contato" => "dg.zuc@hotmail.com
    TRIGOMAIS@HOTMAIL.COM
    ",
            "CNPJ" => "09.172.048/0001-51",
            "Tel.Contato" => "(27) 3218-1411
    (27) 99850-1461
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 435305,
            "Empresa" => "ALPHA-LIFE ASSESSORIA OCUPACIONAL LTDA - EPP",
            "E-mail.Contato" => "comercial@alphalife.com.br
    ",
            "CNPJ" => "04.635.209/0001-82",
            "Tel.Contato" => "(11) 4193-6851
    ",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 245268,
            "Empresa" => "ALTA ELEVADORES LTDA - ME ",
            "E-mail.Contato" => "financeiro@altaelevadores.com.br
    eliana@altaelevadores.com.br
    ",
            "CNPJ" => "10.749.921/0001-05",
            "Tel.Contato" => "(27) 3023-7063
    (27) 3023-7063
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 260839,
            "Empresa" => "ALVALARDE FOODS INDUSTRIA E COMERCIO EIRELI ",
            "E-mail.Contato" => "rh1@alvalarde.com.br
    ",
            "CNPJ" => "16.581.801/0001-28",
            "Tel.Contato" => "(27) 3344-9230
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 364101,
            "Empresa" => "AMARA BRASIL LTDA",
            "E-mail.Contato" => "cristiane.carvalho@amaraedp.com.br
    gpessoa@amarabrasil.com.br
    ",
            "CNPJ" => "02.857.954/0001-40",
            "Tel.Contato" => "
    (27) 3344-2684
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 510818,
            "Empresa" => "AMERICA SERVICOS E COMERCIO LTDA (GLAMOUR MODA SEXY)",
            "E-mail.Contato" => "vitel.desinsetizacao@hotmail.com
    ",
            "CNPJ" => "10.546.496/0001-57",
            "Tel.Contato" => "(27) 3226-5380
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 356671,
            "Empresa" => "MEDIC SERVICES (AMERICANA ASSESSORIA)",
            "E-mail.Contato" => "NATALIA@DIRECTASERV.COM.BR",
            "CNPJ" => "
    ",
            "Tel.Contato" => "02.435.349/0001-81",
            "Sub Grupo" => "CONVENIOS",
            "undefined" => "CONVENIOS"),
        array(
            "Código" => 514926,
            "Empresa" => "AMG MEDICINA E SAUDE OCUPACIONAL LTDA ",
            "E-mail.Contato" => "",
            "CNPJ" => "29.684.442/0001-86",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 358429,
            "Empresa" => "ANDRAQUE CONSTRUCAO CIVIL LTDA - ME ",
            "E-mail.Contato" => "andraque2012@yahoo.com.br
    andraque2012@yahoo.com.br
    ",
            "CNPJ" => "14.785.169/0001-09",
            "Tel.Contato" => "(41) 3365-0305
    (41) 98456-3866
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 678561,
            "Empresa" => "APAE DE VILA VELHA - ASSOCIACAO DE PAIS E AMIGOS",
            "E-mail.Contato" => "",
            "CNPJ" => "05.768.616/0001-20",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 486966,
            "Empresa" => "ARAPONGAS S BAR E RESTAURANTE - ME ",
            "E-mail.Contato" => "luizpauloghisolfi1@hotmail.com
    ",
            "CNPJ" => "28.471.761/0001-40",
            "Tel.Contato" => "(27) 3226-2975
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 244881,
            "Empresa" => "ARTECA VITORIA IMPORTACAO E EXPORTACAO LTDA",
            "E-mail.Contato" => "carlaarteca@gmail.com
    ",
            "CNPJ" => "03.446.617/0001-23",
            "Tel.Contato" => "(27) 3533-1259
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 389538,
            "Empresa" => "ARUBA MOTEL LTDA - ME ",
            "E-mail.Contato" => "vizzoni@ig.com.br
    ",
            "CNPJ" => "27.339.050/0001-54",
            "Tel.Contato" => "(27) 3389-3417
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 354814,
            "Empresa" => "ASONET Qualidade, Vida e (SOCNET) ",
            "E-mail.Contato" => "",
            "CNPJ" => "",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONVENIOS SOCNET"),
        array(
            "Código" => 630480,
            "Empresa" => "ASSOC. DOS VAREJISTAS DO ESPIRITO SANTO - AVAES ",
            "E-mail.Contato" => "rh01@centraldecompras.com.br
    ",
            "CNPJ" => "30.978.506/0001-30",
            "Tel.Contato" => "(27) 2121-1929
    ",
            "Sub Grupo" => "CLIENTES AVULSO"),
        array(
            "Código" => 628492,
            "Empresa" => "ASSOCIACAO BRASILEIRA DE ODONTOLOGIA E S -  ABO ES  ",
            "E-mail.Contato" => "financeiro@aboes.org.br
    ",
            "CNPJ" => "27.242.833/0001-15",
            "Tel.Contato" => "(27) 3395-1455
    ",
            "Sub Grupo" => "CLIENTES AVULSO"),
        array(
            "Código" => 244917,
            "Empresa" => "ASSOCIACAO DE ENSINO INTEGRADO E ORGANIZADO UNIVERSITARIO ",
            "E-mail.Contato" => "tesouraria@pioxii-es.com.br
    ",
            "CNPJ" => "39.780.473/0001-94",
            "Tel.Contato" => "(27) 3329-5950
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 570931,
            "Empresa" => "ASSOCIACAO DOS MAGISTRADOS DO ESPIRITO SANTO",
            "E-mail.Contato" => "FINANCEIRO@AMAGES.ORG.BR
    ",
            "CNPJ" => "27.053.685/0001-90",
            "Tel.Contato" => "(27) 3345-9707
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 244994,
            "Empresa" => "ASSOCIACAO DOS OFICIAIS MILITARES DO ESPIRITO SANTO",
            "E-mail.Contato" => "mercia@assomes.com.br
    ",
            "CNPJ" => "27.557.909/0001-00",
            "Tel.Contato" => "(27) 3227-2585
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 343846,
            "Empresa" => "HOSP ESTADUAL DR. JAYME SANTOS NEVES ",
            "E-mail.Contato" => "andre.rebello@hejsn.aebes.org.br
    denise.monfardini@hejsn.aebes.org.br
    ",
            "CNPJ" => "28.127.926/0002-42",
            "Tel.Contato" => "(27) 2121-3707
    (27) 2121-3707
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 605076,
            "Empresa" => "AT FISIOTERAPIA CAPIXABA LTDA",
            "E-mail.Contato" => "financeiro@biosete.com.br
    administrativo@biosete.com.br
    ",
            "CNPJ" => "30.433.293/0001-61",
            "Tel.Contato" => "(27) 98865-8380
    (27) 99983-5880
    ",
            "Sub Grupo" => "CLIENTES AVULSO"),
        array(
            "Código" => 667605,
            "Empresa" => "ATENDER RIO TRANSPORTES LTDA",
            "E-mail.Contato" => "ronaldo.ferraz@marlogbrasil.com.br
    wemerson50@hotmail.com
    ",
            "CNPJ" => "03.931.563/0001-91",
            "Tel.Contato" => "(11) 99303-7790
    (27) 99784-9750
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 357677,
            "Empresa" => "ATISM INFORMATICA LTDA-ME ",
            "E-mail.Contato" => "financeiro@smsolucoes.com.br
    ",
            "CNPJ" => "18.074.251/0001-86",
            "Tel.Contato" => "(27) 3019-1899
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 595648,
            "Empresa" => "GRUPO ORLETTI - ATLANTICA",
            "E-mail.Contato" => "",
            "CNPJ" => "21.439.992/0001-28",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 244756,
            "Empresa" => "AUTO POSTO PRESIDENTE LTDA",
            "E-mail.Contato" => "postopresidente1@hotmail.com
    ",
            "CNPJ" => "39.400.494/0001-37",
            "Tel.Contato" => "(27) 3314-0083
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 244898,
            "Empresa" => "AUTO POSTO SANTA PAULA LTDA ",
            "E-mail.Contato" => "postomaruipe@hotmail.com
    ",
            "CNPJ" => "08.589.031/0001-31",
            "Tel.Contato" => "(27) 3222-4802
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 244534,
            "Empresa" => "AUTO POSTO SAO PEDRO LTDA ",
            "E-mail.Contato" => "saopedro.rpresidente@gmail.com
    p4.saopedro@gmail.com
    ",
            "CNPJ" => "05.463.954/0001-54",
            "Tel.Contato" => "(27) 3329-9789
    (27) 3329-9789
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 554182,
            "Empresa" => "AUTO POSTO TRIVELA EIRELI ",
            "E-mail.Contato" => "ruanloyola@cantilever.vix.br
    ",
            "CNPJ" => "21.899.379/0001-93",
            "Tel.Contato" => "(27) 98115-6968
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 487414,
            "Empresa" => "AUTO SERVICO FAE LTDA ",
            "E-mail.Contato" => "rh@supermercadofae.com.br
    ",
            "CNPJ" => "39.339.551/0001-10",
            "Tel.Contato" => "(27) 3041-5179
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 375771,
            "Empresa" => "AUTO SERVICO PEIXOTO LTDA ",
            "E-mail.Contato" => "serrasede@gruporedeshow.com
    karina.teixeira@gruporedeshow.com
    ",
            "CNPJ" => "35.973.239/0001-22",
            "Tel.Contato" => "(27) 3251-1264
    (27) 3251-1264
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 393331,
            "Empresa" => "BABY KIDS - EIRELI - EPP (MAMY BABY - KIDS)",
            "E-mail.Contato" => "financeiro@mamybaby.com.br
    ",
            "CNPJ" => "04.940.465/0001-83",
            "Tel.Contato" => "(27) 3024-0564
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 423515,
            "Empresa" => "BABY MOTEL LTDA ME",
            "E-mail.Contato" => "baby@babymotel.com.br
    ",
            "CNPJ" => "31.804.016/0001-80",
            "Tel.Contato" => "(27) 3228-0922
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 527906,
            "Empresa" => "BECALMA SILVA DE CARVALHO GUMIEIRO (MERCEARIA GEBE)",
            "E-mail.Contato" => "merceariagebe@hotmail.com
    ",
            "CNPJ" => "31.738.859/0001-26",
            "Tel.Contato" => "(27) 3396-3613
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 388898,
            "Empresa" => "BELA ISCHIA ALIMENTOS LTDA ",
            "E-mail.Contato" => "cristina.rocha@belaischia.com.br
    ",
            "CNPJ" => "01.130.631/0005-11",
            "Tel.Contato" => "(32) 3451-3907
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 567691,
            "Empresa" => "JEQUIT BAR E RESTAURANTE ",
            "E-mail.Contato" => "",
            "CNPJ" => "16.937.348/0001-40",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 582124,
            "Empresa" => "BELLIZ INDUSTRIA, COMERCIO, IMPORTACAO E EXPORTACAO EIRELI",
            "E-mail.Contato" => "mayara.xavier@bellizcompany.com.br
    ",
            "CNPJ" => "06.940.040/0001-08",
            "Tel.Contato" => "(27) 3322-0030
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 245152,
            "Empresa" => "BENCORP MEDICINA",
            "E-mail.Contato" => "",
            "CNPJ" => "14.574.632/0001-73",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 245096,
            "Empresa" => "BERTEK PRODUTOS, SERVICOS E MINERACAO LTDA ",
            "E-mail.Contato" => "rh@stilecomercial.com.br
    ",
            "CNPJ" => "11.729.330/0001-39",
            "Tel.Contato" => "(27) 2121-5600
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 422651,
            "Empresa" => "BETUME GRANDE VITORIA LTDA ",
            "E-mail.Contato" => "seguranca.trabalho@brasitalia.com.br
    ",
            "CNPJ" => "09.637.144/0001-28",
            "Tel.Contato" => "(27) 3246-0400
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 589292,
            "Empresa" => "BIG AMERICAN BURGER LTDA ",
            "E-mail.Contato" => "amanda@bigamericanburger.com
    ",
            "CNPJ" => "19.306.568/0001-63",
            "Tel.Contato" => "(27) 3343-2707
    ",
            "Sub Grupo" => "CONTRATOS EXAMES - AVULSO"),
        array(
            "Código" => 532206,
            "Empresa" => "BIO CENTRO - BIO OCUPACIONAL MEDICINA E SEGURANCA ",
            "E-mail.Contato" => "",
            "CNPJ" => "07.654.637/0001-40",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 522505,
            "Empresa" => "Biocentro Minas [Empresa (SOCNET) ",
            "E-mail.Contato" => "",
            "CNPJ" => "",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONVENIOS SOCNET"),
        array(
            "Código" => 682226,
            "Empresa" => "BIOCEV PROJETOS INTELIGENTES ",
            "E-mail.Contato" => "mayra.rodesky@biocev.net
    ",
            "CNPJ" => "07.080.828/0001-46",
            "Tel.Contato" => "(31) 3293-5163
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 569764,
            "Empresa" => "LUZ & TON",
            "E-mail.Contato" => "financeiro2@bless.ind.br
    administrativo@bless.ind.br
    ",
            "CNPJ" => "14.934.850/0001-71",
            "Tel.Contato" => "(27) 3013-7078
    (27) 3141-5670
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 533064,
            "Empresa" => "SUPERMERCADO REDE SHOW ",
            "E-mail.Contato" => "rh@blincolredeshow.com.br
    nucleo@gruporedeshow.com
    ",
            "CNPJ" => "39.368.923/0001-36",
            "Tel.Contato" => "(27) 3251-1278
    (27) 3282-1416
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 245150,
            "Empresa" => "BLUE BAY COMERCIAL LTDA",
            "E-mail.Contato" => "eliete@bluebay.com.br
    ",
            "CNPJ" => "04.078.965/0006-62",
            "Tel.Contato" => "(27) 2124-4600
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 245376,
            "Empresa" => "BLUE CENTER COMERCIO DE ROUPAS LTDA",
            "E-mail.Contato" => "eliete.antonio@bluebay.com.br
    ",
            "CNPJ" => "11.517.820/0001-71",
            "Tel.Contato" => "(27) 2124-4600
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 245365,
            "Empresa" => "BMGR VEICULOS LTDA - HIRO MOTORS",
            "E-mail.Contato" => "ana.neves@hiromotors.com.br
    ",
            "CNPJ" => "12.426.910/0001-10",
            "Tel.Contato" => "(27) 3334-3836
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 237262,
            "Empresa" => "BMPC GESTÃO EM (SOCNET) ",
            "E-mail.Contato" => "",
            "CNPJ" => "64.183.346/0001-55",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONVENIOS SOCNET"),
        array(
            "Código" => 679583,
            "Empresa" => "BMR SYSTEMS LTDA",
            "E-mail.Contato" => "",
            "CNPJ" => "18.716.101/0001-29",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 245175,
            "Empresa" => "BOA PRACA IMPORTADORA E EXPORTADORA LTDA",
            "E-mail.Contato" => "karlla@boapraca.com.br
    lara@boapraca.com.br
    ",
            "CNPJ" => "39.786.504/0001-14",
            "Tel.Contato" => "(27) 3357-1450
    (27) 3357-1400
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 291016,
            "Empresa" => " BRASIGRAN BRASILEIRA DE GRANITOS LTDA   ",
            "E-mail.Contato" => "financeiro@brasigran.com.br
    ddoring@brasigran.com.br
    seguranca@brasigran.com.br
    ipboliveira@brasigran.com.br
    vscosta@brasigran.com.br
    ",
            "CNPJ" => "32.476.525/0001-94",
            "Tel.Contato" => "
    (27) 2124-4700
    (27) 2124-4700

    (27) 2124-4700
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 266299,
            "Empresa" => "BRASIL CARGO TRANSPORTES LTDA",
            "E-mail.Contato" => "financeiro@brasilcargolog.com.br
    rhbrasilcargo@terra.com.br
    ",
            "CNPJ" => "03.944.455/0001-53",
            "Tel.Contato" => "(27) 3354-0569
    (27) 3396-5949
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 244804,
            "Empresa" => "BRASIL EXPORTACAO DE MARMORES E GRANITOS LTDA ",
            "E-mail.Contato" => "mizael@brasilexp.com.br
    ",
            "CNPJ" => "28.490.043/0001-11",
            "Tel.Contato" => "(27) 2121-8888
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 422654,
            "Empresa" => "BRASITALIA - AGREGADOS PARA CONSTRUCAO LTDA ",
            "E-mail.Contato" => "seguranca.trabalho@brasitalia.com.br
    ",
            "CNPJ" => "27.169.879/0001-56",
            "Tel.Contato" => "(27) 3246-0400
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 580638,
            "Empresa" => "BRESSAN ELETRODIESEL LTDA ",
            "E-mail.Contato" => "rh@bressan.com.br
    ",
            "CNPJ" => "27.401.272/0001-50",
            "Tel.Contato" => "(27) 2121-2085
    ",
            "Sub Grupo" => "CLIENTES AVULSO"),
        array(
            "Código" => 503364,
            "Empresa" => "BWR COMERCIO DE PECAS E SERVICOS LTDA ",
            "E-mail.Contato" => "bwrmecanica@uol.com.br
    ",
            "CNPJ" => "19.831.424/0001-26",
            "Tel.Contato" => "(27) 3346-6600
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 515096,
            "Empresa" => "C & S - CONSULTORIA LTDA",
            "E-mail.Contato" => "atendimento@cesconsult.com.br
    ",
            "CNPJ" => "05.789.043/0001-11",
            "Tel.Contato" => "(27) 3337-8698
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 568601,
            "Empresa" => "C.S.E. - MECANICA E INSTRUMENTACAO S.A. ",
            "E-mail.Contato" => "luis@csemil.com
    paulo.polonini@csemil.com.br
    ",
            "CNPJ" => "78.559.440/0004-13",
            "Tel.Contato" => "(27) 4062-8078
    (27) 4062-8078
    ",
            "Sub Grupo" => "CLIENTES AVULSO"),
        array(
            "Código" => 415156,
            "Empresa" => "CABLE ENGENHARIA LTDA - EPP ",
            "E-mail.Contato" => "klauss@cableengenharia.com.br
    ",
            "CNPJ" => "00.900.562/0001-91",
            "Tel.Contato" => "(27) 98119-8620
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 358381,
            "Empresa" => "CAEL SERVICOS E CONSTRUCOES EIRELI ",
            "E-mail.Contato" => "edilaine.vitoria@caelnet.com.br
    isabel.vitoria@caelnet.com.br
    isabel.vitoria@caelnet.com.br
    ",
            "CNPJ" => "73.433.559/0001-89",
            "Tel.Contato" => "(27) 3314-1750
    (27) 3314-1750
    (27) 3314-1750
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 416022,
            "Empresa" => "CAFE ABS COMERCIO DE ALIMENTOS LTDA - ME / CAFE TABACO  ",
            "E-mail.Contato" => "alicecgsa@outlook.com
    absjoaquim@gmail.com
    ",
            "CNPJ" => "26.689.145/0001-35",
            "Tel.Contato" => "(27) 99518-3581
    (27) 3029-0406
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 416026,
            "Empresa" => "CAFE CAJU COMERCIO DE ALIMENTOS LTDA - ME / CAFE TABACO",
            "E-mail.Contato" => "alicecgsa@outlook.com
    ",
            "CNPJ" => "23.628.288/0001-49",
            "Tel.Contato" => "(27) 99518-3581
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 565489,
            "Empresa" => "CAA - ES",
            "E-mail.Contato" => "rh@caaes.com.br
    ",
            "CNPJ" => "28.414.597/0001-30",
            "Tel.Contato" => "(27) 3232-3600
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 537365,
            "Empresa" => "CALCADOS BEBECE LTDA",
            "E-mail.Contato" => "jpolima@bebece.com.br
    ",
            "CNPJ" => "90.445.206/0005-41",
            "Tel.Contato" => "(51) 9964-2676
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 381035,
            "Empresa" => "CALCADOS ITAPUA S/A - CISA",
            "E-mail.Contato" => "dp@itapua.com
    ",
            "CNPJ" => "27.177.096/0031-30",
            "Tel.Contato" => "(27) 2124-7729
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 477748,
            "Empresa" => "CAMPIMED SAUDE OCUPACIONA",
            "E-mail.Contato" => "",
            "CNPJ" => "21.409.726/0001-52",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 271783,
            "Empresa" => "CAMPO VERDE",
            "E-mail.Contato" => "amorim@assergro.com.br
    ",
            "CNPJ" => "05.574.282/0001-54",
            "Tel.Contato" => "(27) 2121-0800
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 578429,
            "Empresa" => "CANTILEVER SEGURANCA E MEIO AMBIENTE ",
            "E-mail.Contato" => "ruanloyola@cantilever.vix.br
    ",
            "CNPJ" => "31.576.346/0001-66",
            "Tel.Contato" => "(27) 98115-6968
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 382232,
            "Empresa" => "CANTO DO SABOR LTDA - ME",
            "E-mail.Contato" => "REGISTRO@TELLESCONTABILIDADE.CNT.BR, dp3@tellescontabilidade.com.br",
            "CNPJ" => "04.935.142/0001-00",
            "Tel.Contato" => "(27) 3223-2368, (27) 99759-6797",
            "Sub Grupo" => "CONTRATOS EXAMES",
            "undefined" => "CONTRATOS EXAMES"),
        array(
            "Código" => 340392,
            "Empresa" => "CAPER SERVICOS CORPORATIVOS LTDA - EPP ",
            "E-mail.Contato" => "",
            "CNPJ" => "09.336.584/0001-45",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS EXAMES - AVULSO"),
        array(
            "Código" => 384646,
            "Empresa" => "CAPIXABA SEGURANCA E VIGILANCIA LTDA",
            "E-mail.Contato" => "sesmt@seiinteligencia.com.br
    ",
            "CNPJ" => "05.040.410/0001-80",
            "Tel.Contato" => "(27) 3328-7228
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 385134,
            "Empresa" => "CARDIO LIFE COMERCIO E IMPORTACAO DE MATERIAIS MEDICOS LTD",
            "E-mail.Contato" => "rh@cardiolife.com.br
    ",
            "CNPJ" => "08.901.144/0001-20",
            "Tel.Contato" => "(27) 3325-8627
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 651766,
            "Empresa" => "CARGOFRIO LOGISTICA",
            "E-mail.Contato" => "mariel.lopes@grupomontesion.com.br
    ",
            "CNPJ" => "16.585.456/0001-09",
            "Tel.Contato" => "(27) 3354-0696
    ",
            "Sub Grupo" => "CONTRATOS EXAMES - AVULSO"),
        array(
            "Código" => 486590,
            "Empresa" => "CARIBE MOTEL LTDA - EPP ",
            "E-mail.Contato" => "phvmatias@gmail.com
    ",
            "CNPJ" => "39.363.106/0001-95",
            "Tel.Contato" => "(27) 99700-9577
    ",
            "Sub Grupo" => "CLIENTES AVULSO"),
        array(
            "Código" => 464837,
            "Empresa" => "CARLOS PEREIRA ADVOGADOS ",
            "E-mail.Contato" => "ediliz@caperbrasil.com.br
    ",
            "CNPJ" => "05.625.493/0001-79",
            "Tel.Contato" => "(27) 3201-3123
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 350943,
            "Empresa" => "CARREFOUR COMERCIO E INDUSTRIA LTDA ",
            "E-mail.Contato" => "dynamene_maria_carvalho_fernandes@carrefour.com
    luiz_fernando_roque_de_souza@carrefour.com
    ",
            "CNPJ" => "45.543.915/0001-81",
            "Tel.Contato" => "(21) 3755-2698
    (21) 99867-9160
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 244655,
            "Empresa" => "CASA ALVES",
            "E-mail.Contato" => "",
            "CNPJ" => "03.245.244/0001-22",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 524345,
            "Empresa" => "CASA DE BICHO SERVICOS VETERINARIOS LTDA ",
            "E-mail.Contato" => "michellizucoloto@gmail.com
    ",
            "CNPJ" => "17.309.281/0001-61",
            "Tel.Contato" => "(27) 99232-7529
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 332008,
            "Empresa" => "CASA DO ADUBO S.A",
            "E-mail.Contato" => "martins.felipe@casadoadubo.com.br
    ferreira.igor@casadoadubo.com.br
    ",
            "CNPJ" => "28.138.113/0001-77",
            "Tel.Contato" => "
    (27) 3346-4657
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 313681,
            "Empresa" => "CATUABA INDUSTRIA DE BEBIDAS S/A  - BEBIDAS REGIANI",
            "E-mail.Contato" => "rh@reggiani.ind.br
    ",
            "CNPJ" => "31.470.024/0001-38",
            "Tel.Contato" => "(27) 3434-3408
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 462848,
            "Empresa" => "CBR AUTO ELETRICA LTDA - ME",
            "E-mail.Contato" => "cbr.autoeletrica@bol.com.br
    cbr.autoeletrica@bol.com.br
    ",
            "CNPJ" => "09.135.210/0001-61",
            "Tel.Contato" => "(27) 3343-2944
    (27) 3343-3138
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 353207,
            "Empresa" => "CCA INFORMATICA",
            "E-mail.Contato" => "",
            "CNPJ" => "05.258.552/0001-18",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 680590,
            "Empresa" => "CENTRAL",
            "E-mail.Contato" => "",
            "CNPJ" => "27.751.320/0001-30",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 245103,
            "Empresa" => "CDI - CENTRO DE DIAGNOSTICO POR IMAGEM LTDA ",
            "E-mail.Contato" => "eunice.sousa@cdivitoria.com.br
    segurancadotrabalho@cdivitoria.com.br
    vivian.lopes@cdivitoria.com.br
    ",
            "CNPJ" => "31.752.272/0001-71",
            "Tel.Contato" => "(27) 3334-1359
    (27) 3334-1353
    (27) 3334-1352
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 429461,
            "Empresa" => "SINEPE - CECAP",
            "E-mail.Contato" => "rsantosneves@crescerphd.com.br
    rhphd@crescerphd.com.br
    ",
            "CNPJ" => "04.852.063/0001-27",
            "Tel.Contato" => "(27) 98127-0990
    (27) 3038-0199
    ",
            "Sub Grupo" => "CONTRATOS EXAMES - AVULSO"),
        array(
            "Código" => 534189,
            "Empresa" => "CEDOV OCUPACIONAL S/C LTDA ",
            "E-mail.Contato" => "financeiro@cedov.com.br
    ",
            "CNPJ" => "05.401.744/0001-31",
            "Tel.Contato" => "(33) 3271-8315
    ",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 347560,
            "Empresa" => "CENTRAL DE NEGOCIOS AMBIENTAIS LTDA - EPP ",
            "E-mail.Contato" => "negociosambientais@gmail.com
    ",
            "CNPJ" => "08.649.427/0001-27",
            "Tel.Contato" => "(27) 32224-4481
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 545456,
            "Empresa" => "CENTRO DE EDUCACAO INFANTIL RECRIAR LTDA ",
            "E-mail.Contato" => "kellymilli@hotmail.com
    adm.cei.recriar@hotmail.com
    ",
            "CNPJ" => "12.708.961/0001-34",
            "Tel.Contato" => "
    (27) 3019-9398
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 399825,
            "Empresa" => "SINEPE - CENTRO DE ENSINO CACHOEIRENSE DARWIN (MATRIZ)",
            "E-mail.Contato" => "lorenacentraldarwin@hotmail.com
    ",
            "CNPJ" => "03.597.050/0001-96",
            "Tel.Contato" => "(27) 3315-8072
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 399821,
            "Empresa" => "DARWIN COLATINA    ",
            "E-mail.Contato" => "",
            "CNPJ" => "03.597.050/0005-10",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 398994,
            "Empresa" => "CENTRO DE ENSINO FUNDAMENTAL E MÉDIO DARWIN ARACRUZ LTDA ",
            "E-mail.Contato" => "gilianebenvindo@darwin.com.br
    ",
            "CNPJ" => "08.287.917/0001-20",
            "Tel.Contato" => "(27) 3250-1268
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 245077,
            "Empresa" => "CENTRO DO COMERCIO DE CAFE DE VITORIA ",
            "E-mail.Contato" => "financeiro@cccv.org.br
    ",
            "CNPJ" => "28.143.667/0001-62",
            "Tel.Contato" => "(27) 3235-2311
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 309268,
            "Empresa" => "CENTRO EDUCACIONAL CHARLES DARWIN LTDA ",
            "E-mail.Contato" => "keile@darwin.com.br
    ",
            "CNPJ" => "36.049.104/0001-38",
            "Tel.Contato" => "(27) 3212-5014
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 565662,
            "Empresa" => "CENTRO EDUCACIONAL ERLACH LTDA",
            "E-mail.Contato" => "ceerlach@globomail.com
    ",
            "CNPJ" => "36.332.138/0001-35",
            "Tel.Contato" => "(27) 3339-7395
    ",
            "Sub Grupo" => "CONTRATOS EXAMES - AVULSO"),
        array(
            "Código" => 393731,
            "Empresa" => "SINEPE - CENTRO EDUCACIONAL PINTACOR LTDA - ME ",
            "E-mail.Contato" => "atendimento@crechepintacor.com
    ",
            "CNPJ" => "10.489.146/0001-04",
            "Tel.Contato" => "(27) 3328-7593
    ",
            "Sub Grupo" => "CONTRATOS EXAMES - AVULSO"),
        array(
            "Código" => 244931,
            "Empresa" => "CENTRO EDUCACIONAL PRIMEIRO MUNDO LTDA ",
            "E-mail.Contato" => "glaucia@pmundo.com.br
    rh@pmundo.com.br
    sebastiao@pmundo.com.br
    ",
            "CNPJ" => "36.378.966/0001-04",
            "Tel.Contato" => "(27) 3434-1469

    (27) 3434-1492
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 398769,
            "Empresa" => "SINEPE - CENTRO EDUCACIONAL RENASCER LTDA",
            "E-mail.Contato" => "renascer.escola@yahoo.com.br
    camilasgava@gmail.com
    ",
            "CNPJ" => "30.779.805/0001-46",
            "Tel.Contato" => "(27) 3225-8911
    (27) 3225-8911
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 245252,
            "Empresa" => "CENTRO LOGISTICO DE CARIACICA - CLC",
            "E-mail.Contato" => "contasapagar@stilecomercial.com.br
    ",
            "CNPJ" => "11.885.434/0001-32",
            "Tel.Contato" => "(27) 2121-5600
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 358470,
            "Empresa" => "CENTROCOR CARDIOLOGIA LTDA ",
            "E-mail.Contato" => "financeiro@centrocor.com.br
    dp1@centrocor.com.br
    ",
            "CNPJ" => "31.481.500/0001-16",
            "Tel.Contato" => "(27) 3335-6300
    (27) 3335-6300
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 581122,
            "Empresa" => "CG - CONSULTORIA EM NEGOCIOS E MEIO AMBIENTE LTDA",
            "E-mail.Contato" => "gustavo.diniz@linhaambiental.com.br
    ",
            "CNPJ" => "11.394.929/0001-69",
            "Tel.Contato" => "(27) 99223-0017
    ",
            "Sub Grupo" => "CLIENTES AVULSO"),
        array(
            "Código" => 580856,
            "Empresa" => "CHAMA FESTAS E DECORACOES LTDA ",
            "E-mail.Contato" => "dp@blincolredeshow.com.br
    ",
            "CNPJ" => "30.158.622/0001-03",
            "Tel.Contato" => "(27) 3251-1278
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 245718,
            "Empresa" => "CHURRASCARIA SARANDI LTDA - EPP ",
            "E-mail.Contato" => "sarandi@churrascariasarandi.com.br
    ",
            "CNPJ" => "27.426.394/0001-09",
            "Tel.Contato" => "(27) 3227-6878
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 366933,
            "Empresa" => "CIA DE TRANSPORTES E ARMAZENS GERAIS - SILOTEC",
            "E-mail.Contato" => "contasapagar@gdllogistica.com.br
    rh@gdllogistica.com.br
    manuela@silotec.com.br
    manuela@gdllogistica.com.br
    tiago.b@silotec.com.br
    ",
            "CNPJ" => "39.404.421/0004-66",
            "Tel.Contato" => "

    (27) 2121-2412

    (27) 2121-2411
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 496518,
            "Empresa" => "CICLO ESTRUTURAS MODULARES LTDA",
            "E-mail.Contato" => "contabil@ciclomodulos.com.br
    ",
            "CNPJ" => "02.777.510/0001-03",
            "Tel.Contato" => "(27) 3228-0161
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 301661,
            "Empresa" => "CITTA ENGENHARIA LTDA ",
            "E-mail.Contato" => "qualidade@cittaengenharia.com.br
    wanderson@cittaengenharia.com.br
    ",
            "CNPJ" => "39.630.041/0001-05",
            "Tel.Contato" => "(27) 2121-6900
    (27) 2121-6900
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 409663,
            "Empresa" => "CLESAT COMUNICACOES E MANUTENCAO EM ELETROELETRONICOS LTDA",
            "E-mail.Contato" => "administrativo@clesat.net.br
    ",
            "CNPJ" => "03.585.823/0001-14",
            "Tel.Contato" => "(27) 3233-1593
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 539417,
            "Empresa" => "CLIMEST - CENTRO DE ASSESSORIA PROFISSIONAL LTDA",
            "E-mail.Contato" => "climest_climest@yahoo.com.br
    ",
            "CNPJ" => "05.962.095/0001-48",
            "Tel.Contato" => "(27) 3319-2701
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 603228,
            "Empresa" => "CLINBRAS MEDICINA OCUPACIONAL",
            "E-mail.Contato" => "",
            "CNPJ" => "17.442.436/0001-33",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 345920,
            "Empresa" => "CLINEO - CLINICA DE ESPECIALIDADES",
            "E-mail.Contato" => "",
            "CNPJ" => "07.406.213/0001-67",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 411103,
            "Empresa" => "CLINICA MEDICA TOSE LTDA - EPP",
            "E-mail.Contato" => "aquila.rtose@gmail.com
    ",
            "CNPJ" => "23.565.729/0001-00",
            "Tel.Contato" => "(27) 99943-3919
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 643780,
            "Empresa" => "CLINIMED SAUDE E SEGURANCA DO TRABALHO LTDA",
            "E-mail.Contato" => "financeiro1@clinimedjoinville.com.br
    ",
            "CNPJ" => "24.066.112/0001-03",
            "Tel.Contato" => "(47) 3025-4970
    ",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 605066,
            "Empresa" => "FITINLESS CLUB",
            "E-mail.Contato" => "administrativo@biosete.com.br
    ",
            "CNPJ" => "18.523.051/0001-63",
            "Tel.Contato" => "(27) 3329-6047
    ",
            "Sub Grupo" => "CLIENTES AVULSO"),
        array(
            "Código" => 678803,
            "Empresa" => "COFERVIL",
            "E-mail.Contato" => "claudio.imperial@cofervil.com.br
    ",
            "CNPJ" => "39.815.253/0001-59",
            "Tel.Contato" => "(27) 2127-1793
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 257865,
            "Empresa" => "CONSORCIO VIWA",
            "E-mail.Contato" => "rh@consorcioviwa.com.br
    ",
            "CNPJ" => "27.268.770/0003-38",
            "Tel.Contato" => "(27) 3321-5600
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 384644,
            "Empresa" => "COLINA SOLUCOES E SERVICOS LTDA - EPP ",
            "E-mail.Contato" => "sesmt@seiinteligencia.com.br
    ",
            "CNPJ" => "11.331.297/0001-94",
            "Tel.Contato" => "(27) 3328-7228
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 328420,
            "Empresa" => "COLLARES CARIACICA",
            "E-mail.Contato" => "collares@collaresreciclagem.com.br
    ",
            "CNPJ" => "20.283.165/0001-25",
            "Tel.Contato" => "(27) 99663-7534
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 549274,
            "Empresa" => "COMERCIAL DE ALIMENTOS ASTER LTDA (REDE SHOW SUPER. BARCEL",
            "E-mail.Contato" => "barcelona@gruporedeshow.com
    ",
            "CNPJ" => "06.911.252/0001-59",
            "Tel.Contato" => "(27) 3341-1731
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 573914,
            "Empresa" => "COMERCIAL G & Z DE PRODUTOS ALIMENTICIOS LTDA ",
            "E-mail.Contato" => "lorranyrh@multishow.org
    ",
            "CNPJ" => "08.987.047/0001-00",
            "Tel.Contato" => "(27) 98112-9433
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 622578,
            "Empresa" => "COMERCIAL GAIVOTAS LTDA. (SUPERMERCADO FAE)",
            "E-mail.Contato" => "rh@superfae.com.br
    ",
            "CNPJ" => "05.069.445/0001-41",
            "Tel.Contato" => "(21) 2543-19
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 587501,
            "Empresa" => "COMERCIAL SUPERGAS LTDA - UNIGAS ",
            "E-mail.Contato" => "",
            "CNPJ" => "07.515.896/0001-90",
            "Tel.Contato" => "",
            "Sub Grupo" => "CLIENTES AVULSO"),
        array(
            "Código" => 468468,
            "Empresa" => "COMERCIAL TRESMANN LTDA",
            "E-mail.Contato" => "adm@agoraa.com.br
    ",
            "CNPJ" => "31.732.365/0004-87",
            "Tel.Contato" => "(27) 3029-2995
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 681408,
            "Empresa" => "COMERCIO DE ALIMENTOS TIA BILAY EIRELI ",
            "E-mail.Contato" => "kayena_alimentos@hotmail.com
    ",
            "CNPJ" => "19.167.140/0001-87",
            "Tel.Contato" => "(27) 3391-5235
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 327773,
            "Empresa" => "COMPANHIA PORTUARIA VILA VELHA ",
            "E-mail.Contato" => "cpvv@cpvv.com.br
    hseq@cpvv.com.br
    ",
            "CNPJ" => "39.826.482/0001-79",
            "Tel.Contato" => "(27) 3399-4147
    (27) 3399-4147
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 567707,
            "Empresa" => "COMPISO MATERIAL DE ACABAMENTO LTDA",
            "E-mail.Contato" => "COMPISOACABAMENTO@GMAIL.COM
    ",
            "CNPJ" => "04.776.619/0001-43",
            "Tel.Contato" => "(27) 99922-5399
    ",
            "Sub Grupo" => "CLIENTES AVULSO"),
        array(
            "Código" => 674507,
            "Empresa" => "COMSEG - ENGENHARIA DE (SOCNET) ",
            "E-mail.Contato" => "",
            "CNPJ" => "",
            "Tel.Contato" => "",
            "Sub Grupo" => "Sem Contrato"),
        array(
            "Código" => 674481,
            "Empresa" => "COMSEG - ENGENHARIA DE SEGURANCA E MEDICINA DO TRABALHO LT",
            "E-mail.Contato" => "credenciamento@comsegmg.com.br
    ",
            "CNPJ" => "08.915.446/0001-58",
            "Tel.Contato" => "(33) 3522-3344
    ",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 294652,
            "Empresa" => "CONCESSIONARIA FACA FACIL CIDADAO S.A. ",
            "E-mail.Contato" => "gilceia.zanardo@cffacil.com.br
    ",
            "CNPJ" => "19.364.481/0001-42",
            "Tel.Contato" => "(27) 2142-2179
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 559050,
            "Empresa" => "CONCESSIONARIA RODOVIA DO SOL S.A - RODOSOL",
            "E-mail.Contato" => "fabricio.martins@rodosol.com.br
    marcia.guerrieri@rodosol.com.br
    ",
            "CNPJ" => "02.879.926/0001-24",
            "Tel.Contato" => "(27) 3334-7859
    (27) 3334-7818
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 290906,
            "Empresa" => "CONDOMINIO DO EDIFICIO ALDEBARAN ",
            "E-mail.Contato" => "edificioaldebaran2014@gmail.com
    ",
            "CNPJ" => "39.615.406/0001-14",
            "Tel.Contato" => "(27) 3223-5280
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 422142,
            "Empresa" => "CONDOMINIO DO EDIFICIO CENTURY PLAZA APART HOTEL ",
            "E-mail.Contato" => "veronica.santos@bourbon.com.br
    gabriela.gomes@bourbon.com.br
    ",
            "CNPJ" => "05.511.971/0001-10",
            "Tel.Contato" => "(27) 3203-6550

    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 513539,
            "Empresa" => "CONDOMINIO DO EDIFICIO QUARTIER BLANC ",
            "E-mail.Contato" => "",
            "CNPJ" => "36.045.094/0001-62",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 245416,
            "Empresa" => "CONDOMINIO RESIDENCIAL VILLAGE DOR",
            "E-mail.Contato" => "village_dor@hotmail.com
    ",
            "CNPJ" => "00.912.284/0001-92",
            "Tel.Contato" => "(27) 3324-3991
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 638069,
            "Empresa" => "CONSELHO REGIONAL DE SERVICO SOCIAL CRESS 17 REGIAO ES ",
            "E-mail.Contato" => "coordenacaofin@cress-es.org.br
    administrativo2@cress-es.org.br
    ",
            "CNPJ" => "27.741.735/0001-22",
            "Tel.Contato" => "(27) 3222-0444
    (27) 3222-0444
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 357800,
            "Empresa" => "CONSOL SERVICOS LTDA - ME ",
            "E-mail.Contato" => "",
            "CNPJ" => "17.333.891/0001-09",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 333657,
            "Empresa" => "CONSORCIO JOTA ELE / EXXA / BASALTO ",
            "E-mail.Contato" => "rh2@consorciojde.com.br
    seg@consorciojde.com.br
    ",
            "CNPJ" => "22.215.629/0001-91",
            "Tel.Contato" => "(27) 2233-9292
    (27) 2233-9292
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 526356,
            "Empresa" => "CONSORCIO JOTA ELE / STEINGE ",
            "E-mail.Contato" => "luciana.terres@consorciojde.com.br
    ",
            "CNPJ" => "30.800.306/0001-93",
            "Tel.Contato" => "(27) 2233-9292
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 536665,
            "Empresa" => "CONSTRUTORA ATERPA S/A",
            "E-mail.Contato" => "jenilson.militao@aterpa.com.br
    jenilson.militao@aterpa.com.br
    ",
            "CNPJ" => "17.162.983/0004-08",
            "Tel.Contato" => "(31) 97159-3945
    (31) 2125-5000
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 391667,
            "Empresa" => "CONSTRUTORA E INCORPORADORA M. SANTOS LTDA ",
            "E-mail.Contato" => "suelen@msantos-es.com.br
    ",
            "CNPJ" => "00.943.930/0001-89",
            "Tel.Contato" => "(27) 3025-3067
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 522374,
            "Empresa" => "CONSTRUTORA SIQUEIRA CAMARGO EIRELI",
            "E-mail.Contato" => "pgcomservicos@gmail.com
    ",
            "CNPJ" => "17.297.294/0001-68",
            "Tel.Contato" => "(27) 3349-3533
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 256840,
            "Empresa" => "CONTEMPORANEA ENGENHARIA LTDA - EPP",
            "E-mail.Contato" => "rh@contemporanea.eng.br
    administrativo@contemporanea.eng.br
    ",
            "CNPJ" => "07.197.417/0001-35",
            "Tel.Contato" => "(27) 3025-3474
    (27) 3025-3471
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 245613,
            "Empresa" => "COOPERAGUIA",
            "E-mail.Contato" => "paulow@cooperaguia.coop.br
    ",
            "CNPJ" => "27.171.974/0001-94",
            "Tel.Contato" => "(27) 2125-1321
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 278616,
            "Empresa" => "COOPROVES",
            "E-mail.Contato" => "adm@cooproves.com.br
    financeiro@cooproves.com.br
    ",
            "CNPJ" => "09.568.680/0001-19",
            "Tel.Contato" => "(27) 3396-9593

    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 465831,
            "Empresa" => "CORDIAL TRANSPORTES E TURISMO LTDA",
            "E-mail.Contato" => "CONTATO@CORDIALTURISMO.COM.BR
    ",
            "CNPJ" => "03.033.573/0001-00",
            "Tel.Contato" => "(27) 3256-1604
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 576568,
            "Empresa" => "COSTA BRASIL RESTAURANTE LTDA ",
            "E-mail.Contato" => "",
            "CNPJ" => "31.936.277/0001-54",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 425351,
            "Empresa" => "CRICARE PRAIA HOTEL LTDA ",
            "E-mail.Contato" => "adm@hotelcricare.com.br
    ",
            "CNPJ" => "17.855.660/0001-57",
            "Tel.Contato" => "(27) 3762-7300
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 594501,
            "Empresa" => "ATACADISTA SATURNO ",
            "E-mail.Contato" => "mariapaula@consultoriagoncalves.com.br
    tamara@consultoriagoncalves.com.br
    ",
            "CNPJ" => "08.606.300/0001-20",
            "Tel.Contato" => "(27) 3222-5354
    (27) 3222-5354
    ",
            "Sub Grupo" => "CLIENTES AVULSO"),
        array(
            "Código" => 292363,
            "Empresa" => "CST - MEDICINA DO TRABALHO LTDA - ME (TRACBEL)",
            "E-mail.Contato" => "supervisao@cstbh.com.br
    ",
            "CNPJ" => "09.555.259/0001-73",
            "Tel.Contato" => "(31) 3271-1119
    ",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 385201,
            "Empresa" => "CTRVV - CENTRAL DE TRATAMENTO DE RESIDUOS VILA VELHA LTDA ",
            "E-mail.Contato" => "emerson@ctrvv.com.br
    ",
            "CNPJ" => "01.656.808/0001-94",
            "Tel.Contato" => "(27) 3089-0558
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 683029,
            "Empresa" => "CYMI - INSTALACOES INDUSTRIAIS EIRELI ",
            "E-mail.Contato" => "CONTRAP.CYMI@HOTMAIL.COM
    ",
            "CNPJ" => "09.020.699/0001-26",
            "Tel.Contato" => "(27) 9603-3478
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 683031,
            "Empresa" => "CYMI - INSTALACOES INDUSTRIAIS EIRELI ",
            "E-mail.Contato" => "CONTRAP.CYMI@HOTMAIL.COM",
            "CNPJ" => "09.020.699/0001-26",
            "Tel.Contato" => "(27) 9603-3478",
            "Sub Grupo" => "CONTRATOS AVULSO",
            "undefined" => "CONTRATOS AVULSO"),
        array(
            "Código" => 623469,
            "Empresa" => "D.C.B TRANSPORTES E MATERIAL DE CONSTRUCAO LTDA",
            "E-mail.Contato" => "",
            "CNPJ" => "21.478.597/0001-54",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 384638,
            "Empresa" => "DN COMERCIO E SERVICOS EM SEGURANCA E INTELIGENCIA LTDA ",
            "E-mail.Contato" => "sesmet@seiinteligencia.com.br
    qualidade@seiinteligencia.com.br
    ",
            "CNPJ" => "05.628.013/0001-23",
            "Tel.Contato" => "(27) 3328-7228
    (27) 3328-7228
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 494681,
            "Empresa" => "DALLA VALLE TRANSPORTES ",
            "E-mail.Contato" => "recursoshumanos01@dallavalle.com.br
    RecursosHumanos@dallavalle.com.br
    ",
            "CNPJ" => "00.389.587/0004-15",
            "Tel.Contato" => "(27) 3255-2440
    (51) 3052-4922
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 394424,
            "Empresa" => "GESSO DE ANGELI ",
            "E-mail.Contato" => "",
            "CNPJ" => "03.266.161/0001-10",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 384248,
            "Empresa" => "DECALI GESTAO DE QUALIDADE LTDA - ME  ",
            "E-mail.Contato" => "financeiro@decali.com.br
    ",
            "CNPJ" => "23.862.650/0001-41",
            "Tel.Contato" => "(27) 2464-0033
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 634597,
            "Empresa" => "DEFAGRO DEFENSIVOS AGRICOLAS LTDA",
            "E-mail.Contato" => "",
            "CNPJ" => "32.437.881/0001-07",
            "Tel.Contato" => "",
            "Sub Grupo" => "CLIENTES AVULSO"),
        array(
            "Código" => 325990,
            "Empresa" => "DELLMAR TRANSPORTES S/A ",
            "E-mail.Contato" => "stephanie@dellmar.com.br
    ",
            "CNPJ" => "13.254.104/0001-74",
            "Tel.Contato" => "(27) 3396-7578
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 394895,
            "Empresa" => "LABORARE.MED",
            "E-mail.Contato" => "financeiro@laborare.med.br
    ",
            "CNPJ" => "22.123.372/0001-48",
            "Tel.Contato" =>"",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 423644,
            "Empresa" => "DELTAMED SERVICOS MEDICOS LTDA - ME   ",
            "E-mail.Contato" => "deltamed@deltamed.com.br
    ",
            "CNPJ" => "10.578.903/0001-08",
            "Tel.Contato" => "(11) 4964-1222
    ",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 356347,
            "Empresa" => "DESIGN SERVICOS",
            "E-mail.Contato" => "SOMONAIA.SILVA@DESIGNSERVICOS.COM.BR
    ",
            "CNPJ" => "39.627.591/0001-67",
            "Tel.Contato" => "(27) 3379-0563
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 245031,
            "Empresa" => "DESTEFANI CONSTRUCOES E INCORPORACOES LTDA - ME ",
            "E-mail.Contato" => "construtora@destefani.com.br
    ",
            "CNPJ" => "27.411.537/0001-09",
            "Tel.Contato" => "(27) 3317-1726
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 385638,
            "Empresa" => "DG DROGARIA LTDA - ME ",
            "E-mail.Contato" => "farmafacil@hotmail.com
    ",
            "CNPJ" => "11.198.666/0001-12",
            "Tel.Contato" => "(27) 3317-3516
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 538197,
            "Empresa" => "DOMINGOS COSTA INDUSTRIAS ALIMENTICIAS SA",
            "E-mail.Contato" => "tvolponi@vilma.com.br
    ",
            "CNPJ" => "17.159.518/0005-07",
            "Tel.Contato" => "(27) 2122-1352
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 494021,
            "Empresa" => "DORPER ITAUNAS PRODUTOS ALIMENTICIOS LTDA - EPP ",
            "E-mail.Contato" => "administrativo@cordeirobabyblack.com.br
    ",
            "CNPJ" => "22.356.485/0001-93",
            "Tel.Contato" => "(27) 3019-0143
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 260072,
            "Empresa" => "DR ENGENHARIA,CONSULTORIA E PROJETOS EIRELI ",
            "E-mail.Contato" => "contato@dr.eng.br
    administrativo@dr.eng.br
    ",
            "CNPJ" => "13.404.724/0001-42",
            "Tel.Contato" => "
    (27) 3219-0444
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 293949,
            "Empresa" => "DTMSEG - (SOCNET) ",
            "E-mail.Contato" => "",
            "CNPJ" => "",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONVENIOS SOCNET"),
        array(
            "Código" => 552253,
            "Empresa" => "DTMSEG - SEGURANCA DO TRABALHO E MEDICINA OCUPACIONAL LTDA",
            "E-mail.Contato" => "tiago.improta@dtmseg.com.br
    ",
            "CNPJ" => "08.982.185/0001-99",
            "Tel.Contato" => "(11) 2102-4899
    ",
            "Sub Grupo" => "CONVENIOS SOCNET"),
        array(
            "Código" => 558019,
            "Empresa" => "DYNAMICA ENGENHARIA LTDA",
            "E-mail.Contato" => " julia@dynamica.com.br
    ",
            "CNPJ" => "04.295.941/0001-50",
            "Tel.Contato" => "(11) 2597-6011
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 535396,
            "Empresa" => "EAG CONSTRUCOES & EDIFICACOES LTDA ",
            "E-mail.Contato" => "danielprata123@hotmail.com
    ",
            "CNPJ" => "22.221.330/0001-40",
            "Tel.Contato" => "(27) 99811-9172
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 514969,
            "Empresa" => "E M G CONSTRUTORA EIRELI ",
            "E-mail.Contato" => "",
            "CNPJ" => "31.481.944/0001-51",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 467672,
            "Empresa" => "ECOLIMPO SERVICOS DE CARGA E DESCARGA LTDA - ME",
            "E-mail.Contato" => "ecolimpoes@gmail.com
    ",
            "CNPJ" => "20.539.232/0001-20",
            "Tel.Contato" => "(27) 3323-5036
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 564078,
            "Empresa" => "ECOREAL SUPERMERCADOS LTDA ",
            "E-mail.Contato" => "terravermelha@gruporedeshow.com
    ",
            "CNPJ" => "08.929.445/0001-62",
            "Tel.Contato" => "(27) 3244-4220
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 386347,
            "Empresa" => "EDG SERVICOS LTDA ",
            "E-mail.Contato" => "roger.paula@edgservicos.com.br
    ",
            "CNPJ" => "14.266.831/0001-14",
            "Tel.Contato" => "(11) 4890-1713
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 467095,
            "Empresa" => "EDILI EMPREENDIMENTOS EIRELI",
            "E-mail.Contato" => "nataliasofiste@edili.com.br
    ",
            "CNPJ" => "14.728.871/0001-30",
            "Tel.Contato" => "(27) 3272-1395
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 664921,
            "Empresa" => "GRUPO EDUCAR MAIS",
            "E-mail.Contato" => "",
            "CNPJ" => "30.572.376/0001-31",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 393802,
            "Empresa" => "ELCMAR SOLUCOES EM P DE DOCUMENTOS LTDA ME",
            "E-mail.Contato" => "administracao@elcmar.com.br
    financeiro@elcmar.com.br
    ",
            "CNPJ" => "05.976.260/0001-10",
            "Tel.Contato" => "(27) 3331-6710
    (27) 3331-6710
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 528188,
            "Empresa" => "ELECTRON MONTAGENS INDUSTRIAIS LTDA",
            "E-mail.Contato" => "bruno@electron-es.com.br
    ",
            "CNPJ" => "06.134.504/0001-80",
            "Tel.Contato" => "(27) 3296-2637
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 511966,
            "Empresa" => "ELETRIC ELETRICIDADE COMERCIO E SERVICOS LTDA",
            "E-mail.Contato" => "leticia.sampaio@eletriceletricidade.com.br
    ",
            "CNPJ" => "27.454.941/0001-51",
            "Tel.Contato" => ""
    ,
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 604393,
            "Empresa" => "ELETRO AR COMERCIO E SERVICOS EM AR CONDICIONADO LTDA ",
            "E-mail.Contato" => "",
            "CNPJ" => "20.773.955/0001-99",
            "Tel.Contato" => "",
            "Sub Grupo" => "CLIENTES AVULSO"),
        array(
            "Código" => 652734,
            "Empresa" => "EMBALADOS PRATICOS LTDA ",
            "E-mail.Contato" => "administrativo@embaladospraticos.com
    ",
            "CNPJ" => "29.664.077/0001-48",
            "Tel.Contato" => "(27) 99913-2089
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 529398,
            "Empresa" => "EMPORIO DISTRIBUIDORA LTDA (OBA)",
            "E-mail.Contato" => "rh@superoba.com.br
    ",
            "CNPJ" => "12.261.059/0001-12",
            "Tel.Contato" => "(27) 3721-3540
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 529387,
            "Empresa" => "EMPORIO PUBLICIDADE E LOGISTICA LTDA (OBA) ",
            "E-mail.Contato" => "",
            "CNPJ" => "30.562.371/0001-28",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 246364,
            "Empresa" => "EMPRESA TREINAMENTO",
            "E-mail.Contato" => "",
            "CNPJ" => "07.110.470/0001-57",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATO EXAMES"),
        array(
            "Código" => 442526,
            "Empresa" => "ENERGY SELECTION INSTALACOES LTDA - ME (SOLVIX)",
            "E-mail.Contato" => "washington@solvix.com.br
    ",
            "CNPJ" => "04.848.466/0001-00",
            "Tel.Contato" => "(27) 3029-3689
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 358526,
            "Empresa" => "ENGERP ENGENHARIA",
            "E-mail.Contato" => "leonardo@engerp-es.com.br
    rosilene@engerp-es.com.br
    ",
            "CNPJ" => "17.158.784/0001-83",
            "Tel.Contato" => "(27) 3376-7011
    (27) 3376-7011
    ",
            "Sub Grupo" => "CLIENTES AVULSO"),
        array(
            "Código" => 396915,
            "Empresa" => "ENIVIX LTDA",
            "E-mail.Contato" => "coshima@tnova.com.br
    cdsantos@tnova.com.br
    ",
            "CNPJ" => "04.838.701/0001-55",
            "Tel.Contato" => "(11) 3811-3853
    (27) 3183-8872
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 377804,
            "Empresa" => "ENVIX ENGENHARIA LTDA ",
            "E-mail.Contato" => "rh@envixengenharia.com.br
    ",
            "CNPJ" => "06.274.118/0001-94",
            "Tel.Contato" => "(27) 3327-0608
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 575580,
            "Empresa" => "EO LOGISTICA INTEGRADA EM E-COMMERCE LTDA",
            "E-mail.Contato" => "gestor@eologistica.com.br
    ",
            "CNPJ" => "27.784.019/0001-22",
            "Tel.Contato" => "(13) 99177-7797
    ",
            "Sub Grupo" => "CONTRATOS EXAMES - AVULSO"),
        array(
            "Código" => 488755,
            "Empresa" => "ER DE AZEVEDO - ME ",
            "E-mail.Contato" => "edson-ribeiro1@hotmail.com
    ",
            "CNPJ" => "12.540.451/0001-09",
            "Tel.Contato" => "(27) 99913-7460
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 244913,
            "Empresa" => "ERGOCLIN MEDICINA",
            "E-mail.Contato" => "financeiro@ergoclin.com.br
    ",
            "CNPJ" => "04.851.114/0001-04",
            "Tel.Contato" => "(41) 3342-9669
    ",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 676934,
            "Empresa" => "ES FITNESS LTDA - FILIAL (SMART FIT ACADEMIAS)",
            "E-mail.Contato" => "",
            "CNPJ" => "23.620.822/0002-51",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATO EXAMES"),
        array(
            "Código" => 676930,
            "Empresa" => "ES FITNESS LTDA - MATRIZ (SMART FIT ACADEMIAS)",
            "E-mail.Contato" => "",
            "CNPJ" => "23.620.822/0001-70",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 485218,
            "Empresa" => "ES SERVICOS INTELIGENTES",
            "E-mail.Contato" => "m.thompson@globo.com
    ",
            "CNPJ" => "18.476.613/0001-65",
            "Tel.Contato" => "(27) 99816-5980
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 537201,
            "Empresa" => "ESCOLA MULTIPLA EIRELI (SINEPE)",
            "E-mail.Contato" => "marciaantonia@escolamultipla.com.br
    ",
            "CNPJ" => "39.399.225/0001-06",
            "Tel.Contato" => "(27) 3341-1027
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 318436,
            "Empresa" => "ESCOLA SAO DOMINGOS LTDA ",
            "E-mail.Contato" => "aline@escolasaodomingos.com.br
    andressa@escolasaodomingos.com.br
    ",
            "CNPJ" => "27.318.310/0001-05",
            "Tel.Contato" => "(27) 3357-4445
    (27) 3357-4445
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 344384,
            "Empresa" => "ESPACO HORTENCIA - GOL BURGER",
            "E-mail.Contato" => "pessoal@golburger.com.br
    loratorezani@yahoo.com.br
    ",
            "CNPJ" => "13.823.953/0001-00",
            "Tel.Contato" => "(27) 3329-3348
    (27) 99246-8930
    ",
            "Sub Grupo" => "CLIENTES AVULSO"),
        array(
            "Código" => 553180,
            "Empresa" => "ESPACO VIVERE SAUDE LTDA",
            "E-mail.Contato" => "douglastorres@vivere.med.br
    patricianogueira@vivere.med.br
    ",
            "CNPJ" => "26.184.295/0001-97",
            "Tel.Contato" => "(28) 3536-5345
    (28) 3536-5345
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 244950,
            "Empresa" => "ESTALOS SERVICOS DE HOSPEDAGEM E COMERCIO LTDA - ME ",
            "E-mail.Contato" => "ESTALOSMOTEL@TERRA.COM.BR
    vizzoni@ig.com.br
    saleteibiza@hotmail.com
    ",
            "CNPJ" => "09.688.209/0001-64",
            "Tel.Contato" => "(27) 3349-4455
    (27) 3389-3417
    (27) 3389-3417
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 244947,
            "Empresa" => "ESTRUTURAL CONSTRUTORA E INCORPORADORA LTDA",
            "E-mail.Contato" => "pessoal@estruturalconstrutora.com.br
    ",
            "CNPJ" => "28.414.720/0001-12",
            "Tel.Contato" => "(27) 2124-0800
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 639726,
            "Empresa" => "ESTRUTURAL PRE-MOLDADOS EIRELI",
            "E-mail.Contato" => "",
            "CNPJ" => "08.182.600/0001-20",
            "Tel.Contato" => "",
            "Sub Grupo" => "CLIENTES AVULSO"),
        array(
            "Código" => 384649,
            "Empresa" => "ETERMAR ENGENHARIA E CONSTRUCAO S/A.",
            "E-mail.Contato" => "g.marques@etermar.pt
    kl_almeida@hotmail.com
    ",
            "CNPJ" => "14.560.683/0001-46",
            "Tel.Contato" => "
    (27) 3222-8220
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 245306,
            "Empresa" => "ETHICA AMBIENTAL SERVICOS E CONSULTORIA LTDA ",
            "E-mail.Contato" => "ethica@ethicaambiental.com.br
    ",
            "CNPJ" => "08.046.346/0001-32",
            "Tel.Contato" => "(27) 3329-2970
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 506687,
            "Empresa" => "EXATTA PRESTADORA DE SERVICOS EIRELI ",
            "E-mail.Contato" => "caliane.exatta@outlook.com
    financeiro.exatta@terra.com.br
    ",
            "CNPJ" => "18.299.801/0001-65",
            "Tel.Contato" => "(71) 3261-3800
    (71) 3261-3800
    ",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 544983,
            "Empresa" => "EXPERT SOLUCOES EM SERVICOS DE SEGURANCA DO TRABALHO",
            "E-mail.Contato" => "raquel.souza@expertocupacional.com.br
    agendamento@maisocupacional.com.br
    credenciamento@maisocupacional.com.br
    ",
            "CNPJ" => "27.350.480/0001-77",
            "Tel.Contato" => "(11) 3477-5233
    (11) 3477-5233
    (11) 2450-7332
    ",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 282042,
            "Empresa" => "EXTRAFRUTI S/A - COMERCIO DE HORTIFRUTIGRANJEIROS ",
            "E-mail.Contato" => "rosima.silva@extrafruti.com.br
    simone.andrade@extrafruti.com.br
    ",
            "CNPJ" => "06.175.064/0001-00",
            "Tel.Contato" => "(27) 3346-1200
    (27) 3346-1218
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 569739,
            "Empresa" => "F DOS SANTOS ARAUJO REPRESENTACOES E COMERCIO ",
            "E-mail.Contato" => "flavia.cityluz@gmail.com
    ",
            "CNPJ" => "17.988.591/0001-50",
            "Tel.Contato" => "(27) 99740-0835
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 569254,
            "Empresa" => "ADERE CONSTRUCOES E SERVICOS ",
            "E-mail.Contato" => "adereconstrucoes@gmail.com
    ",
            "CNPJ" => "28.437.387/0001-67",
            "Tel.Contato" => "(27) 3254-2789
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 514974,
            "Empresa" => "F N S CONSTRUCOES & EDIFICACOES EIRELI",
            "E-mail.Contato" => "crisroncette@gmail.com
    ",
            "CNPJ" => "27.122.154/0001-02",
            "Tel.Contato" => "(27) 9801-4766
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 531814,
            "Empresa" => "FAESA - HOMOLOGACAO",
            "E-mail.Contato" => "robson.simoes@pbastones.com.br
    ",
            "CNPJ" => "27.014.042/0001-38",
            "Tel.Contato" => "(27) 98193-1800
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 428977,
            "Empresa" => "FALCAO-SERVICOS TERCEIRIZADOS LTDA ",
            "E-mail.Contato" => "atend02.rh@uol.com.br
    ",
            "CNPJ" => "00.155.983/0001-35",
            "Tel.Contato" => "(43) 3520-9000
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 357884,
            "Empresa" => "FALQUETO ATACADO ",
            "E-mail.Contato" => "",
            "CNPJ" => "14.411.584/0001-00",
            "Tel.Contato" => "",
            "Sub Grupo" => "CLIENTES AVULSO"),
        array(
            "Código" => 639722,
            "Empresa" => "FAM PRE MOLDADOS LTDA",
            "E-mail.Contato" => "pessoal@estruturalonline.com.br
    ",
            "CNPJ" => "10.364.691/0001-66",
            "Tel.Contato" => "(27) 99273-1579
    ",
            "Sub Grupo" => "CLIENTES AVULSO"),
        array(
            "Código" => 393337,
            "Empresa" => "MAMY BABY - FANTASY",
            "E-mail.Contato" => "",
            "CNPJ" => "00.291.546/0001-49",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 383223,
            "Empresa" => "FARMACIA FLEXAL COMERCIO DE MEDICAMENTOS LTDA - ME ",
            "E-mail.Contato" => "farmaciaflexal@gmail.com
    ",
            "CNPJ" => "02.662.979/0001-99",
            "Tel.Contato" => "(27) 3336-4633
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 386406,
            "Empresa" => "FARMACIA PRECO BAIXO DE FEU ROSA LTDA ",
            "E-mail.Contato" => "fpb.feurosa@gmail.com
    ",
            "CNPJ" => "22.678.375/0001-48",
            "Tel.Contato" => "(27) 3086-2476
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 520569,
            "Empresa" => "FEDERACAO DE FUTEBOL DO ESTADO DO ESPIRITO SANTO - FES",
            "E-mail.Contato" => "administrativo@futebolcapixaba.com
    ",
            "CNPJ" => "27.248.939/0001-26",
            "Tel.Contato" => "(27) 3038-7813
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 244782,
            "Empresa" => "FETAES",
            "E-mail.Contato" => "financeiro@fetaes.org.br
    ",
            "CNPJ" => "28.152.825/0001-40",
            "Tel.Contato" => "(27) 3223-3677
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 389599,
            "Empresa" => "FERCON FERRAGENS E MATERIAL DE CONSTRUCAO LTDA - EPP ",
            "E-mail.Contato" => "delma@fercon-es.com
    ",
            "CNPJ" => "30.731.723/0001-21",
            "Tel.Contato" => "(27) 3227-9012
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 399489,
            "Empresa" => "FERMAQUINAS TRANSPORTES, TERRAPLANAGENS E LOCACOES LTDA - ",
            "E-mail.Contato" => "fermaq.es@mhotmail.com
    ",
            "CNPJ" => "13.767.521/0001-10",
            "Tel.Contato" => "(27) 3254-5405
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 386429,
            "Empresa" => "FIBRA NEGOCIOS E SERVICOS LTDA ",
            "E-mail.Contato" => "adm.dop@grupofibra.com
    sesmt@grupofibra.com
    recrutamento@grupofibra.com
    ",
            "CNPJ" => "02.199.192/0001-32",
            "Tel.Contato" => "
    (27) 2123-7828
    (27) 2123-7828
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 245029,
            "Empresa" => "FORNECEDORA DALLA BERNARDINA LTDA",
            "E-mail.Contato" => "administrativo@dallabernardina.com.br
    ",
            "CNPJ" => "00.337.010/0001-17",
            "Tel.Contato" => "(27) 3212-8874
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 435461,
            "Empresa" => "FORTALEZA SERVICOS E MONITORAMENTO LTDA - ME ",
            "E-mail.Contato" => "financeiro1@verticeseg.com.br
    ",
            "CNPJ" => "22.494.289/0001-85",
            "Tel.Contato" => "(27) 3323-1570
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 244632,
            "Empresa" => "FORTE AMBIENTAL EIRELI",
            "E-mail.Contato" => "engenharia@forteambiental.com.br
    rh01@forteambiental.com.br
    ",
            "CNPJ" => "27.320.787/0001-25",
            "Tel.Contato" => "(27) 99983-1656
    (27) 3236-8080
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 523659,
            "Empresa" => "FORTES ENGENHARIA LTDA ",
            "E-mail.Contato" => "cristiane.tassinari@fortes.ind.br
    ",
            "CNPJ" => "30.677.132/0001-13",
            "Tel.Contato" => "(27) 3325-8883
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 601176,
            "Empresa" => "FORTS SERVICOS LOGISTICOS EM GERAL ",
            "E-mail.Contato" => "fortservicoslogisticos@gmail.com
    ",
            "CNPJ" => "24.106.157/0001-64",
            "Tel.Contato" => "(27) 3065-0602
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 355242,
            "Empresa" => "FREITAS COMERCIO DE PNEUS LTDA - ME",
            "E-mail.Contato" => "marcosmachadomiranda@hotmail.com
    ",
            "CNPJ" => "07.045.799/0001-81",
            "Tel.Contato" => "(27) 3019-3843
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 434951,
            "Empresa" => "FRIBOM DISTRIBUIDORA DE CARNES LTDA - EPP",
            "E-mail.Contato" => "fribom173@gmail.com
    ",
            "CNPJ" => "09.595.977/0001-73",
            "Tel.Contato" => "(27) 3286-2132
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 569590,
            "Empresa" => "FRIGOCAP ",
            "E-mail.Contato" => "compras@frigocap.com.br
    ",
            "CNPJ" => "31.817.403/0001-51",
            "Tel.Contato" => "(27) 3286-2408
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 293729,
            "Empresa" => "FUCAM-FUNDACAO DE APOIO CASSIANO ANTONIO MORAES (FAHUCAM)",
            "E-mail.Contato" => "gerencia@fahucam.org.br
    ",
            "CNPJ" => "03.323.503/0001-96",
            "Tel.Contato" => "(27) 3335-7448
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 425119,
            "Empresa" => "FUNDACAO ASSISTENCIAL DOS EMPREGADOS DA CESAN - FAECES",
            "E-mail.Contato" => "eliana@faeces.com.br
    ",
            "CNPJ" => "00.580.481/0001-51",
            "Tel.Contato" => "(27) 2122-3928
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 309477,
            "Empresa" => "FUNDACAO BANESTES DE SEGURIDADE SOCIAL - BANESES",
            "E-mail.Contato" => "jacksonaltafim@baneses.com.br
    ",
            "CNPJ" => "28.165.132/0001-92",
            "Tel.Contato" => "(27) 3383-1900
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 244668,
            "Empresa" => "FUNDACAO CENTRO BRASILEIRO DE PROT E PESQ DAS T MARINHA",
            "E-mail.Contato" => "",
            "CNPJ" => "16.110.041/0010-61",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 414198,
            "Empresa" => "FUNDACAO DE ASSISTENCIA E EDUCACAO - FAESA ",
            "E-mail.Contato" => "fabiola.stem@faesa.br
    ",
            "CNPJ" => "27.014.042/0001-38",
            "Tel.Contato" => "(27) 2122-4512
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 407218,
            "Empresa" => "SINEPE - FUNDACAO SAO JOAO BATISTA",
            "E-mail.Contato" => "rh@fsjb.edu.br
    rh@fsjb.edu.br
    rh@fsjb.edu.br
    ",
            "CNPJ" => "27.450.709/0001-45",
            "Tel.Contato" => "(27) 3302-8055
    (27) 3302-8025
    (27) 3302-8025
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 387590,
            "Empresa" => "FUTURA SERVICE MANUTENCAO LTDA - ME ",
            "E-mail.Contato" => "rh@futuraservice.net.br
    ",
            "CNPJ" => "19.090.906/0001-72",
            "Tel.Contato" => "(27) 3328-9794
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 409836,
            "Empresa" => "G DE SOUZA CURSOS PROFISSIONALIZANTES - ME ",
            "E-mail.Contato" => "leia@pozato.com.br
    ",
            "CNPJ" => "17.183.552/0001-85",
            "Tel.Contato" => "(27) 3061-0051
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 534327,
            "Empresa" => "GVG TRANSPORTES E LOGISTICA - EIRELI ",
            "E-mail.Contato" => "comercial.es@gvgtransportes.com.br
    lucio@gvgtransportes.com.br
    simone@gvgtransportes.com.br
    ",
            "CNPJ" => "09.592.157/0001-28",
            "Tel.Contato" => "(27) 3339-3779
    (27) 3140-6353
    (27) 3339-3779
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 245016,
            "Empresa" => "G. J. R. FINISHING LTDA - ME   ",
            "E-mail.Contato" => "davidgjr78@hotmail.com
    ",
            "CNPJ" => "31.288.715/0001-15",
            "Tel.Contato" => "(27) 3222-3855
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 406876,
            "Empresa" => "GAC DO BRASIL",
            "E-mail.Contato" => "samara.macedo@gac.com
    ",
            "CNPJ" => "07.925.554/0007-34",
            "Tel.Contato" => "(21) 2233-8099
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 657313,
            "Empresa" => "GAL - GRUPO ANESTESIOLOGIA LTDA ",
            "E-mail.Contato" => "gal.contab@gmail.com
    ",
            "CNPJ" => "36.047.223/0001-51",
            "Tel.Contato" => "(27) 3315-8587
    ",
            "Sub Grupo" => "CLIENTES AVULSO"),
        array(
            "Código" => 535204,
            "Empresa" => "GALVEAS TERRA SERVICOS LTDA",
            "E-mail.Contato" => "silvana@gtpa.com.br
    ",
            "CNPJ" => "15.233.663/0001-23",
            "Tel.Contato" => "(27) 3329-0966
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 293597,
            "Empresa" => "GALWAN CONSTRUTORA E INCORPORADORA S/A ",
            "E-mail.Contato" => "Deraldo.Junior@galwan.com.br
    Maicon.Silva@galwan.com.br
    Marlete.Costa@galwan.com.br
    Odemilson.Dias@galwan.com.br
    Patricia.Ramos@galwan.com.br
    rodrigo.pereira@galwan.com.br
    vinicius.campos@galwan.com.br
    ",
            "CNPJ" => "31.705.692/0001-05",
            "Tel.Contato" => "(27) 3077-0371
    (27) 3063-6221
    (27) 3077-0370
    (27) 3026-8009
    (27) 3320-7609
    (27) 2142-9719
    (27) 3077-0371
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 399900,
            "Empresa" => "GARANTIA REAL SERVICOS LTDA. ",
            "E-mail.Contato" => "anna.paula@grupogr.com.br
     fiama.gomes@grupogr.com.br
    ",
            "CNPJ" => "00.215.548/0001-59",
            "Tel.Contato" => "(11) 3866-1700
    (11) 3866-1700
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 386433,
            "Empresa" => "GARRA ESCOLTA, VIGILANCIA E SEGURANCA LTDA ",
            "E-mail.Contato" => "comercial@grupofibra.com
    sesmt@grupofibra.com
    ",
            "CNPJ" => "04.262.215/0001-31",
            "Tel.Contato" => "
    (27) 2123-7824
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 429399,
            "Empresa" => "GBP MANUTENCAO INDUSTRIAL EIRELI - ME ",
            "E-mail.Contato" => "",
            "CNPJ" => "18.828.352/0001-03",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 672915,
            "Empresa" => "GE SOS CLIMATIZACAO E ELETRICA",
            "E-mail.Contato" => "",
            "CNPJ" => "26.991.496/0001-04",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATO ASSESSORIA"),
        array(
            "Código" => 394102,
            "Empresa" => "GENESIS TECNOLOGIA LTDA EPP",
            "E-mail.Contato" => "adm@clinux.com.br
    ",
            "CNPJ" => "04.339.655/0001-40",
            "Tel.Contato" => "(27) 3327-6976
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 622525,
            "Empresa" => "GERALE LTDA ",
            "E-mail.Contato" => "",
            "CNPJ" => "26.696.095/0001-13",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 501979,
            "Empresa" => "GEREMED SAUDE E SEGURANCA OCUPACIONAL LTDA",
            "E-mail.Contato" => "adm@geremed.com.br
    ",
            "CNPJ" => "02.419.905/0001-26",
            "Tel.Contato" => "(11) 93310-0101
    ",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 343768,
            "Empresa" => "NACIONAL SAÚDE CORPORATIVO",
            "E-mail.Contato" => "",
            "CNPJ" => "",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONVENIOS SOCNET"),
        array(
            "Código" => 653655,
            "Empresa" => "GIGALOG TRANSPORTES E LOGISTICA EIRELI",
            "E-mail.Contato" => "",
            "CNPJ" => "72.273.931/0001-74",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS EXAMES - AVULSO"),
        array(
            "Código" => 585579,
            "Empresa" => "GLOBAL MEDICINA E SAUDE OCUPACIONAL LTDA ",
            "E-mail.Contato" => "global@globalocupacional.com.br
    ",
            "CNPJ" => "00.180.220/0001-44",
            "Tel.Contato" => "(19) 3232-4334
    ",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 508893,
            "Empresa" => "GLOBAL OBRAS E SERVICOS LTDA - PRO-LIFE ",
            "E-mail.Contato" => "globalobraseservicos@gmail.com
    ",
            "CNPJ" => "26.203.788/0001-27",
            "Tel.Contato" => "(27) 99929-0405
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 472190,
            "Empresa" => "GLOBOAVES SAO PAULO AGROVICOLA LTDA",
            "E-mail.Contato" => "",
            "CNPJ" => "07.580.512/0018-61",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 398941,
            "Empresa" => "MAXSAN",
            "E-mail.Contato" => "",
            "CNPJ" => "02.905.175/0001-73",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 407553,
            "Empresa" => "GMFS COMERCIO DE VEICULOS LTDA ",
            "E-mail.Contato" => "ana.neves@hiromotors.com.br
    financeiro@hiromotors.com.br
    ",
            "CNPJ" => "25.217.002/0001-68",
            "Tel.Contato" => "(27) 3334-3836

    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 513498,
            "Empresa" => "GOBBO SERVICOS DE LIMPEZA E CARGA E DESCARGA LTDA ",
            "E-mail.Contato" => "limaes.qualit@gmail.com
    jeovania.qualit@gmail.com
    ",
            "CNPJ" => "30.432.262/0001-96",
            "Tel.Contato" => ""

    ,
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 409322,
            "Empresa" => "AMI - ASSISTENCIA A MELHOR IDADE (GOBETTI E COELHO)",
            "E-mail.Contato" => "administrativo@casaderepousoami.com
    escritorio@casaderepousoami.com
    ",
            "CNPJ" => "36.329.910/0001-60",
            "Tel.Contato" => "(27) 3347-2705
    (27) 3347-2705
    ",
            "Sub Grupo" => "CONTRATOS EXAMES - AVULSO"),
        array(
            "Código" => 399609,
            "Empresa" => "GOBETTI PANCIERI CASA DE REPOUSO PARA IDOSOS LTDA - ME ",
            "E-mail.Contato" => "assistenciageriatrica@gmail.com
    ",
            "CNPJ" => "15.724.931/0001-00",
            "Tel.Contato" => "(27) 3347-4309
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 605072,
            "Empresa" => "GOES ",
            "E-mail.Contato" => "administrativo@biosete.com.br
    ",
            "CNPJ" => "20.717.154/0001-06",
            "Tel.Contato" => "(27) 3062-2282
    ",
            "Sub Grupo" => "CLIENTES AVULSO"),
        array(
            "Código" => 244815,
            "Empresa" => "GOLD SERVICE SERVICOS LTDA - ME ",
            "E-mail.Contato" => "financeiro@gscontroledepragas.com.br
    gold.s@gscontroledepragas.com.br
    ",
            "CNPJ" => "36.319.283/0001-86",
            "Tel.Contato" => "
    (27) 3226-2122
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 399902,
            "Empresa" => "GR - GARANTIA REAL SEGURANCA LTDA ",
            "E-mail.Contato" => "anna.paula@grupogr.com.br
    anna.paula@grupogr.com.br
     fiama.gomes@grupogr.com.br
    ",
            "CNPJ" => "68.317.817/0005-55",
            "Tel.Contato" => "(11) 3866-1700
    (27) 3289-7855
    (11) 3866-1700
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 597487,
            "Empresa" => "GRACIA HELEN R. C. THEODORO SABOR DO CAMPUS",
            "E-mail.Contato" => "sabordocampus@gmail.com
    ",
            "CNPJ" => "28.731.924/0001-87",
            "Tel.Contato" => "(27) 99982-0275
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 244921,
            "Empresa" => "GRAFICA SANTO ANTONIO LTDA (GRAFICA E EDITORA - GSA) ",
            "E-mail.Contato" => "rh@graficagsa.com.br
    ",
            "CNPJ" => "28.156.297/0001-06",
            "Tel.Contato" => "(27) 3232-1293
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 394315,
            "Empresa" => "GRAMADO SERVICOS E LOCACOES LTDA ",
            "E-mail.Contato" => "seguranca@gramadoservicos.com
    ",
            "CNPJ" => "27.445.675/0001-09",
            "Tel.Contato" => "(27) 3218-3616
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 389986,
            "Empresa" => "GRANITO ZUCCHI LTDA",
            "E-mail.Contato" => "thyagomoreira@granitozucchi.com.br
    ",
            "CNPJ" => "39.622.121/0001-00",
            "Tel.Contato" => "(27) 3243-9666
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 308343,
            "Empresa" => "GRUPO ECORODOVIAS (SOCNET) ",
            "E-mail.Contato" => "",
            "CNPJ" => "",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 522504,
            "Empresa" => "GRUPO EXATTA SEGURANÇA E (SOCNET) ",
            "E-mail.Contato" => "",
            "CNPJ" => "",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONVENIOS SOCNET"),
        array(
            "Código" => 352426,
            "Empresa" => "GTI - LOG S/A ",
            "E-mail.Contato" => "n.oliveira@gtilog.com.br
    ",
            "CNPJ" => "09.721.487/0006-80",
            "Tel.Contato" => "(27) 3398-1546
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 487298,
            "Empresa" => "GTI TELECOMUNICACOES S/A",
            "E-mail.Contato" => "evertonmoreira@gtitelecom.net.br
    ",
            "CNPJ" => "13.045.346/0001-58",
            "Tel.Contato" => "(27) 2233-2221
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 575881,
            "Empresa" => "HEBROM COMERCIAL E SERVICOS INDUSTRIAIS EIRELI ",
            "E-mail.Contato" => "atendimento@hebrom.ind.br
    kelly.couto@strategic.psc.br
    ",
            "CNPJ" => "13.609.791/0001-01",
            "Tel.Contato" => "(27) 3218-5719
    (27) 3218-5719
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 591493,
            "Empresa" => "BLANK TRANSPORTES ",
            "E-mail.Contato" => "HNBLANK18@GMAIL.COM
    blanktransportesvix@gmail.com
    ",
            "CNPJ" => "04.326.152/0001-30",
            "Tel.Contato" => "(27) 3336-7950

    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 244930,
            "Empresa" => "HIPER MAQUINAS S/A",
            "E-mail.Contato" => "financeiro@hipermaquinas.com.br
    ",
            "CNPJ" => "04.726.552/0001-32",
            "Tel.Contato" => "(27) 3138-8401
    ",
            "Sub Grupo" => "CLIENTES AVULSO"),
        array(
            "Código" => 550177,
            "Empresa" => "HOLLUS SERVICOS TECNICOS ESPECIALIZADOS LTDA",
            "E-mail.Contato" => "dienytst@hotmail.com
    ",
            "CNPJ" => "06.267.018/0001-30",
            "Tel.Contato" => "(62) 3319-6059
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 394345,
            "Empresa" => "HORA DO RECREIO LANCHES LTDA - ME ",
            "E-mail.Contato" => "dp3@tellescontabilidade.com.br
    dp3@tellescontabilidade.com.br
    ",
            "CNPJ" => "09.613.796/0001-22",
            "Tel.Contato" => "(27) 3223-2369
    (27) 99759-6797
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 345979,
            "Empresa" => "HR ANDAIMES",
            "E-mail.Contato" => "renato.valim@designservicos.com
    somonaia.silva@designservicos.com
    ",
            "CNPJ" => "22.920.369/0001-55",
            "Tel.Contato" => "(27) 3379-0563
    (27) 3379-0563
    ",
            "Sub Grupo" => "CLIENTES AVULSO"),
        array(
            "Código" => 411678,
            "Empresa" => "HUDSON GALLE DE ALMEIDA - ME  / OFICINA ALMEIDA ",
            "E-mail.Contato" => "autocenteralmeida@hotmail.com
    ",
            "CNPJ" => "39.273.784/0001-67",
            "Tel.Contato" => "(27) 3226-0185
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 309552,
            "Empresa" => "VAILLANT COLCHOES E ESTOFADOS ",
            "E-mail.Contato" => "departamentopessoal@vaillant.com.br
    sarahsenatst@gmail.com
    ",
            "CNPJ" => "07.640.502/0001-26",
            "Tel.Contato" => "(27) 3341-6868
    (27) 3341-6868
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 245546,
            "Empresa" => "IBG INDUSTRIA",
            "E-mail.Contato" => "ibg9@ibg.com.br
    ",
            "CNPJ" => "67.423.152/0009-25",
            "Tel.Contato" => "(27) 3328-3761
    ",
            "Sub Grupo" => "CLIENTES AVULSO"),
        array(
            "Código" => 654420,
            "Empresa" => "IGIS - INSTITUTO DA GESTAO E INOVACAO DA SAUDE",
            "E-mail.Contato" => "compras1@igis.org.br
    financeiro@igis.org.br
    ",
            "CNPJ" => "07.156.945/0003-08",
            "Tel.Contato" => "(27) 3299-4365
    (27) 3299-4365
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 486730,
            "Empresa" => "IIG - INSTITUTO DE IMUNOGENETICA LTDA - (LIG)",
            "E-mail.Contato" => "RH@LIGDIAGNOSTICOS.COM.BR
    ",
            "CNPJ" => "30.695.183/0001-78",
            "Tel.Contato" => "(27) 3324-0492
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 602491,
            "Empresa" => "ILHA CONSTRUCOES - EIRELI ",
            "E-mail.Contato" => "",
            "CNPJ" => "21.895.435/0001-11",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 514630,
            "Empresa" => "IMTEP GSO",
            "E-mail.Contato" => "contasapagar@grupoimplus.com.br
    ",
            "CNPJ" => "24.731.954/0001-32",
            "Tel.Contato" => "(41) 3093-8600
    ",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 245628,
            "Empresa" => "INDUSTRIA DE PRODUTOS ALIMENTICIOS PIRAQUE S A ",
            "E-mail.Contato" => "josiane.farias@piraque.com.br
    ",
            "CNPJ" => "33.040.122/0008-37",
            "Tel.Contato" => "(27) 3396-7433
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 389043,
            "Empresa" => "INNOVARE DO BRASIL INDUSTRIA E COMERCIO LTDA",
            "E-mail.Contato" => "financeiro@smartstone.com.br
    flavia@innovare.ind.br
    ",
            "CNPJ" => "17.017.886/0001-89",
            "Tel.Contato" => "(27) 3208-8011
    (27) 3208-8014
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 245003,
            "Empresa" => "INOVE MARCENARIA EIRELI - ME ",
            "E-mail.Contato" => "producao@inovemarcenaria.com.br
    ",
            "CNPJ" => "10.514.907/0001-22",
            "Tel.Contato" => "(27) 3216-7942
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 245295,
            "Empresa" => "SINEPE - COLEGIO SALESIANO NOSSA SENHORA DA VITORIA ",
            "E-mail.Contato" => "sdelunardo@ucv.edu.br
    ",
            "CNPJ" => "33.583.592/0022-03",
            "Tel.Contato" => "(27) 3331-8546
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 245276,
            "Empresa" => "CENTRO UNIVERSITARIO CATOLICO DE VITORIA ",
            "E-mail.Contato" => "sdelunardo@ucv.edu.br
    ",
            "CNPJ" => "33.583.592/0069-69",
            "Tel.Contato" => "(27) 3331-8546
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 581944,
            "Empresa" => "INSTITUTO DE MEDICINA  - IMTEP (SOCNET) ",
            "E-mail.Contato" => "",
            "CNPJ" => "00.196.526/0001-99",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 469497,
            "Empresa" => "INSTITUTO DE QUALIDADE E TECNOLOGIA DE SEGURANCA VEICULAR",
            "E-mail.Contato" => "raquel@iqtsv.com.br
    financeiro@iqtsv.com.br
    ",
            "CNPJ" => "04.534.478/0001-52",
            "Tel.Contato" => "(27) 3338-6320
    (27) 3338-6320
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 362876,
            "Empresa" => "INSTITUTO MARCA DE DESENVOLVIMENTO SOCIO AMBIENTAL - IMADE",
            "E-mail.Contato" => "lexandra.luciano@marcaambiental.com.br
    ",
            "CNPJ" => "08.351.175/0001-55",
            "Tel.Contato" => "(27) 99894-2609
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 319583,
            "Empresa" => "INSTITUTO OFTALMOLOGICO ",
            "E-mail.Contato" => "institutooftalmo@gmail.com
    ",
            "CNPJ" => "31.675.010/0001-50",
            "Tel.Contato" => "(27) 3225-8233
    ",
            "Sub Grupo" => "CLIENTES AVULSO"),
        array(
            "Código" => 680239,
            "Empresa" => "INTEGRA SERVICOS ",
            "E-mail.Contato" => "poa.operacional@integrasl.com.br
    ",
            "CNPJ" => "11.739.710/0001-54",
            "Tel.Contato" => "(51) 99790-5184
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 245039,
            "Empresa" => "INTERCOMM LOGISTICA LTDA",
            "E-mail.Contato" => "rh@stilecomercial.com.br
    ",
            "CNPJ" => "08.614.527/0001-18",
            "Tel.Contato" => "(27) 2121-5600
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 257376,
            "Empresa" => "INTERMEDICA SISTEMA DE SAUDE S.A.",
            "E-mail.Contato" => "igor.nogueira@intermedica.com.br
    ",
            "CNPJ" => "44.649.812/0178-80",
            "Tel.Contato" => "(11)5627-3602
    ",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 244909,
            "Empresa" => "INTERPORT LOGISTICA LTDA ",
            "E-mail.Contato" => "medicina@grupointerport.com.br
    ",
            "CNPJ" => "02.750.555/0001-86",
            "Tel.Contato" => "(27) 2104-5447
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 474995,
            "Empresa" => "INTERVALO BAR E RESTAURANTE EIRELI - ME ",
            "E-mail.Contato" => "intervalovix@hotmail.com
    ",
            "CNPJ" => "23.447.427/0001-38",
            "Tel.Contato" => ""
    ,
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 627816,
            "Empresa" => "SAMU - IRMANDADE DA SANTA CASA DE MISERICORDIA DE VITORIA ",
            "E-mail.Contato" => "cizenandonetto@saude.es.gov.br
    marcilene.rocha@santacasavitoria.org
    ",
            "CNPJ" => "28.141.190/0001-86",
            "Tel.Contato" => "(27) 3198-0958
    (27) 3322-8683
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 324894,
            "Empresa" => "ISH TECNOLOGIA S/A ",
            "E-mail.Contato" => "eva.carvalho@ish.com.br
    ",
            "CNPJ" => "01.707.536/0001-04",
            "Tel.Contato" => "(27) 3334-8900
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 354816,
            "Empresa" => "ISO Inovar Segurança (SOCNET) ",
            "E-mail.Contato" => "",
            "CNPJ" => "",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONVENIOS SOCNET"),
        array(
            "Código" => 263968,
            "Empresa" => "ISOCIL INDUSTRIA DE EPS LTDA ",
            "E-mail.Contato" => "adm2@isocil.com.br
    ",
            "CNPJ" => "05.067.748/0001-25",
            "Tel.Contato" => "(27) 3339-8186
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 244820,
            "Empresa" => "ITAPOA SUPERMERCADO LTDA (PERIM SUPERMERCADO)",
            "E-mail.Contato" => "financeiro@superperim.com.br
    financeiro@superperim.com.br
    liliane@superperim.com.br
    ",
            "CNPJ" => "06.955.576/0001-99",
            "Tel.Contato" => "(27) 3399-1010

    (27) 3320-8900
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 604808,
            "Empresa" => "SUPERMERCADO POLETO ",
            "E-mail.Contato" => "SUPERMERCADOPOLETO@HOTMAIL.COM
    ",
            "CNPJ" => "31.495.393/0001-85",
            "Tel.Contato" => "(27) 99802-9383
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 414027,
            "Empresa" => "J.A ALIMENTOS LTDA - ME ",
            "E-mail.Contato" => "luvep@jaalimentos.com
    ",
            "CNPJ" => "14.795.543/0001-57",
            "Tel.Contato" => "(27) 2124-1954
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 295280,
            "Empresa" => "J.P NEVES CONSTRUCOES - ME",
            "E-mail.Contato" => "jpneves-construcoes@hotmail.com
    ",
            "CNPJ" => "22.733.176/0001-95",
            "Tel.Contato" => "(27) 99934-1756
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 467921,
            "Empresa" => "JC LOGISTICA E PRESTACAO DE SERVICOS EIRELI",
            "E-mail.Contato" => "rh@gotransportes.com.br
    rh@gotransportes.com.br
    rh@gotransportes.com.br
    ",
            "CNPJ" => "29.345.794/0001-07",
            "Tel.Contato" => "(27) 98159-0036
    (27) 3343-8384

    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 632677,
            "Empresa" => "JFG CONSULTORIA E PERICIAS EIRELI ",
            "E-mail.Contato" => "jfg@jfg.com.br
    ",
            "CNPJ" => "27.481.160/0001-56",
            "Tel.Contato" => "(27) 3072-0673
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 504966,
            "Empresa" => "JLA INSTALACOES E CONSTRUCOES LTDA ",
            "E-mail.Contato" => "miraildo@jlainstalacoes.com.br
    ",
            "CNPJ" => "22.667.040/0001-24",
            "Tel.Contato" => "(27) 3340-6240
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 294855,
            "Empresa" => "JM - INSTALACOES E MANUTENCOES",
            "E-mail.Contato" => "incel2008@gmail.com
    valeriovix@hotmail.com
    ",
            "CNPJ" => "12.011.908/0001-80",
            "Tel.Contato" => "(27) 3337-1000
    (27) 3337-1000
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 556213,
            "Empresa" => "JM CONSTRUCOES E EDIFICACOES EIRELI",
            "E-mail.Contato" => "construcoesedificacoesjm@hotmail.com
    ",
            "CNPJ" => "26.411.548/0001-18",
            "Tel.Contato" => "(27) 99877-8010
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 514952,
            "Empresa" => "JOAO DE ALMEIDA CONSTRUCOES EIRELI ",
            "E-mail.Contato" => "karoliny@almeidaincorporadora.com.br
    ",
            "CNPJ" => "11.960.863/0001-27",
            "Tel.Contato" => "(27) 99754-1896
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 424216,
            "Empresa" => "JOSE MARCOS VICENTE - SERVICOS E MANUTENCAO - ME ",
            "E-mail.Contato" => "vanessa.vicente08@gmail.com
    ",
            "CNPJ" => "27.146.243/0001-99",
            "Tel.Contato" => "(27) 3228-8134
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 522315,
            "Empresa" => "JOTA ELE / SH / CDG / EXXA",
            "E-mail.Contato" => "",
            "CNPJ" => "26.573.330/0001-60",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 526820,
            "Empresa" => "CONSTRUTORA J.L. ",
            "E-mail.Contato" => "luciana.terres@consorciojde.com.br
    ",
            "CNPJ" => "77.591.402/0001-32",
            "Tel.Contato" => "(27) 2233-9292
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 442476,
            "Empresa" => "JULIA LOGISTICA E SERVICOS LTDA ME - ME ",
            "E-mail.Contato" => "juliacomercioeservico@gmail.com
    ",
            "CNPJ" => "26.830.360/0001-04",
            "Tel.Contato" => "(27) 99667-2463
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 387621,
            "Empresa" => "PRENDA MULTISHOP ",
            "E-mail.Contato" => "rh@prendamultishop.com.br
    ",
            "CNPJ" => "03.862.904/0001-14",
            "Tel.Contato" => "(27) 3026-3701
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 245338,
            "Empresa" => "KAFKA CONTROLE DE PRAGAS LTDA - EPP ",
            "E-mail.Contato" => "atendimento@kafkacp.com.br
    sergio@kafkacp.com.br
    ",
            "CNPJ" => "05.915.656/0001-58",
            "Tel.Contato" => "(27) 3328-8884
    (27) 9239-2667
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 653598,
            "Empresa" => "KAYENA ALIMENTOS LTDA",
            "E-mail.Contato" => "kayena_alimentos@hotmail.com
    ",
            "CNPJ" => "15.542.326/0001-18",
            "Tel.Contato" => "(27) 3391-5235
    ",
            "Sub Grupo" => "CONTRATOS EXAMES - AVULSO"),
        array(
            "Código" => 681440,
            "Empresa" => "KAYENA ALIMENTOS LTDA ",
            "E-mail.Contato" => "kayena_alimentos@hotmail.com
    ",
            "CNPJ" => "15.542.326/0001-18",
            "Tel.Contato" => "(27) 3391-5235
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 377348,
            "Empresa" => "KISS MOTEL LTDA - EPP   ",
            "E-mail.Contato" => "kissmotel@kissmotel.com.br
    rh@maiscontabilidades.com.br
    ",
            "CNPJ" => "31.807.571/0001-66",
            "Tel.Contato" => "(27) 3093-3417

    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 245456,
            "Empresa" => "KURUMA VEICULOS S/A",
            "E-mail.Contato" => "andersono@aguiabranca.com.br
    jackelinec@aguiabranca.com.br
    maisanunes@aguiabranca.com.br
    tatianer@aguiabranca.com.br
    thaynaras@aguiabranca.com.br
    ",
            "CNPJ" => "00.827.783/0016-68",
            "Tel.Contato" => "(27) 99979-1959
    (27) 2125-4914
    (27) 2125-4911
    (27) 2125-4911
    (27) 2125-2165
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 281183,
            "Empresa" => "L & E INDUSTRIA DE FRANGO",
            "E-mail.Contato" => "dp@defrango.com.br
    atendimento@dfrango.com.br
    luzinete.laurett@hotmail.com
    ",
            "CNPJ" => "39.793.401/0001-81",
            "Tel.Contato" => "

    (27) 99982-5140
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 576975,
            "Empresa" => "L & M BENEFICIOS & SERVICOS LTDA ",
            "E-mail.Contato" => "douglas@lmbeneficiosservicos.com.br
    ",
            "CNPJ" => "27.750.858/0002-00",
            "Tel.Contato" => "(27) 99900-0479
    ",
            "Sub Grupo" => "CLIENTES AVULSO"),
        array(
            "Código" => 244935,
            "Empresa" => "L B R MOTEL E TURISMO EIRELI - EPP (POP MOTEL)",
            "E-mail.Contato" => "vizzoni@ig.com.br
    contatopopmotel@gmail.com
    ",
            "CNPJ" => "04.555.620/0001-48",
            "Tel.Contato" => "(27) 3389-3417

    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 300826,
            "Empresa" => "L B T TRANSPORTES LTDA - EPP ",
            "E-mail.Contato" => "leandro7787@hotmail.com
    ",
            "CNPJ" => "05.121.435/0001-08",
            "Tel.Contato" => "(27) 3723-6226
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 265354,
            "Empresa" => "L.M. RAMOS & CIA LTDA",
            "E-mail.Contato" => "gerente.vix@generoso.com.br
    seguranca@generoso.com.br
    ",
            "CNPJ" => "09.499.893/0001-36",
            "Tel.Contato" => "(27) 3216-5965
    (24) 2106-3167
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 256412,
            "Empresa" => "LABORAL",
            "E-mail.Contato" => "",
            "CNPJ" => "53.252.516/0001-90",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 465428,
            "Empresa" => "(NÃO USAR) LABORATORIO BIOLAB - ME ",
            "E-mail.Contato" => "",
            "CNPJ" => "36.010.254/0001-38",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 270492,
            "Empresa" => "LABORATORIO FLEMING ANALISES CLINICAS E ANATOMIA PATOLOGIC",
            "E-mail.Contato" => "rhclaudiakarninke@gmail.com
    segtrabalho@fleminglaboratorio.com.br
    ",
            "CNPJ" => "28.151.942/0001-90",
            "Tel.Contato" => "(27) 3331-3213
    (27) 3331-3218
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 244607,
            "Empresa" => "LABORATORIO LANDSTEINER S/S LTDA ",
            "E-mail.Contato" => "",
            "CNPJ" => "27.342.971/0001-76",
            "Tel.Contato" => "",
            "Sub Grupo" => "CLIENTES AVULSO"),
        array(
            "Código" => 517888,
            "Empresa" => "LANALOG TRANSPORTES ",
            "E-mail.Contato" => "breno@lanalog.com.br
    juliano@lanalog.com.br
    ",
            "CNPJ" => "08.413.272/0001-25",
            "Tel.Contato" => "(27) 3336-2655
    (27) 3336-2655
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 444881,
            "Empresa" => "LANCHONETE POINT DO SABOR LTDA - ME",
            "E-mail.Contato" => "",
            "CNPJ" => "11.417.179/0001-01",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 574434,
            "Empresa" => "LAR AZUL PRESTACAO DE SERVICOS LTDA",
            "E-mail.Contato" => "",
            "CNPJ" => "04.410.315/0001-68",
            "Tel.Contato" => "",
            "Sub Grupo" => "CLIENTES AVULSO"),
        array(
            "Código" => 244965,
            "Empresa" => "LAS VEGAS MOTEIS EIRELI - ME",
            "E-mail.Contato" => "vizzoni@ig.com.br
    ",
            "CNPJ" => "27.334.069/0001-08",
            "Tel.Contato" => "(27) 3389-3417
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 557749,
            "Empresa" => "RESTAURANTE PIONEIRO",
            "E-mail.Contato" => "restaurantepioneiro1970@hotmail.com
    ",
            "CNPJ" => "28.162.246/0001-89",
            "Tel.Contato" => "(27) 99309-9491
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 487467,
            "Empresa" => "LIDER TAXI AEREO S/A ­ AIR BRASIL (LIDER AVIACAO)",
            "E-mail.Contato" => "ewerton.ramos@lideraviacao.com.br
    ",
            "CNPJ" => "17.162.579/0021-35",
            "Tel.Contato" => "(27) 3089-4525
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 245395,
            "Empresa" => "LIFE SAUDE OCUPACIONAL LTDA",
            "E-mail.Contato" => "",
            "CNPJ" => "02.331.597/0001-82",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 293872,
            "Empresa" => "LIG SERVICE SERVICOS DE INSTALACAO E MANUTENCAO ELETRICA E",
            "E-mail.Contato" => "carla.freitas@lig.srv.br
    cassiano.reis@lig.srv.br
    financeiro@lig.srv.br
    greice.kelly@lig.srv.br
    Priscila.borges@lig.srv.br
    priscila.vieira@lig.srv.br
    ",
            "CNPJ" => "20.429.967/0001-09",
            "Tel.Contato" => "(27) 3328-1389
    (11) 4798-3473
    (11) 4798-3473
    (11) 4798-3473
    (27) 3328-1389
    (27) 3328-1389
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 354818,
            "Empresa" => "Ligamed Saúde (SOCNET) ",
            "E-mail.Contato" => "",
            "CNPJ" => "",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONVENIOS SOCNET"),
        array(
            "Código" => 375311,
            "Empresa" => "LIMP STAR PRESTADORA DE SERVICOS CONSERVACOES LTDA - ME",
            "E-mail.Contato" => "moises@limpstar.com
    ",
            "CNPJ" => "08.039.694/0001-82",
            "Tel.Contato" => "(27) 3323-1786
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 245663,
            "Empresa" => "LIPPAUS DISTRIBUICAO EIRELI ",
            "E-mail.Contato" => "ssma@lippaus.com
    flavia.soares@lippausdistribuicao.com.br
    ",
            "CNPJ" => "03.500.173/0001-67",
            "Tel.Contato" => "(27) 3346-2207
    (27) 3346-2207
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 245674,
            "Empresa" => "LIPPAUS LOGISTICA LTDA ",
            "E-mail.Contato" => "ssma@lippaus.com
    flavia.soares@lippausdistribuicao.com.br
    ",
            "CNPJ" => "05.302.000/0001-60",
            "Tel.Contato" => "(27) 3346-2207
    (27) 3346-2207
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 280311,
            "Empresa" => "LIQUIPORT VILA VELHA S.A ",
            "E-mail.Contato" => "wzahn@liquiport.com.br
    ",
            "CNPJ" => "04.461.341/0002-04",
            "Tel.Contato" => "(27) 3422-2316
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 583483,
            "Empresa" => "ATUAL CONSULTORIA E SERVICOS EMPRESARIAIS ",
            "E-mail.Contato" => "filipe@atualsegurancadotrabalho.com.br
    ivan@atualsegurancadotrabalho.com.br
    lincoln.marinho@atualsegurancadotrabalho.com.br
    ",
            "CNPJ" => "29.764.038/0001-12",
            "Tel.Contato" => "(21) 3507-7132
    (21) 3507-7132
    (21) 3507-7132
    ",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 414247,
            "Empresa" => "LOCADORA DE VEICULOS BREMENKAMP LTDA - ME ",
            "E-mail.Contato" => "transbremenkamp@hotmail.com
    ",
            "CNPJ" => "08.026.418/0001-80",
            "Tel.Contato" => "(27) 3354-1117
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 540491,
            "Empresa" => "LOCTEINER LOCACOES LTDA",
            "E-mail.Contato" => "locteiner@locteiner.com.br
    ",
            "CNPJ" => "07.575.256/0001-76",
            "Tel.Contato" => "(27) 3073-2736
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 387738,
            "Empresa" => "LOJAS SIMONETTI LTDA",
            "E-mail.Contato" => "segtrabalho@moveissimonetti.com
    ",
            "CNPJ" => "31.743.818/0001-28",
            "Tel.Contato" => "(27) 3765-0880
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 396914,
            "Empresa" => "LOLLYPOP BUFFET INFANTIL LTDA - EPP ",
            "E-mail.Contato" => "cristina@lollypop.com.br
    ",
            "CNPJ" => "05.807.751/0001-38",
            "Tel.Contato" => "(27) 3324-4044
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 245768,
            "Empresa" => "LORENGE EMPREENDIMENTOS IMOBILIARIOS LTDA",
            "E-mail.Contato" => "constasapagar@lorenge.com.br
    JOYCESOUZA@LORENGE.COM.BR
    julianarosa@lorenge.com.br
    eng.thiagofirmo@gmail.com
    ",
            "CNPJ" => "05.533.541/0001-07",
            "Tel.Contato" => "(27) 2121-5151
    (27) 3024-5737
    (27) 3024-5563
    (27) 9922-3300
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 501484,
            "Empresa" => "LORENGE SPE 150 EMPREENDIMENTO IMOBILIARIO LTDA",
            "E-mail.Contato" => "",
            "CNPJ" => "20.635.800/0001-96",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 572216,
            "Empresa" => "KIACA ALIMENTOS ",
            "E-mail.Contato" => "financeiro@kiacaalimentos.com
    ",
            "CNPJ" => "29.458.674/0001-16",
            "Tel.Contato" => "(27) 3534-7330
    ",
            "Sub Grupo" => "CLIENTES AVULSO"),
        array(
            "Código" => 392615,
            "Empresa" => "LUCFRIOS COMERCIO DE ALIMENTOS LTDA - EPP",
            "E-mail.Contato" => "adm@lucfrios.com.br
    adm@lucfrios.com.br
    ",
            "CNPJ" => "06.040.462/0001-19",
            "Tel.Contato" => "(27) 3226-3129
    (27) 3343-5249
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 442076,
            "Empresa" => "LUCIANA M L SOARES - TRANSVAREJO - ME",
            "E-mail.Contato" => "elizete.varejolog@gmail.com
    ",
            "CNPJ" => "27.361.162/0001-01",
            "Tel.Contato" => "(27) 3343-8046
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 271773,
            "Empresa" => "LUVEP LUZ VEICULOS E PECAS LTDA ",
            "E-mail.Contato" => "fatyelle.ramos@luvep.com.br
    renam.almeida@luvep.com.br
    ",
            "CNPJ" => "27.724.806/0001-89",
            "Tel.Contato" => "(27) 2124-1929
    (27) 2124-1902
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 575056,
            "Empresa" => "LW BOMBONIERI LTDA ",
            "E-mail.Contato" => "lechocolatierpcanto@gmail.com
    ",
            "CNPJ" => "32.007.693/0001-30",
            "Tel.Contato" => "(27) 3024-1665
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 520596,
            "Empresa" => "MADEIRAMADEIRA COMERCIO ELETRONICO S/A ",
            "E-mail.Contato" => "jeronimo.bertolini@madeiramadeira.com.br
    rh@madeiramadeira.com.br
    ",
            "CNPJ" => "10.490.181/0005-69",
            "Tel.Contato" => "(41) 4063-7105
    (41) 4063-7105
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 683716,
            "Empresa" => "MADS ADMINISTRATIVOS E SERVICOS LTDA",
            "E-mail.Contato" => "",
            "CNPJ" => "31.824.761/0001-91",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 683718,
            "Empresa" => "MADS ADMINISTRATIVOS E SERVICOS LTDA",
            "E-mail.Contato" => "madsservicos@gmail.com
    ",
            "CNPJ" => "31.824.761/0001-91",
            "Tel.Contato" => "(27) 3065-0602
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 408946,
            "Empresa" => "MAFORTE SERVICOS E PROJETOS LTDA ME",
            "E-mail.Contato" => "jesaias@maforteengenharia.com",
            "CNPJ" => "21.191.624/0001-03",
            "Tel.Contato" => "(27) 3288-2151",
            "Sub Grupo" => "CONTRATOS AVULSO",
            "undefined" => "CONTRATOS AVULSO"),
        array(
            "Código" => 520030,
            "Empresa" => "JM INSTALACOES ELETRICAS ",
            "E-mail.Contato" => "instalacoesjm@gmail.com
    instalacoesjm@gmail.com
    ",
            "CNPJ" => "14.791.038/0001-34",
            "Tel.Contato" => "(27) 3349-1252
    (27) 98104-7137
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 413849,
            "Empresa" => "MANTRIS (Empresa (SOCNET) ",
            "E-mail.Contato" => "",
            "CNPJ" => "",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONVENIOS SOCNET"),
        array(
            "Código" => 365176,
            "Empresa" => "MANTRIS  GESTÃO EM SAÚDE CORPORATIVA",
            "E-mail.Contato" => "",
            "CNPJ" => "19.381.564/0001-40",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 528476,
            "Empresa" => "MAPA CONSTRUTORA E SERVICOS EIRELI",
            "E-mail.Contato" => "rh01@mapa.srv.br
    financeiro01@mapa.srv.br
    ",
            "CNPJ" => "08.362.784/0001-00",
            "Tel.Contato" => "(27) 3251-7999
    (27) 3251-7999
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 244856,
            "Empresa" => "MAPA PRESTACAO DE SERVICOS LTDA - ME ",
            "E-mail.Contato" => "dianzia@mapacobrancas.com.br
    hadassa.oliveira@mapacobrancas.com.br
    ",
            "CNPJ" => "05.817.031/0001-53",
            "Tel.Contato" => "(27) 3223-5936
    (27) 3223-3656
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 257794,
            "Empresa" => "MARCA - CONSTRUTORA E SERVICOS LTDA ",
            "E-mail.Contato" => "edson.nascimento@marcaambiental.com.br
    helly.pereira@marcaambiental.com.br
    ",
            "CNPJ" => "35.971.738/0001-80",
            "Tel.Contato" => "(27)9840-9741
    (27) 2123-7111
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 257785,
            "Empresa" => "MARCA AMBIENTAL LTDA ",
            "E-mail.Contato" => "edson.nascimento@marcaambiental.com.br
    helly.pereira@marcaambiental.com.br
    ",
            "CNPJ" => "07.333.485/0001-84",
            "Tel.Contato" => "(27)9840-9741
    (27) 2123-7711
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 276383,
            "Empresa" => "MARCA RECICLA INDUSTRIA E COMERCIO LTDA - ME ",
            "E-mail.Contato" => "thayna.carmo@marcaambiental.com.br
    ",
            "CNPJ" => "09.568.606/0001-00",
            "Tel.Contato" => "(27) 2123-7711
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 295649,
            "Empresa" => "VAREJO LOG EXPRESS",
            "E-mail.Contato" => "marcelo.varejolog@gmail.com
    samuel.varejolog@gmail.com
    ",
            "CNPJ" => "20.033.712/0001-14",
            "Tel.Contato" => "(27) 3343-8046

    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 485565,
            "Empresa" => "MARROAN COUROS LTDA - ME",
            "E-mail.Contato" => "couroinox@hotmail.com
    ",
            "CNPJ" => "04.811.004/0001-00",
            "Tel.Contato" => "(27) 3317-2859
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 445928,
            "Empresa" => "MARTINELLI PAVIMENTOS ESPECIAIS LTDA - ME - UNICO ASFALTOS",
            "E-mail.Contato" => "comercial@unicoasfaltos-es.com.br
    ",
            "CNPJ" => "20.588.145/0001-62",
            "Tel.Contato" => "(27) 3086-3262
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 473832,
            "Empresa" => "MARTINS INTEGRACAO LOGISTICA LTDA",
            "E-mail.Contato" => " quedima@martins.com.br
     rodneyc@martins.com.br
    ",
            "CNPJ" => "08.653.689/0006-70",
            "Tel.Contato" => "(27) 3343-3101
    (27) 3343-3101
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 383561,
            "Empresa" => "MARUIPE COMERCIO DE GAS LTDA - ME (BETO GAS)",
            "E-mail.Contato" => "maruipegas@gmail.com
    ",
            "CNPJ" => "07.712.079/0001-22",
            "Tel.Contato" => "(27) 3200-3363
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 446859,
            "Empresa" => "MASTERMED HOSPITALAR COMERCIO E REPRESENTACOES LTDA. - ME",
            "E-mail.Contato" => "cinthia@mastermedhospitalar.com
    ",
            "CNPJ" => "27.255.624/0001-06",
            "Tel.Contato" => "(27) 99224-5838
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 558939,
            "Empresa" => "DROGAVET",
            "E-mail.Contato" => "Aline@drogavet.com
    eliezer@drogavet.com
    ",
            "CNPJ" => "30.275.306/0001-11",
            "Tel.Contato" => "(27) 99527-8210
    (27) 2142-3262
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 574791,
            "Empresa" => "MAURICIO DE ASSIS DA SILVA 82042489700 ",
            "E-mail.Contato" => "chinarteiro@gmail.com
    ",
            "CNPJ" => "23.257.198/0001-99",
            "Tel.Contato" => "(27) 99741-1823
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 266031,
            "Empresa" => "MB IMPORTACAO E DISTRIBUICAO ",
            "E-mail.Contato" => "fiscal01.mb@lagoalog.com.br
    rh@mbdistribuidora.com.br
    ",
            "CNPJ" => "06.752.049/0002-68",
            "Tel.Contato" => "(27) 3254-8410
    (27) 3254-8402
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 434191,
            "Empresa" => "MB5 COMERCIO IMPORTACAO E EXPORTACAO (GRUPO SOARES) ",
            "E-mail.Contato" => "elaine.neves@gruposoares.com.br
    ",
            "CNPJ" => "06.698.001/0002-19",
            "Tel.Contato" => "(27) 2121-9000
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 676560,
            "Empresa" => "MBI CONSTRUCOES E MONTAGENS INDUSTRIAIS EIRELI",
            "E-mail.Contato" => "",
            "CNPJ" => "27.906.867/0001-67",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 507733,
            "Empresa" => "MD SISTEMAS DE COMPUTACAO LTDA (SENIOR)",
            "E-mail.Contato" => "adm.pessoal@senior-es.com.br
    financeiro@senior-es.com.br
    naiara.francisconi@senior-es.com.br
    ",
            "CNPJ" => "39.270.012/0001-71",
            "Tel.Contato" => "(27) 2122-6300
    (27) 2122-6300
    (27) 2121-6300
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 546278,
            "Empresa" => "MEDI LABOR CONSULTORIA MEDICA LTDA (MEDQUALITY)",
            "E-mail.Contato" => "carla@medquality.com.br
    ",
            "CNPJ" => "00.487.762/0001-64",
            "Tel.Contato" => "(21) 2277-7373
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 426502,
            "Empresa" => "MEDINTERV LTDA - ME ",
            "E-mail.Contato" => "medinterv_es@yahoo.com.br
    ",
            "CNPJ" => "20.477.222/0001-07",
            "Tel.Contato" => "(27) 3026-5567
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 295375,
            "Empresa" => "MEDLINK",
            "E-mail.Contato" => "cbaffa@medlinkservicos.com.br
    pericias@medlinkservicos.com.br
    ",
            "CNPJ" => "10.906.015/0001-77",
            "Tel.Contato" => "
    (11) 2574-2593
    ",
            "Sub Grupo" => "CLIENTES AVULSO"),
        array(
            "Código" => 287574,
            "Empresa" => "MEDNET GESTAO EM SAUDE OCUPACIONAL LTDA (VITORIA)",
            "E-mail.Contato" => "",
            "CNPJ" => "06.943.923/0001-63",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 256428,
            "Empresa" => "MEDTRA S/S LTDA",
            "E-mail.Contato" => "",
            "CNPJ" => "01.000.251/0001-39",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 350460,
            "Empresa" => "MEGA SERVICE CONSTRUTORA LTDA - ME ",
            "E-mail.Contato" => "",
            "CNPJ" => "18.038.305/0001-58",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 245104,
            "Empresa" => "MEGA TRANSPORTES E SERVICOS LTDA - EPP ",
            "E-mail.Contato" => "rh@megatransporte.com.br
    ",
            "CNPJ" => "05.894.665/0001-00",
            "Tel.Contato" => "(27) 3366-3472
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 332132,
            "Empresa" => "MEGALAV LAVANDERIA HOSPITALAR EIRELI - ME",
            "E-mail.Contato" => "anderson@grupolaves.com.br
    ",
            "CNPJ" => "13.552.149/0001-25",
            "Tel.Contato" => "(27) 3317-3001
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 354815,
            "Empresa" => "MENDES & BRAGA GESTÃO DE (SOCNET) - MASTERMED",
            "E-mail.Contato" => "",
            "CNPJ" => "",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 505472,
            "Empresa" => "MEP SERVICE ELECTRIC LTDA",
            "E-mail.Contato" => "rian@mepse.com.br
    ",
            "CNPJ" => "22.905.705/0001-90",
            "Tel.Contato" => "(27) 3100-3454
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 529153,
            "Empresa" => "MEPY TRANSPORTES ",
            "E-mail.Contato" => "farmaceutico.vix@transmep.com.br
    mepyvix@transmep.com.br
    murilo@transmep.com.br
    PAULO@TRANSMEP.COM.BR",
            "CNPJ" => "26.724.924/0001-24",
            "Tel.Contato" => "(27) 3029-0840, (27) 9949-8821",
            "Sub Grupo" => "CONTRATOS EXAMES",
            "undefined" => ""),
        array(
            "Código" => 623477,
            "Empresa" => "MERCANTIL PRIMOR LTDA ",
            "E-mail.Contato" => "dp@vilavitoriamercantil.com.br
    ",
            "CNPJ" => "01.436.516/0001-46",
            "Tel.Contato" => "(27) 3386-0444
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 530668,
            "Empresa" => "MESTRA SERVICE  (OPCAO SMS)",
            "E-mail.Contato" => "luciano@mestraservice.com.br
    ",
            "CNPJ" => "20.974.586/0001-00",
            "Tel.Contato" => "(21) 3137-5335
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 490516,
            "Empresa" => "MESTRAVIX ENGENHARIA ",
            "E-mail.Contato" => "cristina@mestravix.com.br
    ",
            "CNPJ" => "27.870.683/0001-94",
            "Tel.Contato" => "(27) 3022-6461
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 463857,
            "Empresa" => "META (Principal) (SOCNET) ",
            "E-mail.Contato" => "",
            "CNPJ" => "02.283.294/0001-31",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONVENIOS SOCNET"),
        array(
            "Código" => 244998,
            "Empresa" => "META MEDICINA",
            "E-mail.Contato" => "",
            "CNPJ" => "02.283.294/0001-31",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONVENIOS SOCNET"),
        array(
            "Código" => 256411,
            "Empresa" => "METASEG TREINAMENTO E CONSULTORIA EM QSMS LTDA - ME",
            "E-mail.Contato" => "",
            "CNPJ" => "14.456.077/0001-85",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 244835,
            "Empresa" => "METROLOGY - MEDICOES & TECNOLOGIA EIRELI - EPP   ",
            "E-mail.Contato" => "qualidade@metrology.com.br
    ",
            "CNPJ" => "10.442.296/0001-54",
            "Tel.Contato" => "(27) 3222-4820
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 627938,
            "Empresa" => "METROPOLITANA TRANSPORTES E SERVICOS LTDA ",
            "E-mail.Contato" => "jairrarosa@mt-es.com.br
    pollyannaramos@mt-es.com.br
    ",
            "CNPJ" => "10.643.644/0001-51",
            "Tel.Contato" => "(27) 3246-4712
    (27) 3246-4712
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 357587,
            "Empresa" => "MEZZALIRA COMERCIO E IMPORTACAO LTDA ",
            "E-mail.Contato" => "compras@mezzalira.com.br
    ",
            "CNPJ" => "07.341.362/0002-76",
            "Tel.Contato" => "(22) 2105-0230
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 244616,
            "Empresa" => "MG VIDROS AUTOMOTIVOS LTDA - AUTOGLASS",
            "E-mail.Contato" => "suportesoc@provider-es.com.br
    integraautoglass@provider-es.com.br
    maiara@provider-es.com.br
    seguranca@autoglass.com.br
    thays.pereira@autoglass.com.br
    ",
            "CNPJ" => "07.571.746/0009-51",
            "Tel.Contato" => "

    (27) 2104-1157

    (27) 3033-2347
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 486343,
            "Empresa" => "MH MANUTENCAO E INSTALACAO DE SISTEMAS LTDA",
            "E-mail.Contato" => "ricardo.cerqueira@rcmengenharia.com
    ",
            "CNPJ" => "12.662.290/0001-18",
            "Tel.Contato" => "(11) 3263-1282
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 433675,
            "Empresa" => "MIL PRINT INFORMATICA EIRELI - EPP ",
            "E-mail.Contato" => "financeiro@officetek.com.br, geise.langa@officetek.com.br",
            "CNPJ" => "23.791.227/0001-06",
            "Tel.Contato" => "(27) 3335-0000, (27) 3335-0000",
            "Sub Grupo" => "CONTRATOS EXAMES",
            "undefined" => "",
            "undefined" => "CONTRATOS EXAMES"),
        array(
            "Código" => 268907,
            "Empresa" => "MILLAR IMPORTACAO E EXPORTACAO LTDA ",
            "E-mail.Contato" => "rh@millar.com.br",
            "CNPJ" => "04.331.164/0001-52",
            "Tel.Contato" => "(27) 3434-1000",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 244605,
            "Empresa" => "MINERVA S.A. ",
            "E-mail.Contato" => "rh-es@minervafoods.com
    ",
            "CNPJ" => "67.620.377/0070-46",
            "Tel.Contato" => ""
    ,
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 356212,
            "Empresa" => "MINNY COMERCIO E SERVICOS LTDA - EPP (FLY MOTEL)",
            "E-mail.Contato" => "dp@motelfly.com.br
    ",
            "CNPJ" => "03.226.298/0001-40",
            "Tel.Contato" => "(27) 3226-7035
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 242280,
            "Empresa" => "MIRANDA MEDEIROS & CIA LTDA (MEDTRAB) (SOCNET) ",
            "E-mail.Contato" => "",
            "CNPJ" => "10.730.637/0001-97",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONVENIOS SOCNET"),
        array(
            "Código" => 245551,
            "Empresa" => "MITRA ARQUIDIOCESANA DE VITORIA",
            "E-mail.Contato" => "construtora@destefani.com.br
    ",
            "CNPJ" => "27.054.162/0101-21",
            "Tel.Contato" => "(27) 3317-1726
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 410600,
            "Empresa" => "ML REFRIGERACAO EIRELI - ME ",
            "E-mail.Contato" => "fabricio@mlassistencia.com.br
    ",
            "CNPJ" => "07.976.638/0001-01",
            "Tel.Contato" => "(27) 99980-9074
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 561355,
            "Empresa" => "MM ARQUITETURA EIRELI",
            "E-mail.Contato" => "silvaniomagno@gmail.com
    ",
            "CNPJ" => "21.231.007/0001-94",
            "Tel.Contato" => ""
    ,
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 630174,
            "Empresa" => "MMMUST PRODUTOS NATURAIS LTDA ",
            "E-mail.Contato" => "gabriela@mmmust.com.br
    ",
            "CNPJ" => "32.548.431/0001-83",
            "Tel.Contato" => "(27) 2141-1000
    ",
            "Sub Grupo" => "CLIENTES AVULSO"),
        array(
            "Código" => 578758,
            "Empresa" => "MONTE SIAO MINERACAO EIRELI (BRUNO ZANET BRASIL) ",
            "E-mail.Contato" => "mizael.tst@gmail.com
    ",
            "CNPJ" => "18.862.543/0001-83",
            "Tel.Contato" => "(27) 3010-3110
    ",
            "Sub Grupo" => "CONTRATOS EXAMES - AVULSO"),
        array(
            "Código" => 245261,
            "Empresa" => "MONZA PRODUTOS PANIFICADOS LTDA - ME  ",
            "E-mail.Contato" => "rh@confeitariamonza.com.br
    padariamonza@hotmail.com
    ",
            "CNPJ" => "11.397.343/0001-58",
            "Tel.Contato" => "(27) 99298-0670
    (27) 3026-5891
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 572127,
            "Empresa" => "MOTO VIX SERRA LTDA",
            "E-mail.Contato" => "larissa.vix@lagunamotos.com.br
    ",
            "CNPJ" => "31.856.682/0001-62",
            "Tel.Contato" => "(27) 3334-3838
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 571725,
            "Empresa" => "MOTO VIX VITORIA LTDA",
            "E-mail.Contato" => "financeiro@motovix.com.br
    ",
            "CNPJ" => "31.870.691/0001-08",
            "Tel.Contato" => "(27) 3089-4089
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 244961,
            "Empresa" => "MP DISTRIBUIDORA",
            "E-mail.Contato" => "",
            "CNPJ" => "07.790.732/0001-71",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 583346,
            "Empresa" => "MR PRESTACAO DE SERVICOS EMPRESARIAIS LTDA ",
            "E-mail.Contato" => "servicosempresariaismr@gmail.com
    ",
            "CNPJ" => "30.680.675/0001-90",
            "Tel.Contato" => "(27) 99686-8631
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 284154,
            "Empresa" => "MRV CONSTRUCOES LTDA bp",
            "E-mail.Contato" => "andreza.aline@mrv.com.br
    genilson.costa@mrv.com.br
    marina.costa@mrv.com.br
    ",
            "CNPJ" => "19.992.962/0001-00",
            "Tel.Contato" => "(27) 3204-0200
    (27) 99877-1233

    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 284306,
            "Empresa" => "MRV CONSTRUCOES / UNIT",
            "E-mail.Contato" => "andreza.aline@mrv.com.br
    genilson.costa@mrv.com.br
    marina.costa@mrv.com.br
    ",
            "CNPJ" => "19.992.962/0001-00",
            "Tel.Contato" => "(27) 3204-0200
    (27) 99877-1233

    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 255255,
            "Empresa" => "MRV / UNIT",
            "E-mail.Contato" => "",
            "CNPJ" => "08.343.492/0134-50",
            "Tel.Contato" => "",
            "Sub Grupo" => "Sem Contrato"),
        array(
            "Código" => 426863,
            "Empresa" => "MT ENGENHARIA, CONSTRUCAO E PROJETOS EIRELI ",
            "E-mail.Contato" => "patriky@mtengenhariaeprojetos.com
    ",
            "CNPJ" => "26.645.367/0001-56",
            "Tel.Contato" => "(27) 3070-3020
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 408735,
            "Empresa" => "MUDS BEER & BAR LTDA ME",
            "E-mail.Contato" => "",
            "CNPJ" => "26.244.957/0001-77",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 546232,
            "Empresa" => "MULTVENDAS DISTRIBUICAO LTDA ",
            "E-mail.Contato" => "multvendas.dp@hotmail.com
    financeirorio.multvendas@gmail.com
    ",
            "CNPJ" => "11.032.895/0002-43",
            "Tel.Contato" => "(27) 3063-4333
    (27) 3226-2108
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 485303,
            "Empresa" => "MUSILE INSTALACAO",
            "E-mail.Contato" => "rh2@kiir.com.br
    ",
            "CNPJ" => "28.581.598/0001-79",
            "Tel.Contato" => "(11) 4613-4603
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 550558,
            "Empresa" => "MVG TRANSPORTES EIRELI  (RODOMAIS)",
            "E-mail.Contato" => "rh@rodomais.com.br
    giovanni.goncalves@rodomais.com.br
    ",
            "CNPJ" => "02.082.008/0006-84",
            "Tel.Contato" => "(27) 3089-5894
    (27) 3089-5894
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 279147,
            "Empresa" => "N2 OFFSHORE COMERCIO E SERVICOS LTDA - ME",
            "E-mail.Contato" => "naty@n2offshore.com
    nfe@n2offshore.com
    ",
            "CNPJ" => "19.161.888/0001-72",
            "Tel.Contato" => "(27) 3226-1228

    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 495543,
            "Empresa" => "N2 TOPOGRAFIA EIRELI - M",
            "E-mail.Contato" => "n2topografia@gmail.com
    ",
            "CNPJ" => "24.377.099/0001-03",
            "Tel.Contato" => "(27) 99719-6982
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 652502,
            "Empresa" => "NACIONAL SAUDE",
            "E-mail.Contato" => "natasha.oliveira@nacionalsaude.net.br
    ",
            "CNPJ" => "30.683.813/0001-94",
            "Tel.Contato" => "(11) 3129-3620
    ",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 328427,
            "Empresa" => "MD SISTEMAS - HOMOLOGACAO",
            "E-mail.Contato" => "",
            "CNPJ" => "39.270.012/0001-71",
            "Tel.Contato" => "",
            "Sub Grupo" => "Sem Contrato"),
        array(
            "Código" => 389226,
            "Empresa" => "NÃO USAR - MG VIDROS - HOMOLOGACAO",
            "E-mail.Contato" => "",
            "CNPJ" => "07.571.746/0009-51",
            "Tel.Contato" => "",
            "Sub Grupo" => "Sem Contrato"),
        array(
            "Código" => 357819,
            "Empresa" => "NASCIMENTO LOCACOES & SERVICOS LTDA - ME ",
            "E-mail.Contato" => "contato@nascimentolocacoes.com.br
    ",
            "CNPJ" => "19.557.797/0001-50",
            "Tel.Contato" => ""
    ,
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 293293,
            "Empresa" => "NASSAU EDITORA - REDE TRIBUNA",
            "E-mail.Contato" => "rtv@redetribuna.com.br
    segurancadotrabalho@redetribuna.com.br
    ",
            "CNPJ" => "27.065.150/0001-30",
            "Tel.Contato" => "
    (27) 3331-9117
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 428384,
            "Empresa" => "NATURALIS HORTIFRUTIGRANJEIROS LTDA EPP",
            "E-mail.Contato" => "rabelo.joseedilson@gmail.com
    rabelo.joseedilson@gmail.com
    ",
            "CNPJ" => "26.517.069/0001-80",
            "Tel.Contato" => "(27) 3019-4575
    (27) 3063-2263
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 565493,
            "Empresa" => "NAVIX DESPACHO DE NAVIOS LTDA",
            "E-mail.Contato" => "financeiro@navixvix.com.br
    ",
            "CNPJ" => "18.654.085/0001-97",
            "Tel.Contato" => "(27) 3322-6313
    ",
            "Sub Grupo" => "CLIENTES AVULSO"),
        array(
            "Código" => 354178,
            "Empresa" => "DOMINEOACO",
            "E-mail.Contato" => "",
            "CNPJ" => "25.205.839/0001-97",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 321367,
            "Empresa" => "NET SERVICE S/A ",
            "E-mail.Contato" => "aline.rocha@netservice.com
    christiano.chaves@netservice.com
    ",
            "CNPJ" => "00.427.205/0002-39",
            "Tel.Contato" => "(27) 3134-1100
    (27) 3134-1110
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 486957,
            "Empresa" => "NETWORKS SOLUCOES EM INFORMATICA LTDA - ME",
            "E-mail.Contato" => "faturamento@nwt.net.br
    financeiro@nwt.net.br
    ",
            "CNPJ" => "12.403.032/0001-17",
            "Tel.Contato" => "(27) 4062-9035

    ",
            "Sub Grupo" => "CONTRATOS EXAMES - AVULSO"),
        array(
            "Código" => 399991,
            "Empresa" => "NEXUS MEDICINA OCUP. (SOCNET) ",
            "E-mail.Contato" => "",
            "CNPJ" => "09.490.800/0001-02",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONVENIOS SOCNET"),
        array(
            "Código" => 262856,
            "Empresa" => "NEXUS GESTAO EM SAUDE",
            "E-mail.Contato" => "sirlene.zanfurlin@nexussaude.com.br
    ",
            "CNPJ" => "09.490.800/0001-02",
            "Tel.Contato" => "(11)5904-6659
    ",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 311072,
            "Empresa" => "NF PINTURAS CIVIS LTDA - EPP ",
            "E-mail.Contato" => "aapintura@gmail.com
    nfpintura@terra.com.br
    ",
            "CNPJ" => "13.356.983/0001-45",
            "Tel.Contato" => "(27) 99764-2191
    (27) 3324-2734
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 310732,
            "Empresa" => "NORTES TRANSPORTE COMERCIO E SERVICOS EIRELI   ",
            "E-mail.Contato" => "financeiro@nortestransporte.com.br
    financeiro@nortestransporte.com.br
    ",
            "CNPJ" => "17.814.074/0001-64",
            "Tel.Contato" => "(27) 3096-3535
    (27) 3096-3535
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 491569,
            "Empresa" => "NOVAFORMA PLASTICOS LTDA",
            "E-mail.Contato" => "felipe.lemos@novaformapvc.com.br
    francine.goncalves@novaformapvc.com.br
    ingrid.alves@novaformapvc.com.br
    marcelo.lopes@novaformapvc.com.br
    ",
            "CNPJ" => "03.845.190/0001-36",
            "Tel.Contato" => "(27) 99871-6215
    (27) 3236-8555
    (27) 3236-8555
    (27) 3246-4750
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 609819,
            "Empresa" => "NR+ CONSULTORIA E COMERCIO LTDA ",
            "E-mail.Contato" => "karina.faria@nrmaisconsultoria.com.br
    ",
            "CNPJ" => "27.554.043/0001-75",
            "Tel.Contato" => "(11) 3151-5356
    ",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 632554,
            "Empresa" => "NUCLEO PAES SANTOS RADIOLOGIA LTDA ",
            "E-mail.Contato" => "financeiro.c3@hotmail.com
    nucleogerenciavix@gmail.com
    ",
            "CNPJ" => "30.054.409/0001-51",
            "Tel.Contato" => "(31) 3367-2238

    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 408198,
            "Empresa" => "SINEPE - OBRAS PASSIONISTAS SAO PAULO DA CRUZ",
            "E-mail.Contato" => "passiofinanceiro@yahoo.com.br
    ",
            "CNPJ" => "28.068.005/0003-37",
            "Tel.Contato" => "(27) 3226-0757
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 320833,
            "Empresa" => "OCTOPUS SERVICOS MARITIMOS LTDA - ME ",
            "E-mail.Contato" => "octopus@octopusmaritimo.com
    ",
            "CNPJ" => "39.285.713/0001-84",
            "Tel.Contato" => "(27) 99949-6338
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 551557,
            "Empresa" => "OFTALMED CLINICA MEDICA LTDA",
            "E-mail.Contato" => "",
            "CNPJ" => "29.189.116/0001-00",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 263120,
            "Empresa" => "OILTANKING TERMINAIS LTDA",
            "E-mail.Contato" => "recepcao.vix@oiltanking.com
    luzeni.santos@oiltanking.com
    nfe.vix@oiltanking.com
    sabrina.fonseca@oiltanking.com
    ",
            "CNPJ" => "04.409.230/0003-21",
            "Tel.Contato" => "
    (27) 3204-3987


    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 245321,
            "Empresa" => "OLIVEIRA PRATES ESTETICA DENTAL LTDA - ME",
            "E-mail.Contato" => "allanpratestpd@hotmail.com
    ",
            "CNPJ" => "11.159.835/0001-05",
            "Tel.Contato" => "(27) 3222-0665
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 331225,
            "Empresa" => "OLIVIERI E CARVALHO ADVOGADOS ASSOCIADOS ",
            "E-mail.Contato" => "rh@avocati.adv.br
    magda@avocati.adv.br
    ",
            "CNPJ" => "01.168.581/0001-38",
            "Tel.Contato" => "(27) 3025-5150
    (27) 3025-5150
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 335146,
            "Empresa" => "OMEGA IMOVEIS E SERVICOS LTDA - ME (BETHA ESPACO)",
            "E-mail.Contato" => "dpessoal@bethaespaco.com.br
    dpessoal01@bethaespaco.com.br
    ",
            "CNPJ" => "09.380.829/0001-31",
            "Tel.Contato" => "(27) 3022-5444
    (27) 3022-5444
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 291792,
            "Empresa" => "ONCOCLINICA LTDA ",
            "E-mail.Contato" => "",
            "CNPJ" => "02.330.186/0001-72",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 426050,
            "Empresa" => "ONIX SOLUCOES LTDA - ME ",
            "E-mail.Contato" => "exames@onixmedicinadotrabalho.com.br
    ",
            "CNPJ" => "17.895.550/0001-19",
            "Tel.Contato" => "(11) 2373-6070
    ",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 339805,
            "Empresa" => "OPPORTUNITY FUNDO DE INVESTIMENTO IMOBILIARIO ",
            "E-mail.Contato" => "administracaoobra@sanjuan.ind.br
    ",
            "CNPJ" => "01.235.622/0001-61",
            "Tel.Contato" => "(27) 3019-3400
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 678127,
            "Empresa" => "ORB LABORATORIO DE ANALISES CLINICAS LTDA ",
            "E-mail.Contato" => "",
            "CNPJ" => "13.525.814/0001-91",
            "Tel.Contato" => "",
            "Sub Grupo" => "CLIENTES AVULSO"),
        array(
            "Código" => 364601,
            "Empresa" => "ORDEM DE SERVICO",
            "E-mail.Contato" => "",
            "CNPJ" => "",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 563928,
            "Empresa" => "ORGANIZACAO EXCEL ASSESSORIA SS - EIRELI",
            "E-mail.Contato" => "gestor@eologistica.com.br
    ",
            "CNPJ" => "05.313.073/0001-57",
            "Tel.Contato" => "(13) 3227-7977
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 245341,
            "Empresa" => "OGMO",
            "E-mail.Contato" => "gabriela.grigio@ogmoes.com.br
    julio.freitas@ogmoes.com.br
    luciana.medeiros@ogmoes.com.br
    ",
            "CNPJ" => "39.634.928/0001-63",
            "Tel.Contato" => "(27) 3212-6574
    (27) 3212-6554
    (27) 3212-6574
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 244735,
            "Empresa" => "ORGBRISTOL ORGANIZACOES BRISTOL LTDA",
            "E-mail.Contato" => "dp04.es@redebristol.com.br
    dp03.es@redebristol.com.br
    dp02.es@redebristol.com.br
    ",
            "CNPJ" => "23.306.087/0013-69",
            "Tel.Contato" => "(27) 3315-0505
    (27) 3334-8955
    (27) 3315-0505
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 358754,
            "Empresa" => "OZZY CONSTRUTORA E SERVICOS LTDA - ME ",
            "E-mail.Contato" => "ozzyconstrutora@gmail.com
    ",
            "CNPJ" => "17.392.489/0001-97",
            "Tel.Contato" => "(27) 3316-6298
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 253919,
            "Empresa" => "PADARIA E CONFEITARIA LUPE EIRELI - EPP (TORTELLOTI )",
            "E-mail.Contato" => "nando.cascardo@gmail.com
    financeirocasadopao@gmail.com
    ",
            "CNPJ" => "07.584.682/0001-76",
            "Tel.Contato" => "(27) 3389-5318
    (27) 3389-5318
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 309264,
            "Empresa" => "PAG S.A MEIOS DE PAGAMENTO (AVISTA)",
            "E-mail.Contato" => "bruna.siqueira@avistanet.com.br
    daniele.mosquini@avistanet.com.br
    simone.melo@avistanet.com.br
    ",
            "CNPJ" => "04.533.779/0001-61",
            "Tel.Contato" => "(27) 2123-2323
    (27) 2123-2323
    (27) 2123-2323
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 340669,
            "Empresa" => "PANIFICADORA DELAMASSA LTDA EPP - EPP ",
            "E-mail.Contato" => "alessiane@delamassa.com",
            "CNPJ" => "14.655.154/0001-26",
            "Tel.Contato" => "(27) 3386-7514",
            "Sub Grupo" => "CONTRATOS EXAMES",
            "undefined" => "CONTRATOS EXAMES"),
        array(
            "Código" => 674655,
            "Empresa" => "PAPA FESTAS COMERCIO VAREJISTA DE ARTIGOS DE FESTA LTDA",
            "E-mail.Contato" => "",
            "CNPJ" => "33.521.104/0001-09",
            "Tel.Contato" => "",
            "Sub Grupo" => "CLIENTES AVULSO"),
        array(
            "Código" => 244989,
            "Empresa" => "PARTICULAR",
            "E-mail.Contato" => "",
            "CNPJ" => "",
            "Tel.Contato" => "",
            "Sub Grupo" => "CLIENTES AVULSO"),
        array(
            "Código" => 682272,
            "Empresa" => "SCHMITT REFRIGERACAO ",
            "E-mail.Contato" => "schmittrefrigeracao@gmail.com
    ",
            "CNPJ" => "20.130.366/0001-92",
            "Tel.Contato" => "(27) 9970-7860
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 310722,
            "Empresa" => "PAUMO TRANSPORTES EIRELI - ME ",
            "E-mail.Contato" => "rh@nortestransporte.com.br
    financeiro@nortestransporte.com.br
    ",
            "CNPJ" => "13.008.142/0001-47",
            "Tel.Contato" => "(27) 3096-3535
    (27) 3096-3535
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 245202,
            "Empresa" => "PAUTA 6 COMUNICACAO LTDA",
            "E-mail.Contato" => "bruna.davila@p6comunicacao.com.br
    ",
            "CNPJ" => "32.424.236/0001-41",
            "Tel.Contato" => "(27) 3235-6999
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 384632,
            "Empresa" => "PBA SERVICOS E COMERCIO DE PEDRAS ORNAMENTAIS LTDA",
            "E-mail.Contato" => "robson.simoes@pbastones.com.br
    ",
            "CNPJ" => "07.214.630/0001-08",
            "Tel.Contato" => "(27) 2233-8250
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 463067,
            "Empresa" => "PEGASO TRANSPORTES LTDA - EPP ",
            "E-mail.Contato" => "pegaso@pegasotransportes.com.br
    ",
            "CNPJ" => "05.567.203/0001-88",
            "Tel.Contato" => "(27) 3255-1651
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 678869,
            "Empresa" => "PEOPLE RECURSOS HUMANOS",
            "E-mail.Contato" => "comercial.jundiai@rhpeople.com.br
    ",
            "CNPJ" => "02.129.942/0003-61",
            "Tel.Contato" => "(11) 4497-0408
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 245384,
            "Empresa" => "PERFIL ALUMINIO DO BRASIL S/A - MATRIZ",
            "E-mail.Contato" => "daniel.mendes@perfilcm.com.br
    dp@perfilcm.com.br
    dp.anodizadora@perfilcm.com.br
    tecseguranca@perfilcm.com.br
    ",
            "CNPJ" => "05.069.718/0001-58",
            "Tel.Contato" => "(27) 3141-5929
    (27) 3041-5931
    (27) 3041-5938
    (27) 3041-5909
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 244704,
            "Empresa" => "PERFIL ALUMINIO DO BRASIL S/A - VIANA EXTRUSORA",
            "E-mail.Contato" => "daniel.mendes@perfilcm.com.br
    dp@perfilcm.com.br
    tecseguranca@perfilcm.com.br
    dp.anodizadora@perfilcm.com.br
    ",
            "CNPJ" => "05.069.718/0003-10",
            "Tel.Contato" => "(27) 3141-5929
    (27) 3041-5931
    (27) 3041-5909
    (27) 3041-5938
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 354813,
            "Empresa" => "PERFIL Gestão em Saúde e (SOCNET) ",
            "E-mail.Contato" => "",
            "CNPJ" => "",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 557571,
            "Empresa" => "PERFIL GESTAO EM SAUDE E SEGURANCA NO TRABALHO LTDA",
            "E-mail.Contato" => "comercial4@perfilgestaoocupacional.com.br
    ",
            "CNPJ" => "10.624.793/0001-73",
            "Tel.Contato" => "(13) 3223-7772
    ",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 678590,
            "Empresa" => "PERFIL GESTÃO OCUPACIONAL",
            "E-mail.Contato" => "",
            "CNPJ" => "10.624.793/0001-73",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 519873,
            "Empresa" => "PESTANA COMERCIO E IMPORTACAO LTDA",
            "E-mail.Contato" => "pestanaimport@uol.com.br
    ",
            "CNPJ" => "39.320.411/0001-08",
            "Tel.Contato" => "(27) 3200-4696
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 573728,
            "Empresa" => "PETROVERA - POSTO DE PRODUTOS DE PETROLEO E TRANSPORTES LT",
            "E-mail.Contato" => "vanderleipfiori@hotmail.com
    ",
            "CNPJ" => "27.926.384/0001-24",
            "Tel.Contato" => "(27) 99729-6520
    ",
            "Sub Grupo" => "CONTRATOS EXAMES - AVULSO"),
        array(
            "Código" => 408091,
            "Empresa" => "PHD OCUPACIONAL E TREINAMENTO LTDA - ME ",
            "E-mail.Contato" => "phdengenhariaocupacional@hotmail.com
    ",
            "CNPJ" => "20.460.009/0001-92",
            "Tel.Contato" => "(27) 3347-4116
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 529239,
            "Empresa" => "PLASTFER USINAGEM LTDA ",
            "E-mail.Contato" => "financeiro@pte.com.br
    ",
            "CNPJ" => "29.296.150/0001-76",
            "Tel.Contato" => "(27) 3067-8800
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 315096,
            "Empresa" => "PLASTFORT INDUSTRIA E COMERCIO LTDA - ME ",
            "E-mail.Contato" => "plastfort@plastfort.com.br
    ",
            "CNPJ" => "02.926.644/0001-30",
            "Tel.Contato" => "(27) 3328-3334
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 677929,
            "Empresa" => "PMO MEDICINA OCUPACIONAL ",
            "E-mail.Contato" => "",
            "CNPJ" => "34.148.686/0001-84",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 549618,
            "Empresa" => "PNEUMAX LTDA",
            "E-mail.Contato" => "",
            "CNPJ" => "39.814.835/0001-10",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 348793,
            "Empresa" => "PNR IMPORT COMERCIO",
            "E-mail.Contato" => "",
            "CNPJ" => "17.689.055/0001-53",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 245407,
            "Empresa" => "POLITINTAS LTDA - MATRIZ (CAMPO GRANDE)",
            "E-mail.Contato" => "desenvolvimento@politintas.com.br
    trabalhecom@politintas.com.br
    ",
            "CNPJ" => "27.171.883/0001-59",
            "Tel.Contato" => "(27) 3246-3200

    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 245094,
            "Empresa" => "POLO ASSESSORIA E SERVICOS ADUANEIROS LTDA - EPP ",
            "E-mail.Contato" => "rh@stilecomercial.com.br
    ",
            "CNPJ" => "06.238.880/0001-15",
            "Tel.Contato" => "(27) 2121-5600
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 479475,
            "Empresa" => "POLO SUPRIMENTOS LTDA - EPP (OBA)",
            "E-mail.Contato" => "rh@superoba.com.br
    ",
            "CNPJ" => "28.822.177/0001-92",
            "Tel.Contato" => "(27) 3113-3341
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 435424,
            "Empresa" => "PONTO CERTO LOCACAO, COMERCIO E EVENTOS LTDA - ME ",
            "E-mail.Contato" => "contato@pontocertodistribuidora.com.br
    ",
            "CNPJ" => "08.627.950/0001-52",
            "Tel.Contato" => "(27) 99946-9910
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 526742,
            "Empresa" => "PORTO BRASIL ESTRUTURAS MODULARES EIRELI",
            "E-mail.Contato" => "contabil@ciclomodulos.com.br
    ",
            "CNPJ" => "08.776.167/0001-50",
            "Tel.Contato" => "(27) 3228-0161
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 350310,
            "Empresa" => "POSITIVA CLUB",
            "E-mail.Contato" => "",
            "CNPJ" => "23.178.207/0001-56",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 559990,
            "Empresa" => "POSTO ARCO LTDA",
            "E-mail.Contato" => "seguranca@metaambiental-es.com.br
    ",
            "CNPJ" => "27.725.332/0001-90",
            "Tel.Contato" => "(27) 3049-0249
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 499635,
            "Empresa" => "POSTO RIO MARINHO COMERCIO DE DERIVADOS DE PETROLEO EIRELI",
            "E-mail.Contato" => "postoriomarinhovilavelha@gmail.com
    ",
            "CNPJ" => "18.366.697/0001-84",
            "Tel.Contato" => "(27) 3075-4212
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 244951,
            "Empresa" => "PPDC COMERCIO E TURISMO EIRELI - ME  - BIZ MOTEL",
            "E-mail.Contato" => "vizzoni@ig.com.br
    saleteibiza@hotmail.com
    ",
            "CNPJ" => "04.056.186/0001-51",
            "Tel.Contato" => "(27) 3349-4555
    (27) 3349-4555
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 676920,
            "Empresa" => "PRAIA FITNESS LTDA",
            "E-mail.Contato" => "",
            "CNPJ" => "32.952.588/0001-70",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATO EXAMES"),
        array(
            "Código" => 245367,
            "Empresa" => "PRANA GESTAO",
            "E-mail.Contato" => "credenciamento22@prajnas.com.br
    ",
            "CNPJ" => "17.898.088/0001-03",
            "Tel.Contato" => "(11) 3839-6258
    ",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 490687,
            "Empresa" => "PREDMAN ADM (SOCNET) ",
            "E-mail.Contato" => "",
            "CNPJ" => "",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 489100,
            "Empresa" => "PREDMAN SERVICE ",
            "E-mail.Contato" => "alessandra@predman.com.br
    ",
            "CNPJ" => "17.765.194/0001-19",
            "Tel.Contato" => "(11) 3969-5600
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 487226,
            "Empresa" => "PREMIUM ENGENHARIA E CONSTRUCOES LTDA - ME",
            "E-mail.Contato" => "PREMIUM.ENGENHARIA@OUTLOOK.COM
    ",
            "CNPJ" => "26.717.832/0001-17",
            "Tel.Contato" => "(27) 99644-7984
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 683360,
            "Empresa" => "PRIMICIAS PLANOS - PRESERVE",
            "E-mail.Contato" => "",
            "CNPJ" => "09.595.974/0001-30",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 340580,
            "Empresa" => "PREVENIR - ACTUAL FIRE TECNOLOGIA COMERCIO E SERVICOS",
            "E-mail.Contato" => "financeiro@prevenirincendio.com.br
    leila@prevenirincendio.com.br
    ",
            "CNPJ" => "08.864.584/0001-55",
            "Tel.Contato" => "(27) 3399-8758
    (27) 3399-8758
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 428752,
            "Empresa" => "PRIMEIRA IGREJA BATISTA DE VITORIA ",
            "E-mail.Contato" => "wanderson.matos@pibvitoria.org.br
    ",
            "CNPJ" => "27.033.919/0001-38",
            "Tel.Contato" => "(27) 3434-6600
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 595111,
            "Empresa" => "PROA SERVICOS MARITIMOS EIRELI ",
            "E-mail.Contato" => "augusto.adm@uol.com.br
    ",
            "CNPJ" => "26.516.689/0001-03",
            "Tel.Contato" => "(13) 98123-4831
    ",
            "Sub Grupo" => "CLIENTES AVULSO"),
        array(
            "Código" => 244593,
            "Empresa" => "PROENG CONSTRUTORA E INCORPORADORA LTDA",
            "E-mail.Contato" => "sarahm@grupoproeng.com.br
    ",
            "CNPJ" => "32.483.190/0001-31",
            "Tel.Contato" => ""
    ,
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 591027,
            "Empresa" => "PROFINE INDUSTRIA DE ADITIVOS MINERAIS LTDA ",
            "E-mail.Contato" => "",
            "CNPJ" => "08.888.916/0001-31",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 245767,
            "Empresa" => "PRONTOCLINICA",
            "E-mail.Contato" => "",
            "CNPJ" => "29.533.833/0002-80",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 528105,
            "Empresa" => "PROSPERUS COMERCIO E SERVICOS DE ELETRONICOS LTDA",
            "E-mail.Contato" => "adrianabie@grupoprosperus.com.br
    ",
            "CNPJ" => "17.655.759/0001-05",
            "Tel.Contato" => "(71) 2137-3735
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 589635,
            "Empresa" => "PROVALE DISTRIBUIDORA DE CARBONATOS LTDA ",
            "E-mail.Contato" => "",
            "CNPJ" => "05.593.782/0001-33",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 577360,
            "Empresa" => "PROVALE INDUSTRIA E COMERCIO S A ",
            "E-mail.Contato" => "contasapagar@provale.ind.br
    ",
            "CNPJ" => "27.071.778/0001-48",
            "Tel.Contato" => "(27) 3145-2200
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 244933,
            "Empresa" => "PROVIDER MEDICINA",
            "E-mail.Contato" => "suportesoc@provider-es.com.br
    simone.coelho@provider-es.com.br
    ",
            "CNPJ" => "07.110.470/0001-57",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 235164,
            "Empresa" => "PROVIDER SAUDE CORPORATIVA INTEGRAL LTDA - ME ",
            "E-mail.Contato" => "",
            "CNPJ" => "07.110.470/0001-57",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS EXAMES - AVULSO"),
        array(
            "Código" => 301415,
            "Empresa" => "PTE PRODUTOS SIDERURGICOS LTDA ",
            "E-mail.Contato" => "sheila@pte.com.br
    ",
            "CNPJ" => "10.259.610/0001-68",
            "Tel.Contato" => "(27) 3067-8800
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 320241,
            "Empresa" => "QUALITY SOLUCOES EMPRESARIAIS EIRELI - ME ",
            "E-mail.Contato" => "jaciara.pinheiro@rhopen.com.br
    ",
            "CNPJ" => "10.213.647/0001-55",
            "Tel.Contato" => "(27) 99889-2669
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 306344,
            "Empresa" => "QUALIZAN CONSTRUCOES E SERVICOS LTDA - ME ",
            "E-mail.Contato" => "projecaoconstrucoes@hotmail.com
    tininhameireles@hotmail.com
    ",
            "CNPJ" => "13.986.038/0001-27",
            "Tel.Contato" => "(27) 3225-9003
    (27) 3314-2798
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 659922,
            "Empresa" => "QUALYMED SAUDE OCUPACIONAL LTDA ",
            "E-mail.Contato" => "",
            "CNPJ" => "20.400.334/0001-60",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 245528,
            "Empresa" => "QUINTELA TORRES INCORPORADORA LTDA ",
            "E-mail.Contato" => "tiarlem.dalcol@quintelatorres.com.br
    ",
            "CNPJ" => "30.971.584/0001-03",
            "Tel.Contato" => "(27) 3024-4050
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 589537,
            "Empresa" => "R A TRADING IMPORTADORA & LOGISTICA LTDA   ",
            "E-mail.Contato" => "pestanaimport@veloxmail.com.br
    ",
            "CNPJ" => "02.518.779/0001-67",
            "Tel.Contato" => "(27) 3200-4696
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 244949,
            "Empresa" => "R DALPRA - MEIOS DE HOSPEDAGEM EIRELI - ME (MOTEL IBIZA)",
            "E-mail.Contato" => "vizzoni@ig.com.br
    ",
            "CNPJ" => "00.667.351/0001-50",
            "Tel.Contato" => "(27) 3389-3417
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 531335,
            "Empresa" => "R.I.R. CENTRO AUTOMOTIVO LTDA (ZITEK AUTOMOTIVA)",
            "E-mail.Contato" => "contato@zitek.com.br
    ",
            "CNPJ" => "30.726.191/0001-34",
            "Tel.Contato" => "(27) 99924-4715
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 522183,
            "Empresa" => "ORTHODONTIC ",
            "E-mail.Contato" => "adrianaarabe@gmail.com
    oc240@orthodonticbrasil.com.br
    ",
            "CNPJ" => "29.617.069/0001-40",
            "Tel.Contato" => "(27) 98182-5528
    (27) 3209-0060
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 244700,
            "Empresa" => "RADIOLOGISTAS ASSOCIADOS LTDA - MULTISCAN",
            "E-mail.Contato" => "seguranca@multiscan.med.br
    dp2@multiscan.med.br
    rh@multiscan.med.br
    ",
            "CNPJ" => "32.404.410/0001-94",
            "Tel.Contato" => "(27) 2104-5061
    (27) 2104-5066
    (27) 2104-5012
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 245065,
            "Empresa" => "RCA TV NORTE LTDA ",
            "E-mail.Contato" => "segundaviaboleto@rcatv.com.br
    rosarcarh@gmail.com
     brajovich@gmail.com
    ",
            "CNPJ" => "04.993.151/0001-49",
            "Tel.Contato" => "
    (27) 3205-3324

    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 572705,
            "Empresa" => "REAL ONIBUS LTDA",
            "E-mail.Contato" => "",
            "CNPJ" => "16.580.748/0011-12",
            "Tel.Contato" => "",
            "Sub Grupo" => "CLIENTES AVULSO"),
        array(
            "Código" => 312074,
            "Empresa" => "REALEZA SERVICOS EIRELI - EPP ",
            "E-mail.Contato" => "jfg@jfg.com.br
    ",
            "CNPJ" => "04.095.388/0001-02",
            "Tel.Contato" => "(27) 3072-0673
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 356169,
            "Empresa" => "REALMAR DISTRIBUIDORA LTDA. (EXTRABOM SUPERMERCADOS)",
            "E-mail.Contato" => "lidiane.ferreira@extrabom.com.br
    mariene.alves@extrabom.com.br
    rayanna.rodrigues@extrabom.com.br
    ruth.lima@extrabom.com.br
    ",
            "CNPJ" => "03.845.717/0001-22",
            "Tel.Contato" => "(27) 3298-2783
    (27) 3298-2783
    (27) 3298-2783
    (27) 3298-2783
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 480614,
            "Empresa" => "RED FLAG",
            "E-mail.Contato" => "faturamento@sosredflag.com.br
    financeiro@sosredflag.com.br
    ",
            "CNPJ" => "23.528.023/0001-79",
            "Tel.Contato" => "
    (22)2142-4046
    ",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 496583,
            "Empresa" => "REFAST SERVICOS AUTOMOTIVOS LTDA - EPP",
            "E-mail.Contato" => "elielson@refast.com.br
    ",
            "CNPJ" => "23.903.805/0001-40",
            "Tel.Contato" => "(27) 3024-3300
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 292590,
            "Empresa" => "REFRICAGE SERVICOS",
            "E-mail.Contato" => "contato@refricage.com.br
    ",
            "CNPJ" => "16.953.315/0001-93",
            "Tel.Contato" => "(27) 3324-2314
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 429148,
            "Empresa" => "REFRIGERACAO DUFRIO COMERCIO E IMPORTACAO LTDA ",
            "E-mail.Contato" => "mayara.lacerda@dufrio.com.br
    suelen.pittol@dufrio.com.br
    ",
            "CNPJ" => "01.754.239/0008-96",
            "Tel.Contato" => "(27) 3183-9600
    (27) 3183-9600
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 487579,
            "Empresa" => "REI DAS LAJES COMERCIO ",
            "E-mail.Contato" => "reidaslajes@reidaslajes.com.br
    ",
            "CNPJ" => "04.553.346/0001-78",
            "Tel.Contato" => "(27) 3244-6042
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 397852,
            "Empresa" => "NÃO USAR ESSA EMPRESA",
            "E-mail.Contato" => "",
            "CNPJ" => "16.949.314/0001-75",
            "Tel.Contato" => "",
            "Sub Grupo" => "Sem Contrato"),
        array(
            "Código" => 595439,
            "Empresa" => "AGILIDADE ",
            "E-mail.Contato" => "financeiro2@agilidade.com.br
    compras@agilidade.com.br
    ",
            "CNPJ" => "04.699.076/0001-08",
            "Tel.Contato" => "(41) 3023-0806
    (41) 3023-0806
    ",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 683109,
            "Empresa" => "RENOVASEG CONSULTORIA E TREINAMENTOS ",
            "E-mail.Contato" => "daniel@renovaseg.com.br
    ",
            "CNPJ" => "27.361.774/0001-02",
            "Tel.Contato" => "(11) 4106-549
    ",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 245387,
            "Empresa" => "OSTERIA SPIAGGIA",
            "E-mail.Contato" => "ticinorestaurante@gmail.com
    restauranteosteriaeireli@gmail.com
    ",
            "CNPJ" => "32.102.460/0001-17",
            "Tel.Contato" => "(27) 3019-7370
    (27) 3019-7370
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 245292,
            "Empresa" => "RESTAURANTE TSC EIRELI - EPP ",
            "E-mail.Contato" => "premium.es@terra.com.br
    ",
            "CNPJ" => "23.878.146/0001-30",
            "Tel.Contato" => "(27) 3024-1765
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 375450,
            "Empresa" => "RFC COMERCIO DE ALIMENTOS EIRELI - ME (SUBWAY)",
            "E-mail.Contato" => "rfcvitoria@gmail.com
    ",
            "CNPJ" => "20.044.406/0001-83",
            "Tel.Contato" => "(27) 99966-6100
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 469144,
            "Empresa" => "RHEMA TRANSPORTES LTDA - ME ",
            "E-mail.Contato" => "rhematransportes@gmail.com
    LUIZ@MOVIMENTOCONTABIL.COM.BR",
            "CNPJ" => "08.321.108/0001-98",
            "Tel.Contato" => "(27) 3086-4179",
            "Sub Grupo" => "CONTRATOS ASSESSORIA",
            "undefined" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 592166,
            "Empresa" => "RHI SERVICOS LTDA (UNIL SOLUCOES INTEGRADAS)",
            "E-mail.Contato" => "agendamento@unil.com.br
    sac@unil.com.br
    administrativo@unil.com.br
    ",
            "CNPJ" => "03.448.456/0002-98",
            "Tel.Contato" => "(41) 3779-3040
    (41) 3434-3040
    (41) 3015-1818
    ",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 415145,
            "Empresa" => "RHMED CONSULTORES (SOCNET) ",
            "E-mail.Contato" => "",
            "CNPJ" => "",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 256381,
            "Empresa" => "RHMED CONSULTORES ASSOCIADOS LTDA",
            "E-mail.Contato" => "cbrasil@rhmed.com.br
    fleite@rhmed.com.br
    talves@rhmed.com.br
    ",
            "CNPJ" => "01.430.943/0001-17",
            "Tel.Contato" => "(21) 2158-8059
    (21) 2158-8059
    (21) 2158-8059
    ",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 320879,
            "Empresa" => "RHOPEN CONSULTORIA",
            "E-mail.Contato" => " adm@rhopen.com.br
    ",
            "CNPJ" => "06.187.057/0001-28",
            "Tel.Contato" => "(27) 3024-1600
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 533375,
            "Empresa" => "ECONOMIA SUPERMERCADOS (0001-06)",
            "E-mail.Contato" => "financeirocmc@bol.com.br
    financeirorioverdematriz@bol.com.br
    financeirorvfilial@bol.com.br
    ",
            "CNPJ" => "04.697.921/0001-06",
            "Tel.Contato" => "(27) 3319-6785
    (27) 3226-2108
    (27) 3388-4499
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 244816,
            "Empresa" => "RMC IMPERMEABILIZACOES E SERVICOS EIRELI - EPP (IMPERMIL)",
            "E-mail.Contato" => "valdineia@impermil.com.br
    ",
            "CNPJ" => "17.401.047/0001-60",
            "Tel.Contato" => "(27) 3033-9613
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 566682,
            "Empresa" => "ROBERTA IUNG FREITAS ROCHA ",
            "E-mail.Contato" => "iungalimentacao@gmail.com
    marceloyung1@hotmail.com
    ",
            "CNPJ" => "23.142.855/0001-52",
            "Tel.Contato" => "(27) 99512-4132
    (31) 99683-0975
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 245176,
            "Empresa" => "RODA BRASIL LTDA",
            "E-mail.Contato" => "",
            "CNPJ" => "03.475.418/0001-43",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 245392,
            "Empresa" => "RODONIL TRANSPORTES E LOGISTICA EIRELI",
            "E-mail.Contato" => "rh@rodonil.com.br
    ",
            "CNPJ" => "12.824.620/0001-24",
            "Tel.Contato" => "(27) 3236-6784
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 641318,
            "Empresa" => "R.S. CLIMATIZACAO",
            "E-mail.Contato" => "",
            "CNPJ" => "19.438.871/0001-10",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 321757,
            "Empresa" => "ROTA1 IMPLEMENTOS RODOVIARIOS LTDA - ME",
            "E-mail.Contato" => "vanusa@rotasol.com.br
    ",
            "CNPJ" => "13.471.773/0001-06",
            "Tel.Contato" => "(27) 3246-5900
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 245001,
            "Empresa" => "ROTASOL IMPLEMENTOS RODOVIARIOS LTDA - EPP ",
            "E-mail.Contato" => "carla@rotasol.com.br
    recepcao@rotasol.com.br
    ",
            "CNPJ" => "03.441.355/0001-04",
            "Tel.Contato" => "(27) 3246-5900

    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 301246,
            "Empresa" => "RSF COMERCIO DE MOTOCICLETAS E SERVICOS (LAGUNA MOTOS)",
            "E-mail.Contato" => "ana.neves@hiromotors.com.br
    rh@lagunamotos.com.br
    ",
            "CNPJ" => "12.394.834/0001-08",
            "Tel.Contato" => "(27) 3334-3836
    (27) 3048-0000
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 331934,
            "Empresa" => "RUDISON THEODORO BARCELOS - ME (RUDINHO MARCENARIA)",
            "E-mail.Contato" => "rudinho.vendas@gmail.com
    ",
            "CNPJ" => "09.144.673/0001-90",
            "Tel.Contato" => "(27) 3369-1661
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 433673,
            "Empresa" => "SAESA DO BRASIL LTDA (OFFICETECH SOLUCOES TECNOLOGICAS )",
            "E-mail.Contato" => "financeiro@officetek.com.br
    geise.langa@officetek.com.br
    ",
            "CNPJ" => "07.366.769/0001-77",
            "Tel.Contato" => "(27) 3335-0000
    (27) 3335-0000
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 626608,
            "Empresa" => "SAFETY ASSESSORIA E (SOCNET) ",
            "E-mail.Contato" => "",
            "CNPJ" => "",
            "Tel.Contato" => "",
            "Sub Grupo" => "Sem Contrato"),
        array(
            "Código" => 399641,
            "Empresa" => "SALAMANDRA TRANSPORTES E LOGISTICA EIRELI ME",
            "E-mail.Contato" => "financeiro@zarbdistribuidora.com.br
    financeiro02@zarbdistribuidora.com.br
    rh.zarb@zarbdistribuidora.com.br
    financeiro02@zarbdistribuidora.com.br
    ",
            "CNPJ" => "12.213.664/0001-18",
            "Tel.Contato" => "(27) 3226-6633
    (27) 3226-6633
    (27) 3226-6633
    (27) 3226-6633
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 531748,
            "Empresa" => "SALGADOS SURAIA LTDA",
            "E-mail.Contato" => "contato@salgadossuraia.com.br
    rosesalgadossuraia@gmail.com
    ",
            "CNPJ" => "10.374.490/0001-40",
            "Tel.Contato" => "
    (27) 3222-1547
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 263953,
            "Empresa" => "SAMEDIL - SERVICOS DE ATENDIMENTO MEDICO S/A - MEDSENIOR",
            "E-mail.Contato" => "dp@medsenior.com.br
    rh@medsenior.com.br
    dp@medsenior.com.br
    ",
            "CNPJ" => "31.466.949/0001-05",
            "Tel.Contato" => "(27) 3025-5556
    (27) 3025-5543
    (27) 3025-5556
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 502163,
            "Empresa" => "SANTA TERESA SAUDE EIRELI ",
            "E-mail.Contato" => "",
            "CNPJ" => "19.951.335/0001-13",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 633396,
            "Empresa" => "SD - CONSTRUTORA E INCORPORADORA LTDA",
            "E-mail.Contato" => "",
            "CNPJ" => "10.696.493/0001-08",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 408998,
            "Empresa" => "RENOVA ADM E TERCEIRIZACAO DE MAO DE OBRA",
            "E-mail.Contato" => "nelson.renova@uol.com.br
    ",
            "CNPJ" => "16.949.314/0001-75",
            "Tel.Contato" => "(27) 3237-2290
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 281390,
            "Empresa" => "SECURITY",
            "E-mail.Contato" => "",
            "CNPJ" => "00.332.087/0006-09",
            "Tel.Contato" => "",
            "Sub Grupo" => "CLIENTES AVULSO"),
        array(
            "Código" => 429469,
            "Empresa" => "SINEPE - SEDES SOCIED. EDUC. DO ES LTDA - EPP ",
            "E-mail.Contato" => "rsantosneves@crescerphd.com.br
    rhphd@crescerphd.com.br
    ",
            "CNPJ" => "27.268.382/0001-95",
            "Tel.Contato" => "(27) 98127-0990
    (27) 3038-0199
    ",
            "Sub Grupo" => "CONTRATOS EXAMES - AVULSO"),
        array(
            "Código" => 260277,
            "Empresa" => "UNIL SOLUCOES INTEGRADAS",
            "E-mail.Contato" => "",
            "CNPJ" => "11.105.166/0001-99",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 384641,
            "Empresa" => "SEI VIGILANCIA E SEGURANCA LTDA ",
            "E-mail.Contato" => "sesmt@seiinteligencia.com.br
    ",
            "CNPJ" => "10.392.232/0001-96",
            "Tel.Contato" => "(27) 3328-7228
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 354234,
            "Empresa" => "SER SAUDE OCUPACIONAL LTDA",
            "E-mail.Contato" => "",
            "CNPJ" => "17.266.033/0001-80",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 631998,
            "Empresa" => "SERRABETUME ENGENHARIA LTDA ",
            "E-mail.Contato" => "notafiscal@serrabetume.com.br
    jacqueline@serrabetume.com.br
    ",
            "CNPJ" => "39.365.176/0001-82",
            "Tel.Contato" => "(27) 3218-5523
    (27) 99612-9980
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 245710,
            "Empresa" => "SERRANO DISTRIBUIDORA S/A - OK SUPERATACADO",
            "E-mail.Contato" => "coordenacaodp@oksuperatacado.com.br
    izabel@oksuperatacado.com.br
    jamily@oksuperatacado.com.br
    sesmt2@oksuperatacado.com.br
    ",
            "CNPJ" => "09.397.586/0001-44",
            "Tel.Contato" => "(27) 3022-4609
    (27) 99836-0334
    (27) 3298-8100
    (27) 3022-4626
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 557392,
            "Empresa" => "SERVICO SOCIAL DA IND DA CONSTR CIVIL NO ESTADO DO ES",
            "E-mail.Contato" => "seguranca@seconci-es.com.br
    ",
            "CNPJ" => "01.290.954/0001-49",
            "Tel.Contato" => "(27) 3323-5551
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 526320,
            "Empresa" => "SETE BRASILIS (GRANDLIMP)",
            "E-mail.Contato" => "financeiro@grandlimp.com
    ",
            "CNPJ" => "29.282.974/0001-97",
            "Tel.Contato" => "(27) 3062-3891
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 423154,
            "Empresa" => "SETRAB - ASSESSORIA EM SEGURANCA E MEDICINA DO TRABALHO",
            "E-mail.Contato" => "leticia@setrab.com.br
    ",
            "CNPJ" => "03.979.726/0001-06",
            "Tel.Contato" => "(11) 4121-5979
    ",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 429477,
            "Empresa" => "SINEPE - SEVI SOCIEDADE EDUCACIONAL DE VITORIA LTDA - EPP ",
            "E-mail.Contato" => "rsantosneves@crescerphd.com.br
    rhphd@crescerphd.com.br
    ",
            "CNPJ" => "00.926.459/0001-10",
            "Tel.Contato" => "(27) 98127-0990
    (27) 3038-0199
    ",
            "Sub Grupo" => "CONTRATOS EXAMES - AVULSO"),
        array(
            "Código" => 307024,
            "Empresa" => "SILVANA REGINA DE OLIEIRA DORTA CARLINE - EPP (CARLIMP)",
            "E-mail.Contato" => "fernanda@carlimp.com.br
    ",
            "CNPJ" => "10.340.988/0001-91",
            "Tel.Contato" => "(19) 3533-7282
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 537398,
            "Empresa" => "SIMONE KARLA APOLONIO DUARTE (MA ATELIER)",
            "E-mail.Contato" => "adm@salaoma.com.br
    ",
            "CNPJ" => "23.860.496/0001-79",
            "Tel.Contato" => "(27) 3325-4321
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 345744,
            "Empresa" => "SINTTEL/ES",
            "E-mail.Contato" => "",
            "CNPJ" => "28.166.668/0001-22",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 386205,
            "Empresa" => "SINDICATO DAS EMPRESAS PARTICULARES DE ENSINO DO ESTADO D",
            "E-mail.Contato" => "",
            "CNPJ" => "27.061.282/0001-93",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 498900,
            "Empresa" => "SINGULAR SERVICOS CONTABEIS ESPECIALIZADOS LTDA",
            "E-mail.Contato" => "administrativo@singularcontabil.com.br
    ",
            "CNPJ" => "06.191.939/0001-67",
            "Tel.Contato" => "(27) 3224-5558
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 572333,
            "Empresa" => "SISBAT - CONSTRUCOES LTDA ",
            "E-mail.Contato" => "",
            "CNPJ" => "05.835.503/0001-09",
            "Tel.Contato" => "",
            "Sub Grupo" => "CLIENTES AVULSO"),
        array(
            "Código" => 468120,
            "Empresa" => "SME SERVICOS MEDICOS EDUCACIONAIS ESPECIALIZADOS LTDA ",
            "E-mail.Contato" => "wallysson@smeconsultoria.com.br
    ",
            "CNPJ" => "05.384.273/0001-09",
            "Tel.Contato" => "(27) 3025-3215
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 354817,
            "Empresa" => "SO3 ASSESSORIA (SOCNET) ",
            "E-mail.Contato" => "",
            "CNPJ" => "",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 414164,
            "Empresa" => "SOARES ROCHA RESTAURANTE EIRELI ME",
            "E-mail.Contato" => "premium.es@terra.com.br
    ",
            "CNPJ" => "26.717.896/0001-18",
            "Tel.Contato" => "(27) 3024-1765
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 623336,
            "Empresa" => "COLEGIO SAGRADO CORACAO DE MARIA ",
            "E-mail.Contato" => "rh@redesagradovitoria.com.br
    ",
            "CNPJ" => "33.618.984/0004-70",
            "Tel.Contato" => "(27) 2124-9100
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 390752,
            "Empresa" => "SINEPE - COLEGIO APICE",
            "E-mail.Contato" => "annapj@colegioapice.com
    ",
            "CNPJ" => "39.635.362/0001-94",
            "Tel.Contato" => "(27) 3252-3193
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 245619,
            "Empresa" => "SOCIEDADE EDUCACIONAL CAPIXABA - COLEGIO PIO XII",
            "E-mail.Contato" => "rh@faculdade.pioxii-es.com.br
    ",
            "CNPJ" => "28.414.555/0001-07",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 390755,
            "Empresa" => "SINEPE - SOCIEDADE EDUCACIONAL VERTICE LTDA - ME     ",
            "E-mail.Contato" => "annapj@colegioapice.com
    ",
            "CNPJ" => "06.372.085/0001-15",
            "Tel.Contato" => "(27) 3252-3193
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 654000,
            "Empresa" => "SOL - LOCACAO DE MAQUINAS E EQUIPAMENTOS LTDA - PORT SIDE ",
            "E-mail.Contato" => "dp@portside.com.br
    ",
            "CNPJ" => "30.775.399/0001-43",
            "Tel.Contato" => "(27) 3354-9969
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 573350,
            "Empresa" => "SOLUTRANS LOGISTICA E TRANSPORTES LTDA",
            "E-mail.Contato" => "barcelona@gruporedeshow.com
    ",
            "CNPJ" => "11.020.218/0001-24",
            "Tel.Contato" => "(27) 3341-1731
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 568791,
            "Empresa" => "SORVEDOCES INDUSTRIA E COMERCIO DE PRODUTOS ALIMENTICIOS L",
            "E-mail.Contato" => "0001.financeiro@sorvedoce.com.br
    ",
            "CNPJ" => "03.752.344/0001-45",
            "Tel.Contato" => "(27) 3311-1114
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 571802,
            "Empresa" => "SS SERVICOS DE MANUTENCAO E COMERCIO LTDA",
            "E-mail.Contato" => "negocios@safetysolution.com.br
    ",
            "CNPJ" => "31.714.209/0001-40",
            "Tel.Contato" => "(27) 8845-0708
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 467458,
            "Empresa" => "STACA FUNDACOES E OBRAS LTDA ",
            "E-mail.Contato" => "mauricio@staca.com.br
    ",
            "CNPJ" => "28.136.273/0001-87",
            "Tel.Contato" => "(27) 3324-0718
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 420921,
            "Empresa" => "STAFF CONSTRUCOES",
            "E-mail.Contato" => "financeiro@staffconstrucoes.com
    ",
            "CNPJ" => "73.613.655/0001-09",
            "Tel.Contato" => "(71) 3378-4714
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 528502,
            "Empresa" => "STAR HOUSE MATERIAL DE CONSTRUCAO LTDA ",
            "E-mail.Contato" => "starhousemc@gmail.com
    ",
            "CNPJ" => "06.921.455/0001-26",
            "Tel.Contato" => "(27) 3323-5311
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 245095,
            "Empresa" => "STILE COMERCIAL - MATRIZ",
            "E-mail.Contato" => "rh@stilecomercial.com.br
    ",
            "CNPJ" => "05.758.306/0001-25",
            "Tel.Contato" => "(27) 2121-5600
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 551774,
            "Empresa" => "SUPERMERCADO CARON LTDA (REDE SHOW)",
            "E-mail.Contato" => "novacarapina@gruporedeshow.com
    novacarapina@gruporedeshow.com
    teodoro@gruporedeshow.com
    ",
            "CNPJ" => "05.432.882/0001-88",
            "Tel.Contato" => "(27) 99942-5876
    (27) 3341-0142
    (27) 3341-0142
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 574611,
            "Empresa" => "SUPERMERCADO GARBOS LTDA ",
            "E-mail.Contato" => "lorranyrh@multishow.org
    ",
            "CNPJ" => "04.630.798/0001-06",
            "Tel.Contato" => "(27) 3249-2700
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 376906,
            "Empresa" => "SUPERMERCADO NSF LTDA ",
            "E-mail.Contato" => "dpnsf@yahoo.com.br
    ",
            "CNPJ" => "09.419.971/0001-45",
            "Tel.Contato" => "(27) 3252-1576
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 561724,
            "Empresa" => "SUPERMERCADO R.D.E. LTDA (REDE SHOW)",
            "E-mail.Contato" => "RDE@GRUPOREDESHOW.COM
    ",
            "CNPJ" => "06.196.895/0001-68",
            "Tel.Contato" => "(27) 3241-0291
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 408097,
            "Empresa" => "SUPERMERCADO VENETTO EIRELI  - CENTRAL DE COMPRAS",
            "E-mail.Contato" => "dp@supervenetto.com.br
    fiscal@supervenetto.com.br
    financeiro@supervenetto.com.br
    ",
            "CNPJ" => "24.616.223/0001-46",
            "Tel.Contato" => "(27) 3346-7550


    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 289232,
            "Empresa" => "SUPERMERCADOS CALVI LTDA ",
            "E-mail.Contato" => "contato@calvi.com.br
    financeiro@calvi.com.br
    pessoal@calvi.com.br
    ",
            "CNPJ" => "27.990.092/0001-50",
            "Tel.Contato" => "(27) 3038-4949
    (27) 3038-4949
    (27) 3038-4949
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 289197,
            "Empresa" => "SUPERMERCADOS FIORESE LTDA - RAMOS",
            "E-mail.Contato" => "supermercadosramos.rh03@gmail.com
    ramosfiorese@hotmail.com
    silvgabi@supermercadosramos.com.br
    ",
            "CNPJ" => "31.790.702/0002-20",
            "Tel.Contato" => "(27) 3391-0797
    (27) 3226-0606
    (27) 3226-0606
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 331467,
            "Empresa" => "SUPERMERCADOS NOROESTE LTDA",
            "E-mail.Contato" => "supnoroeste@terra.com.br
    ",
            "CNPJ" => "31.778.103/0001-00",
            "Tel.Contato" => "(27) 3253-1355
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 439480,
            "Empresa" => "SUPREMO SUPRIMENTOS LTDA - EPP (SUPERMERCADO OBA)",
            "E-mail.Contato" => "rh@superoba.com.br
    ",
            "CNPJ" => "25.096.821/0001-02",
            "Tel.Contato" => "(27) 3722-3304
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 268181,
            "Empresa" => "SUSHIVIX RESTAURANTES LTDA ",
            "E-mail.Contato" => "globaltradebr@gmail.com
    ",
            "CNPJ" => "19.239.297/0001-70",
            "Tel.Contato" => "(27) 3327-5611
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 392525,
            "Empresa" => "SVA SEGURANCA E VIGILANCIA ARMADA EIRELI",
            "E-mail.Contato" => "pessoal02@gruposva.com.br
    financeiro@gruposva.com.br
    ",
            "CNPJ" => "08.944.765/0001-91",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 379596,
            "Empresa" => "SVC SERVICOS DE PINTURA LTDA - EPP ",
            "E-mail.Contato" => "svcpinturas@hotmail.com
    ",
            "CNPJ" => "15.751.700/0001-95",
            "Tel.Contato" => "(27) 99944-3051
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 390359,
            "Empresa" => "SYSTHEX - SISTEMAS DE IMPLANTES OSSEO INTEGRADO LTDA",
            "E-mail.Contato" => "rh@systhex.com.br
    ",
            "CNPJ" => "05.644.129/0005-80",
            "Tel.Contato" => "(41) 3091-6565
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 600803,
            "Empresa" => "TARGET SOLUCOES INTELIGENTES LTDA",
            "E-mail.Contato" => "administrativo@targetsolucoesinteligente.com.br
    ",
            "CNPJ" => "22.840.676/0001-26",
            "Tel.Contato" => "(27) 3020-3998
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 353131,
            "Empresa" => "TBS - CLINICA INTEGRADA",
            "E-mail.Contato" => "",
            "CNPJ" => "07.299.243/0001-11",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 501379,
            "Empresa" => "TDA DOCUMENTOS ",
            "E-mail.Contato" => "",
            "CNPJ" => "10.556.313/0001-84",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 245128,
            "Empresa" => "TECPRINT COMUNICACAO VISUAL LTDA - EPP ",
            "E-mail.Contato" => "assisamarildo@terra.com.br
    ",
            "CNPJ" => "10.219.055/0001-40",
            "Tel.Contato" => "(27) 3223-3315
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 539638,
            "Empresa" => "TEGMA LOGISTICA INTEGRADA S.A. ",
            "E-mail.Contato" => "",
            "CNPJ" => "03.649.560/0001-60",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 311516,
            "Empresa" => "TELELAUDO TECNOLOGIA",
            "E-mail.Contato" => "coordadm@telelaudo.com.br
    ",
            "CNPJ" => "11.217.530/0001-02",
            "Tel.Contato" => "(27) 4003-3125
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 626318,
            "Empresa" => "TELSAN ENGENHARIA E SERVICOS",
            "E-mail.Contato" => "sara.marques@telsan.com.br
    thiago.basilio@telsan.com.br
    ",
            "CNPJ" => "00.740.230/0001-97",
            "Tel.Contato" => "(22) 2142-3983
    (22) 2142-3983
    ",
            "Sub Grupo" => "CONTRATOS EXAMES - AVULSO"),
        array(
            "Código" => 561153,
            "Empresa" => "TERRA NOVA TRADING LTDA   ",
            "E-mail.Contato" => "cdsantos@tnova.com.br
    ",
            "CNPJ" => "39.828.926/0001-05",
            "Tel.Contato" => "(27) 3324-1656
    ",
            "Sub Grupo" => "CLIENTES AVULSO"),
        array(
            "Código" => 271777,
            "Empresa" => "THERMOPOR INDUSTRIA E COMERCIO DE ARTEFATOS DE POLIESTIREN",
            "E-mail.Contato" => "administrativo@thermopor.ind.br
    dptpessoal@thermopor.ind.br
    ",
            "CNPJ" => "09.060.193/0001-40",
            "Tel.Contato" => "(27) 3255-7049
    (27) 3255-7049
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 446517,
            "Empresa" => "THOMES TERRAPLANAGEM E SERVICOS LTDA - ME ",
            "E-mail.Contato" => "financeiro.thomes@gmail.com
    thomes.hcn@gmail.com
    ",
            "CNPJ" => "14.892.363/0001-93",
            "Tel.Contato" => "(27) 3090-3770
    (27) 3090-3770
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 553685,
            "Empresa" => "THS OCUPACIONAL LTDA ",
            "E-mail.Contato" => "",
            "CNPJ" => "19.546.549/0001-04",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 327684,
            "Empresa" => "TIA VALERIA BUFFET COMERCIAL LTDA - EPP ",
            "E-mail.Contato" => "pessoal@tiavaleria.com.br
    ",
            "CNPJ" => "05.886.728/0001-86",
            "Tel.Contato" => "(27) 3323-5757
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 244937,
            "Empresa" => "TIPITI MOTEL EIRELI EPP",
            "E-mail.Contato" => "vizzoni@ig.com.br
    tipitimotel@hotmail.com
    ",
            "CNPJ" => "28.529.287/0001-60",
            "Tel.Contato" => "(27) 3389-3417

    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 527959,
            "Empresa" => "TM INFORMATICA LTDA",
            "E-mail.Contato" => "magali@outview.com.br
    ",
            "CNPJ" => "09.317.218/0001-49",
            "Tel.Contato" => "(27) 2233-8182
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 674954,
            "Empresa" => "TMT CONSTRUTORA LTDA (TAVOLARO CONSTRUTORA)",
            "E-mail.Contato" => "adm@tavolaroconstrutora.com.br
    ",
            "CNPJ" => "13.415.341/0001-70",
            "Tel.Contato" => "(27) 3080-4990
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 445904,
            "Empresa" => "TOTAL LIFE ASSISTENCIA A (SOCNET) ",
            "E-mail.Contato" => "",
            "CNPJ" => "09.079.572/0001-82",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 360767,
            "Empresa" => "TOTAL LIFE ASSISTENCIA A VIDA LTDA",
            "E-mail.Contato" => "faturamento2@totallifebrasil.com.br
    ",
            "CNPJ" => "09.079.572/0001-82",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 602519,
            "Empresa" => "TRABALHE MEDICINA E SEGURANCA DO TRABALHO (CLINICA MEDSEL)",
            "E-mail.Contato" => "",
            "CNPJ" => "22.108.445/0001-22",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 603731,
            "Empresa" => "TRAME ",
            "E-mail.Contato" => "CREDENCIAMENTO@TRAMEAP.COM.BR
    ",
            "CNPJ" => "02.963.899/0001-73",
            "Tel.Contato" => "(11) 5087-4870
    ",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 347861,
            "Empresa" => "TRANSCHERRER TRANSPORTADORA LTDA ME",
            "E-mail.Contato" => "aliete@transcherrer.com.br
    keila.escarpini@transcherrer.com.br
    rh@transcherrer.com.br
    comercial@transcherrer.com.br
    ",
            "CNPJ" => "06.933.939/0001-95",
            "Tel.Contato" => "

    (27) 3284-3306
    (27) 3284-3306
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 540170,
            "Empresa" => "TRANSFRITZ TRANSPORTES E TERMINAL LOGISTICO LTDA - TFT ",
            "E-mail.Contato" => "logistica1@transfritz.com.br
    erica@transfritz.com.br
    lorena@transfritz.com.br
    ",
            "CNPJ" => "17.159.624/0001-59",
            "Tel.Contato" => "(27) 3239-8234
    (27) 3239-8234

    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 366435,
            "Empresa" => "TRANSILVA TRANSPORTES E LOGISTICA LTDA",
            "E-mail.Contato" => "andre.gomes@transilva.com.br
    priscila.dias@transilva.com.br
    ",
            "CNPJ" => "30.581.433/0001-49",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 426936,
            "Empresa" => "TRANSMARLE TRANSPORTES LTDA",
            "E-mail.Contato" => "transmarletransportes@gmail.com
    ",
            "CNPJ" => "04.108.909/0001-19",
            "Tel.Contato" => "(27) 3366-3570
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 478765,
            "Empresa" => "TRANSMARLEN TRANSPORTES",
            "E-mail.Contato" => "liliantransmarle@gmail.com
    transmarlentransportes@gmail.com
    ",
            "CNPJ" => "16.894.814/0001-57",
            "Tel.Contato" => "
    (27) 3366-3570
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 538385,
            "Empresa" => "TRANSPARENCY LOGISTICA E TRANSPORTES LTDA",
            "E-mail.Contato" => "marcella.comunian@tquality.com.br
    ",
            "CNPJ" => "09.621.639/0005-92",
            "Tel.Contato" => "(13) 3690-3400
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 422644,
            "Empresa" => "TRANSPEDRA TRANSPORTES LTDA ",
            "E-mail.Contato" => "seguranca.trabalho@brasitalia.com.br
    ",
            "CNPJ" => "10.592.652/0001-16",
            "Tel.Contato" => "(27) 3246-0400
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 603121,
            "Empresa" => "TRANSGILLES",
            "E-mail.Contato" => "dpto.pessoal@gilleslogistica.com.br
    aux.contabil@gilleslogistica.com.br
    ",
            "CNPJ" => "07.101.547/0001-22",
            "Tel.Contato" => "(27) 3254-6521

    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 490583,
            "Empresa" => "TRANSPORTES TONIATO LTDA",
            "E-mail.Contato" => "henrique.bastos@grupotoniato.com.br
    sueli.silva@grupotoniato.com.br
    ",
            "CNPJ" => "29.291.184/0033-55",
            "Tel.Contato" => "(12) 3132-7461

    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 394634,
            "Empresa" => "TRESELES TRANSPORTES DE CARGAS LTDA. ",
            "E-mail.Contato" => "suiani.passos@viacaopretti.com.br
    ",
            "CNPJ" => "11.157.927/0001-56",
            "Tel.Contato" => "(27) 2101-5757
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 568924,
            "Empresa" => "TRILHA VITORIA COMERCIO E REPRESENTACAO DE VEICULOS LTDA ",
            "E-mail.Contato" => "",
            "CNPJ" => "29.347.761/0001-04",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 676925,
            "Empresa" => "TRINDADE SERVIÇOS OPERACIONAIS LTDA (SMART FIT ACADEMIAS)",
            "E-mail.Contato" => "",
            "CNPJ" => "13.305.908/0001-55",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 410165,
            "Empresa" => "TROPICAL CLEANING LTDA - ME (REDE PIT STOP TROPICAL)",
            "E-mail.Contato" => "simone@cetfaesa.com.br
    ",
            "CNPJ" => "26.169.668/0001-50",
            "Tel.Contato" => "(27) 3022-1001
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 473146,
            "Empresa" => "TUBONEWS CONSTRUCAO E MONTAGEM LTDA ",
            "E-mail.Contato" => "compras@tubomills.com.br
    ",
            "CNPJ" => "00.611.119/0001-09",
            "Tel.Contato" => "(27) 3332-5020
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 577894,
            "Empresa" => "TYLER RESTAURANTES LTDA ",
            "E-mail.Contato" => "tylerloja01@gmail.com
    ",
            "CNPJ" => "15.441.556/0001-90",
            "Tel.Contato" => "(27) 99652-9888
    ",
            "Sub Grupo" => "CONTRATOS EXAMES - AVULSO"),
        array(
            "Código" => 378400,
            "Empresa" => "ULTRA COM CONSTRUTORA LTDA ME - ME ",
            "E-mail.Contato" => "ultracom72@gmail.com
    ",
            "CNPJ" => "06.336.342/0001-63",
            "Tel.Contato" => "(27) 3323-5699
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 440752,
            "Empresa" => "UNIAO LOCACAO DE MAQUINAS LTDA - ME ",
            "E-mail.Contato" => "uniaolm@yahoo.com.br
    ",
            "CNPJ" => "08.609.111/0001-01",
            "Tel.Contato" => "(27) 3289-3730
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 393441,
            "Empresa" => "UNIAO PARTICIPACOES S/A",
            "E-mail.Contato" => "edilene@autovixsa.com.br
    ",
            "CNPJ" => "26.865.201/0001-45",
            "Tel.Contato" => "(27) 3089-8365
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 260845,
            "Empresa" => "ARGO PARTICIPACOES ",
            "E-mail.Contato" => "rh@argoconstrutora.com.br
    seguranca1@argoconstrutora.com.br
    rh@argoconstrutora.com.br
    ",
            "CNPJ" => "07.341.744/0001-19",
            "Tel.Contato" => "(27) 3061-0707
    (27) 99716-9545
    (27) 3061-0707
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 572250,
            "Empresa" => "UNICAFE - TESTE INTEGRAÇÃO",
            "E-mail.Contato" => "",
            "CNPJ" => "28.154.680/0015-12",
            "Tel.Contato" => "",
            "Sub Grupo" => "Sem Contrato"),
        array(
            "Código" => 425459,
            "Empresa" => "UNICAFE AGRICOLA S.A. ",
            "E-mail.Contato" => "alexandre.tadeu@unicafe.com.br
    joise.cezar@unicafe.com.br
    leonardo.jacomelli@unicafe.com.br
    FAZENDA.GALILEIA@UNICAFE.COM.BR
    ",
            "CNPJ" => "27.999.531/0001-96",
            "Tel.Contato" => "(27) 2104-5960
    (27) 2123-5849

    (27) 3032-5078
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 244864,
            "Empresa" => "UNICAFE COMPANHIA DE COMERCIO EXTERIOR ",
            "E-mail.Contato" => "alexandre.tadeu@unicafe.com.br
    maria.aparecida@unicafe.com.br
    ",
            "CNPJ" => "28.154.680/0015-12",
            "Tel.Contato" => "(27) 2104-5960
    (27) 2104-5959
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 244796,
            "Empresa" => "UNICOB - SERVICOS DE DIGITALIZACAO EIRELI - EPP ",
            "E-mail.Contato" => "rh@unicob.com.br
    financeiro@inactu.net.br
    fabiano@unicob.com.br
    rh@unicob.com.br
    ",
            "CNPJ" => "08.268.907/0001-48",
            "Tel.Contato" => "(27) 3211-1864
    (27) 3211-1864
    (27) 3211-1864
    (27) 3211-1864
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 423790,
            "Empresa" => "UNIDOS CONSTRUTORA EIRELI - EPP ",
            "E-mail.Contato" => "jfg@jfg.com.br
    ",
            "CNPJ" => "12.455.409/0001-81",
            "Tel.Contato" => "(27) 3072-0673
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 244684,
            "Empresa" => "UNIFEST",
            "E-mail.Contato" => "jbarros@palaciodasfestas-es.com.br
    ",
            "CNPJ" => "16.797.234/0001-41",
            "Tel.Contato" => "(27) 3024-2220
    ",
            "Sub Grupo" => "CLIENTES AVULSO"),
        array(
            "Código" => 632298,
            "Empresa" => "Unil Soluções (SOCNET) ",
            "E-mail.Contato" => "",
            "CNPJ" => "",
            "Tel.Contato" => "",
            "Sub Grupo" => "Sem Contrato"),
        array(
            "Código" => 416615,
            "Empresa" => "UNIMARKA DISTRIBUIDORA S/A ",
            "E-mail.Contato" => "dp01@unimarka.com.br
    dp03@unimarka.com.br
    dp04@unimarka.com.br
    talmeida@unimarka.com.br
    vitor.compras@unimarka.com.br
    ",
            "CNPJ" => "05.997.742/0015-52",
            "Tel.Contato" => "(27) 2101-3569
    (27) 2101-3500
    (27) 2101-3500
    (27) 2101-3555
    (27) 2101-3500
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 540558,
            "Empresa" => "UNIQUE STONE EIRELI ",
            "E-mail.Contato" => "assistente@uniquestone.com.br
    ",
            "CNPJ" => "11.475.644/0001-52",
            "Tel.Contato" => "(27) 3328-1523
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 378685,
            "Empresa" => "URESERRA GERENCIAMENTO DE RESIDUOS LTDA - EPP ",
            "E-mail.Contato" => "jcarlos@ureserra.ind.br
    ",
            "CNPJ" => "17.198.825/0001-65",
            "Tel.Contato" => "(27) 2233-8218
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 574560,
            "Empresa" => "VNS CONSTRUTORA",
            "E-mail.Contato" => "frederico.hse@gmail.com
    ",
            "CNPJ" => "26.553.386/0001-52",
            "Tel.Contato" => "(27) 99875-5230
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 245383,
            "Empresa" => "VALDIVIA INDUSTRIA E COMERCIO EIRELI - EPP LE CHOCOLATIER",
            "E-mail.Contato" => "administrativo@lechocolatier.com.br
    financeiro2@lechocolatier.com.br
    producao@lechocolatier.com.br
    ",
            "CNPJ" => "36.021.202/0001-67",
            "Tel.Contato" => "(27) 3325-3255
    (27) 3325-3255
    (27) 3325-3255
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 643024,
            "Empresa" => "VITORIA CAR WASH ",
            "E-mail.Contato" => "qualityassessoriacontabil@gmail.com
    vitoriacarwash@hotmail.com
    ",
            "CNPJ" => "22.434.416/0001-50",
            "Tel.Contato" => "(27) 99774-2181
    (27) 99961-2070
    ",
            "Sub Grupo" => "CLIENTES AVULSO"),
        array(
            "Código" => 245604,
            "Empresa" => "VD COMERCIO DE VEICULOS LTDA ",
            "E-mail.Contato" => "Jackelinec@aguiabranca.com.br
    maisanunes@aguiabranca.com.br
    tatianer@aguiabranca.com.br
    ",
            "CNPJ" => "39.786.983/0011-40",
            "Tel.Contato" => "
    (27) 2125-4911
    (27) 2125-4911
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 323782,
            "Empresa" => "VELTEN LOGISTICA E TRANSPORTE LTDA - EPP ",
            "E-mail.Contato" => "dianna.santana-es@veltenlog.com.br
    ",
            "CNPJ" => "05.593.147/0001-56",
            "Tel.Contato" => "(27) 3064-7464
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 299774,
            "Empresa" => "VENAC VEICULOS NACIONAIS LIMITADA ",
            "E-mail.Contato" => "jose.valmir@venac.com.br
    samuel.nunes@milatransportes.com.br
    silas.littig@venac.com.br
    ",
            "CNPJ" => "27.227.982/0001-05",
            "Tel.Contato" => "(27) 2123-7909
    (27) 4009-0300
    (27) 2123-7900
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 360828,
            "Empresa" => "VEREDA TRANSPORTE LTDA",
            "E-mail.Contato" => "enfermagem@viacaopraiasol.com.br
    ",
            "CNPJ" => "12.478.298/0001-29",
            "Tel.Contato" => "(27) 3320-0511
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 429713,
            "Empresa" => "VERTICE SEGURANCA E VIGILANCIA EIRELI - ME ",
            "E-mail.Contato" => "financeiro1@verticeseg.com.br
    ",
            "CNPJ" => "22.800.699/0001-07",
            "Tel.Contato" => "(27) 3323-1570
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 245073,
            "Empresa" => "VFM TRANSPORTES - EIRELI - EPP",
            "E-mail.Contato" => "recepcao@vfmtransportes.com.br
    ",
            "CNPJ" => "08.234.681/0001-64",
            "Tel.Contato" => "(27) 3336-0789
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 587249,
            "Empresa" => "VIA BRASIL AUTOMOVEIS LTDA - PRIME MOTORS",
            "E-mail.Contato" => "faturamento.linhares@primehyundai.com.br
    rh.serra@primehyundai.com.br
    adm25@citroenpassion.com.br
    financeiro.vv@primehyundai.com.br
    ",
            "CNPJ" => "04.717.513/0002-50",
            "Tel.Contato" => "(27) 3372-4000
    (27) 3203-5003
    (27) 3067-8035
    (27) 3203-5001
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 360806,
            "Empresa" => "VIACAO PRAIA SOL LTDA",
            "E-mail.Contato" => "enfermagem@viacaopraiasol.com.br
    ",
            "CNPJ" => "31.806.623/0001-80",
            "Tel.Contato" => "(27) 3320-0511
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 394545,
            "Empresa" => "VIACAO PRETTI LTDA ",
            "E-mail.Contato" => "suiani.passos@viacaopretti.com.br
    ",
            "CNPJ" => "27.488.725/0001-27",
            "Tel.Contato" => "(27) 2101-5750
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 628204,
            "Empresa" => "VIACAO TABUAZEIRO LTDA ",
            "E-mail.Contato" => "atilazandonadi@mt-es.com.br
    jocenimeneghel@tabuazeiro.com.br
    karolinybatista@tabuazeiro.com.br
    luizvaccari@tabuazeiro.com.br
    ",
            "CNPJ" => "27.057.256/0001-91",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 564175,
            "Empresa" => "VIAFOR VEICULOS LTDA",
            "E-mail.Contato" => "raphael.carlos@viaforveiculos.com.br
    ",
            "CNPJ" => "31.791.890/0004-73",
            "Tel.Contato" => "(27) 3723-0050
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 624941,
            "Empresa" => "VIDA OCUPACIONAL SEGURANCA E MEDICINA DO TRABALHO LTDA ",
            "E-mail.Contato" => "exames@vidaocupacional.com.br
    ",
            "CNPJ" => "18.802.656/0001-93",
            "Tel.Contato" => "(11) 4508-7389
    ",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 592903,
            "Empresa" => "VIDAMED CARE CLINICA E RESIDENCIA ASSISTIDA LTDA ",
            "E-mail.Contato" => "administrativo@raizer.com.br
    ",
            "CNPJ" => "27.596.191/0001-52",
            "Tel.Contato" => "(27) 3019-9031
    ",
            "Sub Grupo" => "CLIENTES AVULSO"),
        array(
            "Código" => 427514,
            "Empresa" => "VILA VITORIA MERCANTIL DO BRASIL LTDA ",
            "E-mail.Contato" => "dp@vilavitoriamercantil.com.br
    ",
            "CNPJ" => "14.024.944/0001-03",
            "Tel.Contato" => "(27) 3386-0444
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 649867,
            "Empresa" => "GRUPO ELLOS ",
            "E-mail.Contato" => "emanuelle@grupoellos.com
    helane@grupoellos.com
    ",
            "CNPJ" => "13.445.545/0001-53",
            "Tel.Contato" => "(27) 2141-8135
    (27) 2141-8135
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 244886,
            "Empresa" => "VIPAU IMPORTACAO E EXPORTACAO S/A",
            "E-mail.Contato" => "",
            "CNPJ" => "03.528.688/0001-75",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 305851,
            "Empresa" => "VISIO SEGURANCA",
            "E-mail.Contato" => "rafael.carvalho@visiogestao.com.br
    ",
            "CNPJ" => "11.064.033/0001-11",
            "Tel.Contato" => "(11) 2225-1005
    ",
            "Sub Grupo" => "CONVENIOS"),
        array(
            "Código" => 335184,
            "Empresa" => "VITORIA BRASIL",
            "E-mail.Contato" => "gerencia@disklimpezanet.com.br
    ",
            "CNPJ" => "04.680.954/0001-43",
            "Tel.Contato" => "(27) 3399-1868
    ",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 571150,
            "Empresa" => "VITORIA CARDAN COMERCIO DE PECAS E SERVICOS LTDA",
            "E-mail.Contato" => "cardanvfs@gamil.com
    danissousa@gmail.com
    vitoriacardan@gmail.com
    ",
            "CNPJ" => "07.520.346/0001-60",
            "Tel.Contato" => "(27) 3068-4722
    (27) 3343-0711
    (27) 3343-0711
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 383540,
            "Empresa" => "VITORIA COMERCIO DE GAS LTDA - ME",
            "E-mail.Contato" => "maruipegas@gmail.com
    ",
            "CNPJ" => "21.599.940/0001-19",
            "Tel.Contato" => "(27) 3200-3363
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 353729,
            "Empresa" => "VITORIA COMERCIO DE MOTOS LTDA ",
            "E-mail.Contato" => "emilaine.paiva@vitoriahd.com.br
    ",
            "CNPJ" => "20.402.865/0001-91",
            "Tel.Contato" => "(27) 3357-7172
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 263025,
            "Empresa" => "VITORIA HOME CARE - ASSISTENCIA MEDICA DOMICILIAR LTDA ",
            "E-mail.Contato" => "financeiro@vitoriahomecare.com.br
    rh@vitoriahomecare.com.br
    ",
            "CNPJ" => "16.588.680/0001-46",
            "Tel.Contato" => "(27) 3024-8585
    (27) 3024-8585
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 493725,
            "Empresa" => "VITORIA PLAST ",
            "E-mail.Contato" => "marcelo.lopes@novaformapvc.com.br
    ",
            "CNPJ" => "19.454.122/0001-86",
            "Tel.Contato" => "(27) 3246-4750
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 574095,
            "Empresa" => "VITRAN ENGENHARIA LTDA ",
            "E-mail.Contato" => "",
            "CNPJ" => "05.465.979/0002-78",
            "Tel.Contato" => "",
            "Sub Grupo" => "CONTRATOS AVULSO"),
        array(
            "Código" => 394829,
            "Empresa" => "VIVARELLA LOGISTICA LTDA. ",
            "E-mail.Contato" => "fernanda.pitol@asteserv.com.br
    samella.oliveira@asteserv.com.br
    jamile.pereira@asteserv.com.br
    ",
            "CNPJ" => "06.183.954/0001-63",
            "Tel.Contato" => "(27) 2127-4752
    (27) 2127-4752
    (27) 2127-4753
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 635611,
            "Empresa" => "ADIDAS VITORIA",
            "E-mail.Contato" => "luizfelipeadidasvitoria@psigrupo.com.br
    ",
            "CNPJ" => "32.725.388/0001-84",
            "Tel.Contato" => "(27) 99784-6719
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 355184,
            "Empresa" => "VIX ENERGY - ENERGIA E INFRAESTRUTURA LTDA - ME ",
            "E-mail.Contato" => "andregustavo.vixenergy@outloo.com
    ",
            "CNPJ" => "12.858.862/0003-09",
            "Tel.Contato" => "(27) 99627-8537
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 527819,
            "Empresa" => "VIX LOG LOGISTICA LTDA",
            "E-mail.Contato" => "keyla@vixloglogistica.com.br
    ",
            "CNPJ" => "14.168.284/0001-34",
            "Tel.Contato" => "(27) 9975-3451
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 281182,
            "Empresa" => "VIX LOGISTICA S/A",
            "E-mail.Contato" => "contencioso@vix.com.br
    ",
            "CNPJ" => "32.681.371/0001-72",
            "Tel.Contato" => "(27) 2125-1836
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 395326,
            "Empresa" => "VIXTEAM CONSULTORIA & SISTEMAS S.A ",
            "E-mail.Contato" => "patricia.tavares@vixteam.com.br
    ",
            "CNPJ" => "02.960.701/0001-06",
            "Tel.Contato" => "(27) 3331-3137
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 507881,
            "Empresa" => "W.A CONSTRUCOES E EDIFICACOES LTDA (ALPHA CONSTRUTORA) ",
            "E-mail.Contato" => "alphaconstrutora7@gmail.com
    ",
            "CNPJ" => "30.193.880/0001-20",
            "Tel.Contato" => "(27) 99663-8862
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 389402,
            "Empresa" => "SINEPE - COLEGIO LUSIADAS",
            "E-mail.Contato" => "financeiro@colegioluziadas.com.br
    dina.valadares@colegiolusiadas.com.br
    wagner.pires@colegiolusiadas.com.br
    ",
            "CNPJ" => "02.359.033/0001-58",
            "Tel.Contato" => "(27) 3336-2293
    (27) 99967-5533
    (27) 3336-2293
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 305834,
            "Empresa" => "WECHSEL LTDA",
            "E-mail.Contato" => "jose.carlos@wechsel.com.br
    sesmt.sp@wechsel.com.br
    paola.oliveira@wechsel.com.br
    valquiria.martins@wechsel.com.br
    ",
            "CNPJ" => "04.940.977/0001-40",
            "Tel.Contato" => "(11) 5678-4848

    (11) 5678-4848
    (11) 5678-4848
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 587394,
            "Empresa" => "WESLEY KRAUSE - W A CONSTRUCOES E REFORMAS",
            "E-mail.Contato" => "waconstt@gmail.com
    ",
            "CNPJ" => "18.618.647/0001-47",
            "Tel.Contato" => "(27) 98144-1025
    ",
            "Sub Grupo" => "CONTRATOS EXAMES - AVULSO"),
        array(
            "Código" => 432645,
            "Empresa" => "XERYU S IMPORTADORA E DISTRIBUIDORA DE ARTIGOS PARA VESTUA",
            "E-mail.Contato" => "marciana@xeryus.com.br
    marcos@xeryus.com.br
    ",
            "CNPJ" => "07.764.744/0002-02",
            "Tel.Contato" => "(27) 3341-9178
    (27) 3341-9178
    ",
            "Sub Grupo" => "CONTRATOS ASSESSORIA"),
        array(
            "Código" => 626077,
            "Empresa" => "ZARB COMERCIO E DISTRIBUIDOR DE ALIMENTOS LTDA ",
            "E-mail.Contato" => "rh.zarb@zarbdistribuidora.com.br
    financeiro01@zarbdistribuidora.com.br
    ",
            "CNPJ" => "07.790.729/0001-58",
            "Tel.Contato" => "(27) 3226-6633
    (27) 3226-6633
    ",
            "Sub Grupo" => "CONTRATOS EXAMES"),
        array(
            "Código" => 245051,
            "Empresa" => "ZENITH MARITIMA LTDA - EPP ",
            "E-mail.Contato" => "administrativo@zenithmaritima.com.br
    gelcilio@zenithmaritima.com.br
    fabio@zenithmaritima.com.br
    suporte@zenithmaritima.com.br
    nfe@zenithmaritima.com.br
    ",
            "CNPJ" => "04.978.039/0001-39",
            "Tel.Contato" => "(27) 3029-5390
    (27) 3029-5390
    (27) 3029-5390
    (27) 3029-5390
    (27) 3029-5392
    ",
            "Sub Grupo" => "CONTRATOS AVULSO")
    );

        $data = [];

        $occupation = Occupation::create([
          'name' => 'ADM'
        ]);

        foreach ($array as $key => $item) {

            if($key > 10 && config('app.env') == 'local') {
              break;
            }

            $emailArray = explode(' ', str_replace(',', '', $item['E-mail.Contato']));

            $emailsList = [];

            foreach ($emailArray as $key => $email) {
              if(!empty($email)) {
                $emailsList[] = trim($email);
              }
            }

            //dd($emailsList);

            $telefonesArray = explode('  ', str_replace(',', '', $item['Tel.Contato']));

            $telefonesList = [];

            foreach ($telefonesArray as $key => $telefone) {
              if(!empty($telefone)) {
                $telefonesList[] = trim($telefone);
              }
            }

            //dd($telefonesList);

            $data = [
                'code' => ($item['Código']),
                'name' => trim($item['Empresa']),
                //'email' => $emailsList,
                'document' => trim($item['CNPJ']),
                //'telefone' => $telefonesList,
                //'contrato' => trim($item['Sub Grupo']),
            ];

            $contractName = trim($item['Sub Grupo']);

            $contract = Contract::updateOrCreate([
              'name' => $contractName
            ]);

            $data['contract_id'] = $contract->id;

            $client = Client::updateOrCreate($data);

            foreach ($telefonesList as $key => $phone) {
                Phone::updateOrCreate([
                  'number' => $phone,
                  'client_id' => $client->id
                ]);
            }

            foreach ($emailsList as $key => $email) {
                Email::updateOrCreate([
                  'email' => strtolower($email),
                  'client_id' => $client->id
                ]);
            }

            $faker = Faker\Factory::create();

            Employee::create([
              'company_id' => $client->id,
              'name' => $faker->name,
              'email' => $faker->freeEmail,
              'phone' => $faker->phoneNumber,
              'cpf' => $faker->phoneNumber,
              'created_by' => 1,
              'occupation_id' => $occupation->id,
              'active' => true
            ]);

        }



    }
}
