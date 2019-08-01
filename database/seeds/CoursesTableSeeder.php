<?php

use Illuminate\Database\Seeder;
use App\Models\Training\Course;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = array(
          	0 => array(
          		'courses' => 'NR 01 - ORDEM DE SERVIÇOS',
          		'workload' => '01',
          		'LOCAL' => 'IN COMPANY OU CENTRO DE TREINAMENTOS - PROVIDER ',
          		'description' => 'Neste treinamento abordamos sobre as disposições gerais das normas regulamentadoras de acordo com exigências do Ministério do Trabalho e Emprego.'
          	),
          	1 => array(
          		'courses' => 'NR 05 - FORMAÇÃO DE MEMBROS DA CIPA',
          		'workload' => '20',
          		'LOCAL' => 'IN COMPANY OU CENTRO DE TREINAMENTOS - PROVIDER',
          		'description' => 'Neste treinamento abordamos sobre a Comissão Interna de Prevenção de Acidentes; bem como seus objetivos, obrigações e dimensionamento, conforme exigências do Ministério do Trabalho e Emprego.'
          	),
          	2 => array(
          		'courses' => 'NR 06 - SEGURANÇA NA UTILIZAÇÃO DOS EPI\'S',
          		'workload' => '01',
          		'LOCAL' => 'IN COMPANY OU CENTRO DE TREINAMENTOS - PROVIDER',
          		'description' => 'Neste treinamento falaremos sobre os Equipamentos de Proteção Individual, frisando a importância de seu uso correto, guarda e conservação.'
          	),
          	3 => array(
          		'courses' => 'NR 17 - NOÇÕES DE SEGURANÇA SOBRE ERGONOMIA DO TRABALHO, INTEGRAÇÃO PARA OPERADORES DE CAIXA E OPERADORES DE CALL CENTER ( TELE ATENDIMENTO)',
          		'workload' => '04',
          		'LOCAL' => 'IN COMPANY OU CENTRO DE TREINAMENTOS - PROVIDER ',
          		'description' => 'Neste treinamento abordaremos sobre a ergonomia no ambiente de trabalho, estabelecendo medidas de prevenção de doenças e acidentes no levantamento, transporte e descarga de materiais, padronizando o mobiliário, equipamentos e às condições ambientais do posto de trabalho e à própria organização do trabalho, de acordo com o estabelecido na NR 17'
          	),
          	4 => array(
          		'courses' => 'NR 18 - SAÚDE E SEGURANÇA DO TRABALHO NA INDUSTRIA DA CONSTRUÇÃO CIVIL',
          		'workload' => '06',
          		'LOCAL' => 'IN COMPANY OU CENTRO DE TREINAMENTOS - PROVIDER ',
          		'description' => 'Neste treinamento abordamos a implementação de medidas de controle de riscos no meio ambiente de trabalho na Indústria da Construção'
          	),
          	5 => array(
          		'courses' => 'NR 23 - NOÇÕES DE COMBATE A INCÊNDIO',
          		'workload' => '02',
          		'LOCAL' => 'IN COMPANY OU CENTRO DE TREINAMENTOS - PROVIDER ',
          		'description' => 'Neste treinamento enfatizamos a importância da adoção de medidas de prevenção e combate a incêndios de acordo com a norma 23.'
          	),
          	6 => array(
          		'courses' => 'NR 32 - INTEGRAÇÃO DE SEGURANÇA EM HOSPITAIS',
          		'workload' => '04',
          		'LOCAL' => 'IN COMPANY OU CENTRO DE TREINAMENTOS - PROVIDER ',
          		'description' => 'Neste treinamento falamos sobre as diretrizes básicas de implementação das medidas de proteção à segurança e à saúde dos trabalhadores dos serviços de saúde'
          	),
          	7 => array(
          		'courses' => 'NR 33 - SEGURANÇA NO TRABALHO EM ESPAÇOS CONFINADOS - TEÓRICO',
          		'workload' => '08',
          		'LOCAL' => 'IN COMPANY OU CENTRO DE TREINAMENTOS – PROVIDER',
          		'description' => 'Neste treinamento abordamos os requisitos mínimos para identificação de espaços confinados e o reconhecimento, avaliação, monitoramento e controle dos riscos existentes, garantindo a segurança e saúde dos trabalhadores.'
          	),
          	9 => array(
          		'courses' => 'NR 35 - SEGURANÇA NOS TRABALHOS EM ALTURA - TEÓRICO',
          		'workload' => '08',
          		'LOCAL' => 'IN COMPANY OU CENTRO DE TREINAMENTOS - PROVIDER ',
          		'description' => 'Neste treinamento falaremos sobre as medidas de proteção para o trabalho em altura. Envolvendo o planejamento, a organização e a execução do trabalho para garantir a saúde e segurança dos trabalhadores.'
          	),
          	10 => array(
          		'courses' => 'NR 36 – SEGURANÇA EM FRIGORIFICOS',
          		'workload' => '04',
          		'LOCAL' => 'IN COMPANY OU CENTRO DE TREINAMENTOS - PROVIDER ',
          		'description' => 'Neste treinamento abordaremos sobre a avaliação, controle e monitoramento dos riscos existentes nas atividades desenvolvidas na indústria de abate e processamento de carnes e derivados destinados ao consumoumano'
          	),
          	11 => array(
          		'courses' => 'PRIMEIROS SOCORROS BÁSICOS',
          		'workload' => '04',
          		'LOCAL' => 'IN COMPANY OU CENTRO DE TREINAMENTOS - PROVIDER',
          		'description' => 'Neste treinamento abordamos as noções para a realização dos primeiros socorros em diversas situações de acidentes com vítimas de forma a transmitir conhecimento para ajuda até a chegada do socorro médico.'
          	),
          	12 => array(
          		'courses' => 'BRIGADA DE INCÊNDIO',
          		'workload' => '20',
          		'LOCAL' => 'IN COMPANY OU CENTRO DE TREINAMENTOS – PROVIDER',
          		'description' => 'Neste treinamento falamos sobre a importância da prevenção e como executa - lá. Orientamos sobre a avaliação de extintores, instalações elétricas, aplicação de um plano de emergência contra incêndio e evacuação de área.'
          	),
          	15 => array(
          		'courses' => 'ANDAIMES',
          		'workload' => '01',
          		'LOCAL' => 'IN COMPANY OU CENTRO DE TREINAMENTOS - PROVIDER ',
          		'description' => 'Aborda sobre a montagem dos andaimes e métodos de segurança em trabalhos  com andaimes'
          	),
          	16 => array(
          		'courses' => 'ATO INSEGURO E CONDIÇÃO INSEGURA',
          		'workload' => '01',
          		'LOCAL' => 'IN COMPANY OU CENTRO DE TREINAMENTOS - PROVIDER ',
          		'description' => 'Aborda sobre a diferença entre ato inseguro e condição insegura, e como isso interfere no ambiente de trabalho'
          	),
          	17 => array(
          		'courses' => 'BASICO PRIMEIROS SOCORROS',
          		'workload' => '02',
          		'LOCAL' => '  IN COMPANY OU CENTRO DE TREINAMENTOS - PROVIDER',
          		'description' => 'Aborda as noções básicas para a realização dos primeiros socorros '
          	),
          	18 => array(
          		'courses' => 'BASICO COMBATE A INCENDIO',
          		'workload' => '01',
          		'LOCAL' => 'IN COMPANY OU CENTRO DE TREINAMENTOS - PROVIDER ',
          		'description' => 'Aborda as noções básicas para combate a incêndio '
          	),
          	19 => array(
          		'courses' => 'BRIGADA E COMBATE A INCENDIO',
          		'workload' => '01',
          		'LOCAL' => 'IN COMPANY OU CENTRO DE TREINAMENTOS - PROVIDER ',
          		'description' => 'Aborda as noções básicas de brigada para combate a incêndio '
          	),
          	20 => array(
          		'courses' => 'DIREÇÃO DEFENSIVA E SEGURANÇA NO TRANSITO',
          		'workload' => '01',
          		'LOCAL' => 'IN COMPANY OU CENTRO DE TREINAMENTOS - PROVIDER ',
          		'description' => 'Aborda sobre como agir no transito se portando de forma segura '
          	),
          	21 => array(
          		'courses' => 'DST',
          		'workload' => '01',
          		'LOCAL' => 'IN COMPANY OU CENTRO DE TREINAMENTOS - PROVIDER ',
          		'description' => 'Traz noções e conhecimentos sobre as DST’s e como prevenir as mesmas'
          	),
          	22 => array(
          		'courses' => 'HIGIENE OCUPACIONAL',
          		'workload' => '01',
          		'LOCAL' => 'IN COMPANY OU CENTRO DE TREINAMENTOS - PROVIDER ',
          		'description' => 'Aborda as noções sobre as classificações de riscos existentes e as avaliações necessárias para cada risco, bem como a importância da realização de avaliações'
          	),
          	23 => array(
          		'courses' => 'LIMPEZA E DESINFECÇÃO DE AMBIENTES MÉDICOS E HOSPITALARES',
          		'workload' => '01',
          		'LOCAL' => 'IN COMPANY OU CENTRO DE TREINAMENTOS - PROVIDER ',
          		'description' => 'Aborda sobre a importância da limpeza correta de ambientes com grandes riscos biológicos'
          	),
          	24 => array(
          		'courses' => 'PREVENÇÃO AO TABAGISMO',
          		'workload' => '01',
          		'LOCAL' => 'IN COMPANY OU CENTRO DE TREINAMENTOS - PROVIDER ',
          		'description' => 'Aborda sobre o tabagismo, seu impacto no corpo humano, e a importância da sua prevenção'
          	),
          	25 => array(
          		'courses' => 'PERCEPÇÃO DE RISCOS',
          		'workload' => '01',
          		'LOCAL' => 'IN COMPANY OU CENTRO DE TREINAMENTOS - PROVIDER ',
          		'description' => 'Traz noções para reconhecimento dos riscos nos postos de trabalho e como poderá preveni-los  '
          	),
          	26 => array(
          		'courses' => 'QUALIDADE DE VIDA NO TRABALHO',
          		'workload' => '01',
          		'LOCAL' => 'IN COMPANY OU CENTRO DE TREINAMENTOS - PROVIDER ',
          		'description' => 'Aborda sobre a qualidade de vida no trabalho e como ela interfere durante a execução da atividade na empresa '
          	),
          	27 => array(
          		'courses' => 'RELACIONAMENTO INTERPESSOAL',
          		'workload' => '01',
          		'LOCAL' => 'IN COMPANY OU CENTRO DE TREINAMENTOS - PROVIDER ',
          		'description' => 'Aborda sobre o relacionamento interpessoal com colegas do trabalho, trabalhos em equipe e os retornos de um bom ou mal relacionamento no setor '
          	),
          	28 => array(
          		'courses' => 'TRANSPORTE MANUAL DE CARGAS',
          		'workload' => '01',
          		'LOCAL' => 'IN COMPANY OU CENTRO DE TREINAMENTOS - PROVIDER ',
          		'description' => 'Aborda sobre a forma correta de transporte de cargas, conforme as exigências do Ministério do Trabalho e Emprego '
          	),
          	29 => array(
          		'courses' => 'ALCOLISMO',
          		'workload' => '01',
          		'LOCAL' => '  IN COMPANY OU CENTRO DE TREINAMENTOS - PROVIDER',
          		'description' => 'Aborda sobre o alcoolismo e seu impacto no organismo, bem como sua influência durante a execução das atividades no ambiente de trabalho, e a forma de prevenção '
          	),
          	30 => array(
          		'courses' => 'PALESTRA DE ERGONOMIA',
          		'workload' => '01',
          		'LOCAL' => 'IN COMPANY OU CENTRO DE TREINAMENTOS - PROVIDER ',
          		'description' => 'Traz noções de ergonomia como postura correta do corpo durante a execução de atividades, bem estar psicológico e suas influências no corpoumano'
          	),
          	31 => array(
          		'courses' => 'PALESTRA DE SEGURANÇA DO TRABALHO',
          		'workload' => '01',
          		'LOCAL' => '  IN COMPANY OU CENTRO DE TREINAMENTOS - PROVIDER',
          		'description' => 'Traz noções sobre o que é a segurança do trabalho e o que é abordado no trabalho de SST, bem como a importância para uma boa execução das atividades no trabalho '
          	),
          	32 => array(
          		'courses' => 'SEGURANÇA NO LAR',
          		'workload' => '02',
          		'LOCAL' => 'IN COMPANY OU CENTRO DE TREINAMENTOS - PROVIDER',
          		'description' => 'Aborda sobre as formas de segurança e prevenção de acidentes em residência '
          	),
          	33 => array(
          		'courses' => 'ACIDENTES DO TRABALHO',
          		'workload' => '01',
          		'LOCAL' => '  IN COMPANY OU CENTRO DE TREINAMENTOS PROVIDER',
          		'description' => 'Aborda sobre noções de acidentes, reconhecimento dos acidentes e formas de prevenção'
          	),
          );

        foreach ($array as $key => $item) {

            if(empty($item['courses'])) {
              continue;
            }

            Course::updateOrCreate([
              'title' => $item['courses'],
              'description' => $item['description'],
              'workload' => $item['workload'],
              'created_by' => 1
            ]);

        }
    }
}
