<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report\{Table, Column, Query, Format};
use App\Helpers\ParametersHelper;
use DateTime;
use DB;

class QueryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function executeQuery($id)
    {
        try {

            $table = Table::uuid($id);

            $sql = "SELECT * FROM "  . $table->database . '.' . $table->name . ";";

            $columns = $table->columns->filter(function($column, $k) {
                return $column->show == true;
            });

            $selectColumns = $columns->map(function($column) {
                return $column->name;
            });

            $selectColumns = implode(', ',$selectColumns->toArray());

            $result = DB::connection('mysql')
            ->table($table->name)
            ->select(DB::raw($selectColumns))
            ->paginate();

            return view('reports.queries.execute', compact('result', 'columns', 'table'));

        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function execute($id, Request $request)
    {
      $paramsFromRequest = $request->query->all();
      $pR = [];

      if (!empty($paramsFromRequest)) {

          foreach ($paramsFromRequest as $key => $param) {
              $pR[$key] = $param;
          }

      }

      $query = Query::uuid($id);

      $string = $query->query;

      $parametros = $dados = [];

      $slug = strstr($string, ':');
      $key = strrpos($slug, ':');
      $resultado = substr($slug, 0, $key + 1);
      $itens = explode(',', str_replace(' ', ',', $resultado));

      $parametrosQuery = $query->parameters;

      //dd($itens);

      $parametrosR = ParametersHelper::render($parametrosQuery, $request);

      //dd($parametrosR);

      foreach ($itens as $item) {

          if (strpos($item, ':') !== false) {
              $item = strstr($item, ':');
              $key = strrpos($item, ':');
              $item = substr($item, 1, $key - 1);

              $parametros[$item]['tipo'] = 'text';

              if (strpos($item, 'Data') !== false) {
                  $parametros[$item]['tipo'] = 'date';
              }

              $parametros[$item]['valor'] = $item;
          }

      }

      //dd($parametros);

      if ($pR) {

          $parametrosE = $query->parameters;

          //dd($parametrosE);

          $arrParametros = [];

          //dd($parametrosE);

          foreach ($parametrosE as $param) {
              $arrParametros[] = array_merge(
                  [
                      'name' => $param->name,
                      'type' => $param->type,
                      'query' => $param->query,
                      'value' => $param->query
                  ], $arrParametros);
          }

          //dd($pR);

          foreach ($pR as $key => $item) {

              //dd($item);

              $valor = $key;

              //dd($arrParametros);

              foreach ($arrParametros as $arrParametro) {

                  if ($arrParametro['name'] != $key) {
                      continue;
                  }

                  if ($arrParametro['type'] == 'Date') {

                      if (strpos($arrParametro['name'], '-inicio') !== false) {
                          //TODO
                      }

                      if (strpos($arrParametro['name'], '-fim') !== false) {
                          //TODO
                      }

                  }

                  $valor = $key;

                  //dd($valor);

              }

              if (is_array($item)) {
                  $item = implode(',', $item);
              }

              //dd($key);

              $string = str_replace(':' . $key . ':', $item, $string);

          }
      }

      //dd($string);

      $log = $result = $colunas = [];
      $arrayResult = $colunas = [];

      //dd($parametros);

      //dd($parametros);

      //dd($paramsFromRequest);

      if ($parametros && $paramsFromRequest || empty($parametros)) {

          //$result = $app['db']->fetchAll($string);

          //echo $string;

          //dd($string);

          $result = DB::connection('mysql')
          //->table($query->table->name)
          ->select($string);
          //->paginate();

          //dd($result);

          if ($query->type == 'Selecionar') {

              if ($query->is_query_string) {

                  if ($result) {

                      $colunas = array_keys(current($result));

                      $colunas = array_map(function ($coluna) {
                          return ucwords(str_replace('_', ' ', $coluna));
                      }, $colunas);

                  }

                  return $app['twig']->render('execute.html.twig',
                      [
                          'result' => $result,
                          'columns' => $colunas,
                          'log' => $log,
                          'query' => $query,
                          'parametros' => null,
                          'parametrosR' => $parametrosR,
                          'params' => $pR,
                          'table' => $query->getTabela(),
                      ]);
              }

              if ($result) {

              $arrayColumns = [];

              $table = $query->table;
              $columns = $table->columns;

              foreach ($columns as $key => $column) {
                  $arrayColumns[$column->name]['id'] = $column->id;
                  $arrayColumns[$column->name]['visualizar'] = $column->show;
                  $arrayColumns[$column->name]['nome'] = $column->name;
                  $arrayColumns[$column->name]['identificador'] = $column->label;
                  $arrayColumns[$column->name]['formato'] = $column->format ? $column->format->id : null;
                  $arrayColumns[$column->name]['tabelaNome'] = $column->tableReference ? $column->tableReference->name : null;
              }

              $retorno = [];

              foreach ($result as $itens) {

                  foreach ($itens as $key => $item) {

                      if (empty($item)) {
                          $item = null;
                      }

                      if (isset($arrayColumns[$key]) && !$arrayColumns[$key]['visualizar']) {
                          //unset($itens[$key]);
                      }

                      if (!isset($arrayColumns[$key])) {
                          continue;
                      }

                      if (!empty($arrayColumns[$key]['formato'])) {

                          switch ($arrayColumns[$key]['formato']) {

                              case Format::TYPE_DATE :

                                  if (empty($item)) {
                                      break;
                                  }

                                  $data = DateTime::createFromFormat('Y-m-d', $item);

                                  if (!$data instanceof DateTime) {
                                      break;
                                  }

                                  $item = $data->format('d/m/Y');
                                  break;

                              case Format::TYPE_DATE_TIME :

                                  if (empty($item)) {
                                      break;
                                  }

                                  $data = DateTime::createFromFormat('Y-m-d H:i:s', $item);

                                  if (!$data instanceof DateTime) {
                                      break;
                                  }

                                  $item = $data->format('d/m/Y H:i:s');
                                  break;

                              case Format::TYPE_BOOLEAN_CONFIRMATION :
                                  $item = $item ? '<span class="label label-success">Sim</span>' : '<span class="label label-danger">Não</span>';
                                  break;

                              case Format::TYPE_BOOLEAN_SITUATION :
                                  $item = $item ? '<span class="label label-success">Ativo</span>' : '<span class="label label-danger">Inativo</span>';
                                  break;

                              case Format::TYPE_MONEY :
                                  $item = number_format($item, 2);
                                  break;
                          }

                      }

                      if ($key == $arrayColumns[$key]['nome'] && !empty($arrayColumns[$key]['visualizar'])) {
                          $retorno[$key] = [
                              'valor' => !is_null($item) ? $item : null,
                              'coluna' => $key,
                              'tabela' => null,
                              'label' => null,
                              'nome' => $arrayColumns[$key]['identificador'] ?: $arrayColumns[$key]['nome'],
                          ];
                      }

                      if ($key == $arrayColumns[$key]['nome'] && !empty($arrayColumns[$key]['tabelaNome'])) {

                          if (!$arrayColumns[$key]['visualizar']) {
                              continue;
                          }

                          //dd($arrayColumns[$key]['tabelaNome']);

                          $table = Table::where('name', $arrayColumns[$key]['tabelaNome'])->first();

                          //$table = $app['tables.repository']->findOneBy(['nome' => $arrayColumns[$key]['tabelaNome']]);
                          //$columnsB = $app['columns.repository']->findBy(['tabela' => $table]);

                          $columnsB = $table->columns;

                          $retorno[$key] = [
                              'valor' => !is_null($item) ? $item : null,
                              'coluna' => $key,
                              'tabela' => $arrayColumns[$key]['tabelaNome'],
                              'label' => $item,
                              'nome' => $arrayColumns[$key]['identificador'] ?: $arrayColumns[$key]['nome'],
                          ];

                          $nomesColunas = $columnsB->map(function($column) {
                              return $column->name;
                          });

                          $chavePrimaria = $columnsB->filter(function($column, $k) {
                              return $column->is_primary_key == true;
                          })->first();

                          //dd($chavePrimaria);

                          $pk = $chavePrimaria->name ?? 'id';

                          foreach ($columnsB as $cs) {

                              /**
                               * @var Colunas $cs
                               */
                              if ($cs->is_label) {

                                  if (!$item) {
                                      continue;
                                  }

                                  $field = $key;

                                  $hasKey = $nomesColunas->search($key);

                                  if(!$hasKey) {
                                      $field = $pk;
                                  }

                                  $table = Table::where('name', $arrayColumns[$key]['tabelaNome'])
                                    ->first();

                                  //$table = $app['tables.repository']->findOneBy(['nome' => $arrayColumns[$key]['tabelaNome']]);

                                  $string = " SELECT {$cs->name} FROM {$table->database}.{$table->name} WHERE {$field} = {$item}";

                                  //$strColumn = $app['db']->fetchColumn($string);

                                  $strColumn = DB::connection('mysql')
                                  //->table($query->table->name)
                                  ->select($string);
                                  //->paginate();

                                  //dd($retorno[$key]['label']);

                                  //dd($strColumn);
                                  foreach ($strColumn as $keyT => $strColumnC) {
                                      //echo ($strColumnC->name);
                                      $retorno[$key]['label'] = $strColumnC->name ?? null;
                                  }

                              }

                              if ($cs->label && $cs->name == $arrayColumns[$key]['nome']) {
                                  $retorno[$key]['nome'] = $arrayColumns[$key]['identificador'];
                              }

                          }
                      }
                  }
                  $arrayResult[] = $retorno;
              }

              foreach ($arrayResult as $cols) {
                  foreach ($cols as $key => $col) {
                      $colunas[] = isset($col['nome']) ? $col['nome'] : $key;
                  }
                  break;
              }

              $colunas = array_map(function ($coluna) {
                  return ucwords(str_replace('_', ' ', $coluna));
              }, $colunas);

          }

          } else {
              $log = ['classe' => 'success', 'msg' => 'A Atualização foi executada com Sucesso'];
          }
      }

      return view('reports.queries.execute-query', [
        'result' => $arrayResult,
        'columns' => $colunas,
        'log' => $log,
        'query' => $query,
        'parametros' => null,
        'parametrosR' => $parametrosR,
        'params' => $pR,
        //'table' => $tabela
      ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
