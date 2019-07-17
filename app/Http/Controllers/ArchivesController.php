<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Folder;
use App\Models\Folder\Archive;
use Storage;
use File;

class ArchivesController extends Controller
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

    public function upload($id, Request $request)
    {
        $data = $request->request->all();

        $folder = Folder::uuid($id);

        $filePath = null;

        foreach ($request->file('files') as $key => $file) {

            $extension = $file->extension();
            $name = $file->getClientOriginalName();
            $path = $file->storeAs($folder->path, $name);

            if($path) {
              $filePath = $path;
            }

            Archive::create([
              'folder_id' => $folder->id,
              'user_id' => $request->user()->id,
              'filename' => $name,
              'path' => $filePath,
              'size' => $file->getSize(),
              'type' => $file->getMimeType(),
              'content' => base64_encode(file_get_contents($file->getRealPath())),
              'extension' => $extension,
            ]);

        }

        return response()->json([
            'success' => true,
            'message' => 'Upload realizado com sucesso.'
        ]);
    }

    public function download($id)
    {
        $archive = Archive::uuid($id);

        if(!Storage::exists($archive->path)) {
            notify()->flash('Arquivo não encontrado', 'error', [
              'text' => 'Download Indisponível: Este arquivo não foi encontrado nesta pasta.'
            ]);
            return back();
        }

        return Storage::download($archive->path);
    }

    public function preview($id)
    {
        $archive = Archive::uuid($id);

        $link = $archive->path;

        $file = Storage::exists($link) ? Storage::get($link) : false;

        if(!$file) {
          $file = null;
        }

        $mimetype = Storage::disk('local')->mimeType($link);

        return response($file, 200)->header('Content-Type', $mimetype);
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
        $archive = Archive::uuid($id);
        $folders = Folder::with('user')->get();
        return view('archives.edit', compact('archive', 'folders'));
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
        try {

          $archive = Archive::uuid($id);

          if(Storage::exists($archive->path)) {
              Storage::delete($archive->path);
          }

          $archive->delete();

          return response()->json([
            'success' => true,
            'message' => 'Documento removido com sucesso.'
          ]);

        } catch(\Exception $e) {
          return response()->json([
            'success' => false,
            'message' => $e->getMessage()
          ]);
        }
    }
}
