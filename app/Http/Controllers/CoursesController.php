<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Training\Course;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Helper;
use Auth;

class CoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!Auth::user()->hasPermission('view.cursos')) {
            return abort(403, 'Unauthorized action.');
        }

        $courses = Course::paginate();

        $table = (new \Okipa\LaravelTable\Table)->model(Course::class)
        ->request($request)
        ->routes([
            'index'      => ['name' => 'courses.index'],
            'create'     => ['name' => 'courses.create'],
            'edit'       => ['name' => 'courses.edit'],
            'destroy'    => ['name' => 'courses.destroy'],
            'show'    => ['name' => 'courses.show'],
        ])
        ->rowsNumber(50) // or set `false` to get all the items contained in database
        ->rowsNumberSelectionActivation(false);
        $table->column('title')->title('Titulo')->sortable()->searchable();
        $table->column('description')->title('Descrição')->searchable();
        $table->column('workload')->title('Carga Horária')->sortable()->searchable();

        return view('training.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->hasPermission('create.cursos')) {
            return abort(403, 'Unauthorized action.');
        }

        return view('training.courses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Auth::user()->hasPermission('create.cursos')) {
            return abort(403, 'Unauthorized action.');
        }

        $data = $request->request->all();

        $data['created_by'] = Auth::user()->id;

        $request->validate([
          'title' => 'required|string|max:255|unique:courses',
          'description' => 'required|string',
          'workload' => 'required|integer|min:1',
        ]);

        Course::create($data);

        Helper::drop('courses');

        notify()->flash('Curso Adicionado!', 'success', [
          'text' => 'Novo curso adicionado com sucesso.'
        ]);

        return redirect()->route('courses.index');
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
        if(!Auth::user()->hasPermission('edit.cursos')) {
            return abort(403, 'Unauthorized action.');
        }

        $course = Course::uuid($id);
        return view('training.courses.edit', compact('course'));
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
        if(!Auth::user()->hasPermission('edit.cursos')) {
            return abort(403, 'Unauthorized action.');
        }

        $data = $request->request->all();

        $curso = Course::uuid($id);

        $request->validate([
          'title' => 'required|string|max:255|unique:courses,title,'.$curso->id,
          'description' => 'required|string',
          'workload' => 'required|integer|min:1',
        ]);

        $curso->update($data);

        Helper::drop('courses');

        notify()->flash('Curso Atualizado!', 'success', [
          'text' => 'Curso atualizado com sucesso.'
        ]);

        return redirect()->route('courses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

          $cursos = Course::uuid($id);
          $cursos->delete();

          Helper::drop('courses');

          return response()->json([
            'success' => true,
            'message' => 'Curso removido com sucesso.'
          ]);

        } catch(\Exception $e) {
          return response()->json([
            'success' => false,
            'message' => $e->getMessage()
          ]);
        }
    }
}
