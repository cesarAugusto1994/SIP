<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report\{Table, Column, Format, Query, Parameter};
use DB;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tables = Table::paginate();
        return view('reports.tables.index', compact('tables'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $schema = env('DB_DATABASE');

        $tables = [];

        $sql = "
        SELECT *
          FROM INFORMATION_SCHEMA.TABLES
          WHERE TABLE_SCHEMA = '{$schema}';
        ";

        $result = DB::connection('mysql_information')->select($sql);

        foreach ($result as $key => $item) {

            $table = Table::where('name', $item->TABLE_NAME)->first();

            if($table) {
                continue;
            }

            $tables[] = [
              'name' => $item->TABLE_NAME,
              'database' => $item->TABLE_SCHEMA,
            ];
        }

        return view('reports.tables.create', compact('tables'));
    }

    public function createQuery($id)
    {
        $table = Table::uuid($id);
        return view('reports.tables.query', compact('table'));
    }

    public function storeQuery($id, Request $request)
    {
        $table = Table::uuid($id);

        $data = $request->request->all();

        //$table = $request->get('table');
        $select = $request->get('select');
        $crud = $request->get('crud');
        $inner = $request->get('inner');
        $where = $request->get('where');
        $groupBy = $request->get('groupBy');
        $orderBy = $request->get('orderBy');
        $limit = $request->get('limit');

        $arrayColumns = [];

        foreach ($table->columns as $column) {
            $arrayColumns[$column->id] = $column->name;
        }

        if(in_array('all', $select)) {
          $columns = $table->columns;
        } else {
          $columns = Column::whereIn('uuid', $select)->get();
        }

        $alias = $table->name;

        if ($crud == 'Selecionar') {

            $queryString = " SELECT ";

            if (!empty($inner)) {

                $queryString .= " * ";

            } elseif (count($select) == count($arrayColumns)) {

                $queryString .= $alias . ".* ";

            } else {

                foreach ($columns as $column) {
                    $queryString .= $alias . '.' . $column->name . ', ' . PHP_EOL;
                }

                $queryString = substr($queryString, 0, -3);

                $queryString .= PHP_EOL;
            }

            $queryString .= " FROM {$table->database}.{$table->name} {$alias}" . PHP_EOL;

            if (!empty($inner)) {

                foreach ($inner as $key => $item) {

                    //$coluna = $app['columns.repository']->find($item);
                    //$table = $app['tables.repository']->find($coluna->getTabela());

                    $queryString .= " INNER JOIN " . $table->getNome() . " " . $table->getNome(
                        ) . " USING (" . $coluna->getNome() . ")" . PHP_EOL;
                }

            }

            $queryString .= PHP_EOL;

            if (!empty($where)) {

                $stmt = " WHERE ";

                if (count($where) > 1) {
                    $queryString .= " {$stmt} 1 = 1 " . PHP_EOL;
                }

                foreach ($where as $key => $item) {

                    if (0 == $key && 1 < count($where)) {
                        $stmt = " AND ";
                    }

                    $column = Column::uuid($item);

                    $valor = $column->name;

                    $isInteiro = false;

                    if ($column->tableReference) {

                        /*$hasPk = $column->tableReference->filter(funcion($column, $k) {
                            return $column->is_primary_key === true;
                        });
                        if ($hasPk) {
                            $isInteiro = true;
                        }*/
                    }

                    //dd($where);

                    if ($column->format && $column->format->name == Format::TYPE_DATE_TIME) {
                        $queryString .= " {$stmt} " . $alias . '.' . $column->name . " BETWEEN ':{$valor}: 00:00:00' AND ':{$valor}: 23:59:59 '" . PHP_EOL;
                    } elseif ($column->format && $column->format->name == Format::TYPE_DATE) {
                        $queryString .= " {$stmt} " . $alias . '.' . $column->name . " BETWEEN ':{$valor}:' AND ':{$valor}:'" . PHP_EOL;
                    } elseif ($isInteiro ||
                        $column->is_primary_key ||
                        $column->is_label ||
                        $column->type == Format::DATA_TYPE_INT ||
                        $column->format && in_array(
                            $column->format->name,
                            [Format::TYPE_BOOLEAN_SITUATION, Format::TYPE_BOOLEAN_CONFIRMATION]
                        )
                    ) {
                        $queryString .= " {$stmt}  {$alias}.{$column->name} IN (:{$valor}:)" . PHP_EOL;
                    } else {
                        $queryString .= " {$stmt}  {$alias}.{$column->name} IN (':" . $valor . ":')" . PHP_EOL;
                    }

                }

            }

            if (!empty($groupBy)) {

                $queryString .= " GROUP BY ";

                foreach ($groupBy as $item) {
                    $column = Column::uuid($item);
                    $queryString .= $alias . '.' . $column->name . ', ';
                }

                $queryString = substr($queryString, 0, -2) . PHP_EOL;
            }

            if (!empty($orderBy)) {

                $queryString .= " ORDER BY ";

                foreach ($orderBy as $item) {
                    $column = Column::uuid($item);
                    $queryString .= $alias . '.' . $column->name . ', ';
                }

                $queryString = substr($queryString, 0, -2) . PHP_EOL;

            }

            if (!empty($limit) && $limit != 'all') {
                $queryString .= " LIMIT " . $limit;
            }

        }

        else if ($crud == 'insert') {

            $queryString = " INSERT INTO {$table->getSchema()}.{$table->getNome()} SET ";

            foreach ($select as $item) {

                /**
                 * @var Colunas $coluna
                 */
                $coluna = $app['columns.repository']->findOneBy(['tabela' => $table, 'nome' => $arrayColumns[$item]]);

                if ($coluna->isChavePrimaria()) {
                    continue;
                }

                $queryString .=  "{$arrayColumns[$item]} = ':{$arrayColumns[$item]}:', ";
            }

            $queryString = substr($queryString, 0, -2);
        }

        else {

            $queryString = " UPDATE {$table->getSchema()}.{$table->getNome()} SET ";

            foreach ($select as $item) {

                /**
                 * @var Colunas $coluna
                 */
                $coluna = $app['columns.repository']->findOneBy(['tabela' => $table, 'nome' => $arrayColumns[$item]]);

                $queryString .=  "{$arrayColumns[$item]} = ':{$arrayColumns[$item]}:', ";
            }

            $queryString = substr($queryString, 0, -2);

            if (!empty($where)) {

                $stmt = " WHERE ";

                if (1 == count($where)) {
                    //$queryString .= " {$stmt} 1 = 1 " . PHP_EOL;
                }

                foreach ($where as $key => $item) {

                    if (0 > $key && 1 < count($where)) {
                        $stmt = " AND ";
                    }

                    $valor = $arrayColumns[$item];

                    if (is_array($valor)) {
                        $valor = implode(',', $arrayColumns[$item]);
                    }

                    /**
                     * @var Colunas $coluna
                     */
                    $coluna = $app['columns.repository']->findOneBy(['tabela' => $table, 'nome' => $arrayColumns[$item]]);

                    $isInteiro = false;

                    if ($coluna->getTabelaRef()) {
                        /**
                         * @var Colunas $colunaRef
                         */
                        $colunaRef = $app['columns.repository']->findOneBy(
                            ['tabela' => $coluna->getTabelaRef(), 'chavePrimaria' => true]
                        );
                        if ($colunaRef) {
                            $isInteiro = true;
                        }
                    }

                    if ($coluna->getFormato() && $coluna->getFormato()->getNome() == Colunas::TIPO_DATA_HORA) {
                        $queryString .= " {$stmt} " . $arrayColumns[$item] . " BETWEEN ':{$valor}: 00:00:00' AND ':{$valor}: 23:59:59 '" . PHP_EOL;
                    } elseif ($coluna->getFormato() && $coluna->getFormato()->getNome() == Colunas::TIPO_DATA) {
                        $queryString .= " {$stmt} " . $arrayColumns[$item] . " BETWEEN ':{$valor}:' AND ':{$valor}:'" . PHP_EOL;
                    } elseif ($isInteiro ||
                        $coluna->isChavePrimaria() ||
                        $coluna->isLabel() && !is_numeric($valor) ||
                        $coluna->getTipo() == Colunas::DATA_TYPE_INT ||
                        $coluna->getFormato() && in_array(
                            $coluna->getFormato()->getNome(),
                            [Colunas::TIPO_BOOLEAN, Colunas::TIPO_BOLEAN_ATIVO_INATIVO]
                        )
                    ) {
                        $queryString .= " {$stmt}  {$arrayColumns[$item]} IN (:{$valor}:)" . PHP_EOL;
                    } else {
                        $queryString .= " {$stmt}  {$arrayColumns[$item]} IN (':" . $valor . ":')" . PHP_EOL;
                    }

                }

            }

        }

        $name = $table->name . ' ' . strtoupper($crud) . ' v' . date('dmYHis');

        $query = Query::create([
          'name' => $request->get('name') ?? $name,
          'label' => $request->get('name'),
          'description' => null,
          'query' => $queryString,
          'table_id' => $table->id,
          'type' => $crud,
          'is_query_string' => false,
        ]);


        if (!empty($where)) {

            foreach ($where as $key => $item) {

                $type = 'text';

                $refQueryString = "";
                $tableRefId = null;

                $column = Column::uuid($item);

                if ($column->is_primary_key) {

                    $type = 'Texto';

                } elseif ($column->table_reference_id) {

                    $type = 'Entidade';
                    $tableRef = $column->tableReference;
                    $refQueryString = "SELECT * FROM {$tableRef->database}.{$tableRef->name}";
                    $tableRefId = $tableRef->id;

                } elseif ($column->format && $column->format->id == Format::TYPE_ENUM) {

                    $type = 'Entidade';
                    $tableRef = $column->tableReference;
                    $refQueryString = "SELECT DISTINCT {$column->name} FROM {$tableRef->database}.{$tableRef->name}";
                    $tableRefId = $tableRef->id;

                } else {

                    $type = 'Texto';

                }

                $dat = [
                  'column_id' => $column->id,
                  'name' => $column->name,
                  'query' => $refQueryString,
                  'table_id' => $tableRefId,
                  'type' => $type,
                  'parameter_id' => $column->id,
                  'query_id' => $query->id
                ];

                //dd($dat);

                Parameter::create($dat);

            }
        }

        return redirect()->route('tables.show', $table->uuid);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->request->all();

        $schema = env('DB_DATABASE');
        $data['database'] = $schema;

        Table::create($data);
        return redirect()->route('tables.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $table = Table::uuid($id);
        return view('reports.tables.show', compact('table'));
    }

    public function importColumns($id)
    {
        $table = Table::uuid($id);

        $name = $table->name;
        $id = $table->id;

        $columns = [];

        $schema = env('DB_DATABASE');

        $sql = "
          SELECT
              COLUMN_NAME                     name,
              DATA_TYPE                       type,
              IF(COLUMN_KEY = 'PRI', 1, 0) AS is_primary_key
            FROM
              information_schema.COLUMNS
            WHERE TABLE_SCHEMA = '{$schema}' AND TABLE_NAME = '{$name}';
        ";

        $result = DB::connection('mysql_information')->select($sql);

        foreach ($result as $key => $item) {

            $column = Column::where('name', $item->name)->where('table_id', $table->id)->first();

            if($column) {
                continue;
            }

            Column::create([
              'name' => $item->name,
              'table_id' => $table->id,
              'type' => $item->type,
              'is_primary_key' => (boolean)$item->is_primary_key,
            ]);
        }

        return back();

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
