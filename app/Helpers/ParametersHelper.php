<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use App\Models\Report\{Table, Column, Query, Format};
use DB;

/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 21/07/17
 * Time: 13:29
 */
class ParametersHelper
{
    /**
     * @var Parametros
     */
    private $parameters;

    private $request;

    public static function render($parameters, Request $request)
    {
        if (empty($parameters)) {
            return;
        }

        $retorno = [];

        $param = $parameters->first();

        $retorno[] = "<input type='hidden' name='query' value={$param->queryParent->id}>";

        foreach ($parameters as $parameter) {

            $table = $parameter->column ? $parameter->column->table_reference_id : null;

            if ($parameter->column && $parameter->column->is_primary_key) {
                $table = $parameter->column->table;
            }

            $nomeItem = $parameter->column ? $parameter->column->label ?? $parameter->column->name : $parameter->name;

            $requestedValue = $request->query->all();

            if ($parameter->column) {

                if ($parameter->column->is_primary_key ||
                    $parameter->column->format) {

                    $retorno[] = self::renderInput($parameter, $nomeItem, $requestedValue);

                } else if ($table) {

                    $table = Table::find($table);
                    $search = $table->columns->search($parameter->name);

                    /*$existeColuna = $app['columns.repository']->findBy([
                        'tabela' => $tabela->getNome(),
                        'nome' => $parameter->getNome()
                    ]);*/

                    $col = $parameter->name;

                    if (!$search) {

                        $columnsB = $table->columns;

                        $colPrimary = $columnsB->filter(function($column, $k) {
                            return $column->is_primary_key == true;
                        });

                        $colLabel = $columnsB->filter(function($column, $k) {
                            return $column->is_label == true;
                        });

                        //dd($colPrimary, $colLabel);

                        /*$colPrimary = array_filter($columnsB, function ($coluna) {
                            return $coluna->isChavePrimaria() == true;
                        });

                        $colLabel = array_filter($columnsB, function ($coluna) {
                            return $coluna->isLabel() == true;
                        });*/

                        if ($colPrimary->isNotEmpty()) {
                            $col = $colPrimary->first()->name;
                        } elseif ($colLabel->isNotEmpty()) {
                            $col = $colLabel->first()->name;
                        }
                    }

                    $query = $parameter->query;

                    //$itens = $app['db']->fetchAll($query);

                    $itens = DB::connection('mysql')
                    //->table($table->name)
                    ->select(DB::raw($query));
                    //->paginate();

                    $select = '<div class="form-group">
                                        <label class="control-label col-sm-2" for="' . $parameter->name . '">' . $nomeItem . ':</label>
                                        <div class="col-sm-10">
                                        <select class="select2" required title="Nada Selecionado" multiple data-actions-box="true"
                                        data-width="100%" id="' . $parameter->name . '" name="' . $parameter->name . '[]" data-live-search="true">';

                    //dd($itens);

                    foreach ($itens as $k => $item) {

                        $columnA = $parameter->column;
                        $tableA = $columnA->tableReference;

                        if ($parameter->column->is_primary_key) {
                            $tableA = $columnA->table;
                        }

                        if ($tableA) {

                            $columnsC = $tableA->columns;

                            $colunaChavePrimaria = $columnsC->filter(function($column, $k) {
                                return $column->is_primary_key == true;
                            });

                            $colunaLabel = $columnsC->filter(function($column, $k) {
                                return $column->is_label == true;
                            });

                            $pk =  $label = $valor = null;

                            if($colunaChavePrimaria) {
                                $pk = $colunaChavePrimaria->first()->name;
                            }

                            if ($colunaLabel->isNotEmpty()) {
                                $label = $colunaLabel->first()->name;
                            } else {
                                $label = $columnsC->first()->name;
                                //$label = 'Column';
                            }

                            if (!$pk) {
                                $pk = $label;
                            }

                            if (is_numeric($item->{$label})) {
                                $pk = $label;
                            }

                            if (empty($item->{$parameter->name})) {
                                if (isset($item->{$pk})) {
                                    $valor = $item->{$pk};
                                } else {
                                    $valor = $item->{$label};
                                }
                            }

                            if (!$valor) {
                                $valor = $item->{$parameter->name};
                            }

                            $select .= '<option value="' . $valor . '"';

                            if (!empty($requestedValue)) {

                                $selectedV = $requestedValue[$parameter->name];

                                if (is_array($selectedV)) {
                                    foreach ($selectedV as $itemV) {
                                        if ($valor == $itemV) {
                                            $select .= 'selected';
                                        }
                                    }
                                }

                                if ($valor == $requestedValue[$parameter->name]) {
                                    $select .= 'selected';
                                }
                            }

                            $select .= '>' . strtoupper($item->{$label}) . '</option>';

                        } else {
                            $select .= '<option>Esta Entidade deve Possuir um Label</option>';
                        }

                    }

                    $select .= '</select></div></div>';

                    $retorno[] = $select;

                }
                elseif ($parameter->type == 'Entidade') {

                    $query = $parameter->query;

                    $itens = $app['db']->fetchAll($query);

                    $select = '<div class="form-group">
                                        <label class="control-label col-sm-2" for="' . $parameter->name . '">' . $nomeItem . ':</label>
                                        <div class="col-sm-10">
                                        <select class="selectpicker" required title="Nada Selecionado" multiple data-actions-box="true"
                                        data-width="100%" id="' . $parameter->name . '" name="' . $parameter->name . '[]" data-live-search="true">';

                    foreach ($itens as $k => $item) {

                        $tables = $app['tables.repository']->find($parametro->getTabela());
                        $colunas = $app['columns.repository']->findBy(['tabela' => $tables]);

                        $colunaLabel = array_filter($colunas, function ($item) {
                            return true == $item->isLabel();
                        });

                        $colunaChavePrimaria = array_filter($colunas, function ($item) {
                            return true == $item->isChavePrimaria();
                        });

                        $nome = $index = $valor = null;

                        if ($parametro->getColuna()) {
                            $nome = $valor = $item[$parametro->getColuna()->getNome()];
                        } else {

                            if (!empty($colunaChavePrimaria)) {
                                $index = current($colunaChavePrimaria)->getNome();
                                if (isset($item[$index])) {
                                    $valor = $item[$index];
                                }
                            }

                            if (!empty($colunaLabel)) {
                                $label = current($colunaLabel)->getNome();
                            } else {
                                $label = $colunas[0]->getNome();
                            }

                            if (!isset($item[$index]) && !isset($item[$label])) {
                                $nome = strtoupper($item[$parametro->getNome()]);
                            } elseif (isset($item[$index]) && !isset($item[$label])) {
                                $nome = strtoupper($item[$index]);
                            } elseif (isset($item[$index]) && isset($item[$label])) {
                                $nome = strtoupper($item[$index]);
                            } elseif (!isset($item[$index]) && isset($item[$label])) {
                                $nome = strtoupper($item[$label]);
                            }

                            if (empty($item[$parametro->getNome()]) && empty($valor)) {
                                if (isset($item[$label])) {
                                    $valor = $item[$label];
                                }
                            }

                            if (!$valor) {
                                $valor = $item[$parametro->getNome()];
                            }
                        }

                        $select .= '<option value="' . $valor . '"';

                        if (!empty($requestedValue)) {

                            $selectedV = $requestedValue[$parametro->getNome()];

                            if (is_array($selectedV)) {
                                foreach ($selectedV as $itemV) {
                                    if ($valor == $itemV) {
                                        $select .= 'selected';
                                    }
                                }
                            }

                            if ($valor == $selectedV) {
                                $select .= 'selected';
                            }
                        }

                        $select .= '>' . $nome . '</option>';
                    }

                    $select .= '</select></div></div>';

                    $retorno[] = $select;

                }

                elseif ($parameter->type == 'Texto') {
                    $retorno[] = self::renderInput($parameter, $nomeItem, $requestedValue);
                }

            }
            else {
                $retorno[] = self::renderInput($parameter, $nomeItem, $requestedValue);

            }

        }

        return $retorno;
    }

    public static function renderInput($parameter, $nomeItem, $requestedValue = null)
    {
        $format = $request = null;
        $retorno = [];

        if ($parameter->column && $parameter->column->format) {
            $format = $parameter->column->format->id;
        } else {
            $format = $parameter->type;
        }

        if (!empty($requestedValue)) {
            $request = $requestedValue[$parameter->name] ?? false;
        }

        $nome = $parameter->column
                ? $parameter->column->format->name ?? ''
                : $parameter->name;

                //dd($format);

        switch ($format) {

            case Format::TYPE_BOOLEAN_SITUATION :

            case Format::TYPE_BOOLEAN_CONFIRMATION :

                $retorno = '<div class="form-group row">
                                        <label class="col-form-label col-sm-2" for="' . $parameter->name . '">' . $nomeItem  . ':</label>
                                        <div class="col-sm-10">
                                            <input type="checkbox" class="js-switch" name="' . $parameter->name . '" value="' . $request . '"/>
                                        </div>
                                      </div>';
                break;

            case 'CASA' :
                $select = '<div class="form-group">
                                        <label class="control-label col-sm-2" for="' . $parameter->name . '">' . $nome . ':</label>
                                        <div class="col-sm-10">
                                        <select class="selectpicker" required title="Nada Selecionado" multiple data-actions-box="true"
                                        data-width="100%" id="' . $parameter->name . '" name=' . $parameter->name . '[]>';

                $selected = null;

                $select .= '<option value="1"';
                if (!empty($requestedValue)) {

                    $selectedV = $requestedValue[$parametro->getNome()];

                    if (is_array($selectedV)) {
                        foreach ($selectedV as $itemV) {
                            if (1 == $itemV) {
                                $select .= 'selected';
                            }
                        }
                    }

                    if (1 == $request) {
                        $select .= 'selected';
                    }
                }
                $select .= '>Sim</option>';

                $select .= '<option value="0"';

                if (!empty($requestedValue)) {

                    $selectedV = $requestedValue[$parametro->getNome()];

                    if (is_array($selectedV)) {
                        foreach ($selectedV as $itemV) {
                            if (0 == $itemV) {
                                $select .= 'selected';
                            }
                        }
                    }

                    if (0 == $request) {
                        $select .= 'selected';
                    }
                }
                $select .= '>Nao</option>';

                $select .= '</select></div></div>';
                $retorno = $select;
                break;
            case Format::TYPE_DATE :

                $todo = '<div class="form-group">
                                        <label class="control-label col-sm-2" for="' . $parameter->name . '">' . $nome . ':</label>
                                        <div class="col-sm-10">
                                            <div class="input-daterange input-group" id="datepicker">
                                                <input type="text" class="input-sm form-control" name="' . $parameter->name . '-inicio" />
                                                <span class="input-group-addon">Até</span>
                                                <input type="text" class="input-sm form-control" name="' . $parameter->name . '-fim" />
                                            </div>
                                        </div>
                                      </div>';

                $retorno = '<div class="form-group">
                                        <label class="control-label col-sm-2" for="' . $parametro->getNome() . '">' . $nome . ':</label>
                                        <div class="col-sm-10">
                                            <input type="text" required class="form-control datepicker" name="' . $parametro->getNome() . '" value="' . $request . '"/>
                                        </div>
                                      </div>';
                break;
            case Format::TYPE_DATE_TIME :

                $retorno = '<div class="form-group">
                                        <label class="control-label col-sm-2" for="' . $parametro->getNome() . '">' . $parametro->getColuna()->getNomeFormatado() . ':</label>
                                        <div class="col-sm-10">
                                            <input type="text" required class="form-control datepicker2" name="' . $parametro->getNome() . '" value="' . $request . '"/>
                                        </div>
                                      </div>';
                break;
            default :
                $retorno = '<div class="form-group row">
                                        <label class="col-form-label col-sm-2" for="' . $parameter->name . '">' . $nomeItem  . ':</label>
                                        <div class="col-sm-10">
                                            <input type="text" required class="form-control" name="' . $parameter->name . '" value="' . $request . '"/>
                                        </div>
                                      </div>';
                break;

        }

        return $retorno;
    }
}
