<?php

namespace App\Http\Controllers;

use App\Models\CategoryFolder;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class CategoryFolderController extends Controller
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveCategoryFolder(Request $request)
    {
        $name = $request->name;
        $title = 'Error';
        $mensaje = 'Error desconocido';
        $status = 'error';

        try {
            $categoryFolder = new CategoryFolder();
            $categoryFolder->name = $name;
            $categoryFolder->status = true;
            if ($categoryFolder->save()) {
                $title = "Correcto";
                $mensaje = "Categoría de folder creado correctamente";
                $status = "success";
            } else {
                $title = 'Error';
                $mensaje = 'Error desconocido';
                $status = 'error';
            }
        } catch (Exception $e) {
            $title = 'Error';
            $mensaje = 'Ocurrió un error: '.$e->getMessage();
            $status = 'error';
        }
        return response()->json(["title" => $title, "text" => $mensaje, "status" => $status]);
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
     * @param  \App\Models\CategoryFolder  $categoryFolder
     * @return \Illuminate\Http\Response
     */
    public function show(CategoryFolder $categoryFolder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CategoryFolder  $categoryFolder
     * @return \Illuminate\Http\Response
     */
    public function edit(CategoryFolder $categoryFolder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CategoryFolder  $categoryFolder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CategoryFolder $categoryFolder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CategoryFolder  $categoryFolder
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategoryFolder $categoryFolder)
    {
        //
    }
}
