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
            return abort(403, 'Acesso negado.');
        }

        $courses = Course::orderBy('title');

        if($request->filled('search')) {
            $search = $request->get('search');
            $courses->where('id', $search)
            ->orWhere('title', 'LIKE', "%$search%")
            ->orWhere('description', 'LIKE', "%$search%");
        }

        $quantity = $courses->count();

        $courses = $courses->paginate();

        foreach ($request->all() as $key => $value) {
            $courses->appends($key, $value);
        }

        return view('training.courses.index', compact('courses', 'quantity'));
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

        $engineer = null;

        if($request->filled('engineer_id')) {
            $engineer = $request->get('engineer_id');
        }

        $data['engineer_id'] = $engineer;

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

        $engineer = null;

        if($request->filled('engineer_id')) {
            $engineer = $request->get('engineer_id');
        }

        $data['engineer_id'] = $engineer;

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

          if($cursos->teams->isNotEmpty()) {
            return response()->json([
              'success' => false,
              'message' => 'Curso não removido, existem turmas vinculadas ao curso.'
            ]);
          }

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
