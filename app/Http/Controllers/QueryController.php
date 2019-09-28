<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
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

    public function executeTableQuery($id, Request $request)
    {
        $data = $request->request->all();

        $colunas = $result = $log = [];

        $tableName = $id;
        $columnName = $request->get('column');

        $table = Table::where('name', $tableName)->first();

        if(!$table) {
            abort(403, 'Nenhum registro encontrado, tabela inexistente.');
        }

        $column = $table->columns->filter(function($column, $k) use ($columnName) {
            return $column->name == $columnName;
        })->first();

        if(!$column) {
            abort(403, 'Nenhum registro encontrado, coluna inexistente.');
        }

        //dd($column);

        //$column = Column::uuid($request->get('column'));

        //dd($column);

        //$table = $app['tables.repository']->findOneBy(['nome' => $tabela]);
        //$column = $app['columns.repository']->findOneBy(['nome' => $coluna, 'tabela' => $table]);
        $key = !empty($column) ? $column->name : null;

        if (!$column) {
            //$col = $app['columns.repository']->findOneBy(['tabela' => $table, 'chavePrimaria' => true]);

            //$col = Column::where($request->get('column'));

            $col = $table->columns->filter(function($column, $k) {
                return $column->is_primary_key == true;
            })->first();

            if ($col) {
                $key = $col->name;
            }
        }

        //$tableColumns = $app['columns.repository']->findBy(['tabela' => $table, 'visualizar' => true]);

        $tableColumns = $table->columns->filter(function($column, $k) {
            return $column->show == true;
        });

        //dd($tableColumns);

        $strColumns = "";

        foreach ($tableColumns as $tableColumn) {
            $strColumns .= $tableColumn->name . ", ";
        }

        $strColumns = substr($strColumns, 0, -2);

        $valor = $request->get('value');

        //dd($valor);

        $string = "SELECT {$strColumns} FROM {$table->database}.{$table->name} WHERE {$key} = {$valor}";

        //dd($string);

        try {
            //$result = $app['db']->fetchAll($string);

            $result = DB::connection('mysql')
            //->table($query->table->name)
            ->select($string);
            //->paginate();

        } catch (Exception $e) {
            $log = $e->getMessage();
        }

        $arrayResult = [];

        $retorno = [];

        /*if ($result) {

            $arrayColumns = [];

            $columns = $app['columns.repository']->findBy(['tabela' => $table, 'visualizar' => true]);

            foreach ($columns as $key => $column) {
                $arrayColumns[$column->getNome()]['id'] = $column->getId();
                $arrayColumns[$column->getNome()]['visualizar'] = $column->isVisualizar();
                $arrayColumns[$column->getNome()]['nome'] = $column->getNome();
                $arrayColumns[$column->getNome()]['identificador'] = $column->getIdentificador();
                $arrayColumns[$column->getNome()]['formato'] = $column->getFormato() ? $column->getFormato()->getNome() : null;
                $arrayColumns[$column->getNome()]['tabelaNome'] = $column->getTabelaRef() ? $column->getTabelaRef()->getNome() : null;
            }

            foreach ($result as $itens) {

                foreach ($itens as $key => $item) {

                    if (empty($item)) {
                        $item = null;
                    }

                    if (isset($arrayColumns[$key]) && !$arrayColumns[$key]['visualizar']) {
                        unset($itens[$key]);
                    }

                    if (!isset($arrayColumns[$key])) {
                        continue;
                    }

                    if (!empty($arrayColumns[$key]['formato'])) {

                        switch ($arrayColumns[$key]['formato']) {

                            case 'Data' :

                                if (empty($item)) {
                                    break;
                                }

                                $data = DateTime::createFromFormat('Ymd', $item);

                                if (!$data instanceof DateTime) {
                                    break;
                                }

                                $item = $data->format('d/m/Y');
                                break;

                            case 'Data e Hora' :

                                if (empty($item)) {
                                    break;
                                }

                                $data = DateTime::createFromFormat('Y-m-d H:i:s', $item);

                                if (!$data instanceof DateTime) {
                                    break;
                                }

                                $item = $data->format('d/m/Y H:i:s');
                                break;

                            case 'Boolean' :
                                $item = $item ? 'Sim' : 'Nao';
                                break;

                            case 'Moeda' :
                                $item = number_format($item, 2);
                                break;
                        }

                    }

                    if ($key == $arrayColumns[$key]['nome'] && !empty($arrayColumns[$key]['visualizar'])) {
                        $retorno[$key] = [
                            'valor' => !empty($item) ? $item : null,
                            'coluna' => $key,
                            'tabela' => null,
                            'label' => null,
                            'nome' => $arrayColumns[$key]['identificador'] ?: $arrayColumns[$key]['nome'],
                        ];
                    }

                    if ($key == $arrayColumns[$key]['nome'] && !empty($arrayColumns[$key]['tabelaNome'])) {

                        $table = $app['tables.repository']->findOneBy(['nome' => $arrayColumns[$key]['tabelaNome']]);
                        $columnsB = $app['columns.repository']->findBy(['tabela' => $table]);

                        $retorno[$key] = [
                            'valor' => !empty($item) ? $item : null,
                            'coluna' => $key,
                            'tabela' => $arrayColumns[$key]['tabelaNome'],
                            'label' => $item,
                            'nome' => $arrayColumns[$key]['identificador'] ?: $arrayColumns[$key]['nome'],
                        ];

                        $nomesColunas = array_map(function ($coluna) {
                            return $coluna->name;
                        }, $columnsB);

                        $chavePrimaria = array_filter($columnsB, function ($coluna) {
                            return $coluna->is_primary_key == true;
                        });

                        $pk = !empty($chavePrimaria) ? current($chavePrimaria)->getNome() : null;

                        foreach ($columnsB as $cs) {

                            if ($cs->isLabel()) {

                                if (!$item) {
                                    continue;
                                }

                                $field = $key;

                                if ($pk) {
                                    $field = $pk;
                                }

                                if (!in_array($key, $nomesColunas)) {
                                    $colunasTabela = $app['columns.repository']->findBy(['nome' => $arrayColumns[$key]['tabelaNome']]);
                                    $chavePrimaria = array_filter($colunasTabela, function ($coluna) {
                                        return $coluna->isChavePrimaria();
                                    });
                                    $chaveLabel = array_filter($colunasTabela, function ($coluna) {
                                        return $coluna->isLabel();
                                    });
                                    if ($chaveLabel) {
                                        $field = current($chaveLabel)->getNome();
                                    } elseif ($chavePrimaria) {
                                        $field = current($chavePrimaria)->getNome();
                                    }
                                }

                                $table = $app['tables.repository']->findOneBy(['nome' => $arrayColumns[$key]['tabelaNome']]);

                                $string = "SELECT {$cs->getNome()} FROM {$table->getSchema()}.{$arrayColumns[$key]['tabelaNome']} WHERE {$field} = {$item}";
                                $strColumn = $app['db']->fetchColumn($string);
                                $retorno[$key]['label'] = $strColumn;
                            }

                            if ($cs->getIdentificador() && $cs->getNome() == $arrayColumns[$key]['nome']) {
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
          */
        if ($result) {

          $arrayColumns = [];

          //$table = $query->table;
          $columns = $table->columns;

          foreach ($columns as $key => $column) {
              $arrayColumns[$column->name]['parentTable'] = $column->table->name;
              $arrayColumns[$column->name]['id'] = $column->id;
              $arrayColumns[$column->name]['visualizar'] = $column->show;
              $arrayColumns[$column->name]['nome'] = $column->name;
              $arrayColumns[$column->name]['identificador'] = $column->label;
              $arrayColumns[$column->name]['formato'] = $column->format ? $column->format->id : null;
              $arrayColumns[$column->name]['tabelaNome'] = $column->tableReference ? $column->tableReference->name : null;
          }

          //dd($arrayColumns);

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
                          'parentTable' => $arrayColumns[$key]['parentTable'],
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
                          'parentTable' => $arrayColumns[$key]['parentTable'],
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

        return view('reports.queries.execute-query', [
          'result' => $arrayResult,
          'columns' => $colunas,
          'log' => $log,
          'query' => null,
          'table' => $table,
          'parametros' => null,
          'parametrosR' => null,
        ]);
    }

    public function executeQuery($id, Request $request)
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
            ->get();

            if ($result) {

            $arrayColumns = [];

            //$table = $query->table;
            $columns = $table->columns;

            foreach ($columns as $key => $column) {
                $arrayColumns[$column->name]['parentTable'] = $column->table->name;
                $arrayColumns[$column->name]['id'] = $column->id;
                $arrayColumns[$column->name]['visualizar'] = $column->show;
                $arrayColumns[$column->name]['nome'] = $column->label ?? $column->name;
                $arrayColumns[$column->name]['identificador'] = $column->label;
                $arrayColumns[$column->name]['formato'] = $column->format ? $column->format->id : null;
                $arrayColumns[$column->name]['tabelaNome'] = $column->tableReference ? $column->tableReference->name : null;
            }

            $retorno = [];
            $colunas = $arrayResult = [];

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
                            'parentTable' => $arrayColumns[$key]['parentTable'],
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
                            'parentTable' => $arrayColumns[$key]['parentTable'],
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
                                    //dd($strColumnC);
                                    $retorno[$key]['label'] = $strColumnC->title ?? $strColumnC->label ?? $strColumnC->name ?? null;
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

            $columns = array_map(function ($coluna) {
                return ucwords(str_replace('_', ' ', $coluna));
            }, $colunas);

            }

            $collection = collect($arrayResult);

            $page = $request->has('page') ? $request->get('page') : 1;
            $perPage = 10;

            $result = new LengthAwarePaginator($collection->forPage($page, $perPage), $collection->count(), $perPage, $page, [
                'path'  => $request->url(),
                'query' => $request->query(),
            ]);

            //$result = $arrayResult;

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
                  $arrayColumns[$column->name]['parentTable'] = $column->table->name;
                  $arrayColumns[$column->name]['id'] = $column->id;
                  $arrayColumns[$column->name]['visualizar'] = $column->show;
                  $arrayColumns[$column->name]['nome'] = $column->name;
                  $arrayColumns[$column->name]['identificador'] = $column->label;
                  $arrayColumns[$column->name]['formato'] = $column->format ? $column->format->id : null;
                  $arrayColumns[$column->name]['tabelaNome'] = $column->tableReference ? $column->tableReference->name : null;
              }

              //dd($arrayColumns);

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
                              'parentTable' => $arrayColumns[$key]['parentTable'],
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
                              'parentTable' => $arrayColumns[$key]['parentTable'],
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
