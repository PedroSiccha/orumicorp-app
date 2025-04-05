<?php

namespace App\Http\Controllers;

use App\Models\CategoryFolder;
use App\Http\Controllers\Controller;
use App\Services\CategoryFolderService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryFolderController extends Controller
{

    protected $categoryFolderService;

    public function __construct(CategoryFolderService $categoryFolderService) {
        $this->categoryFolderService = $categoryFolderService;
    }
    
    public function saveCategoryFolder(CategoryRequest $request)
    {
        try {
            $data = $this->categoryFolderService->saveCategoryFolder($request);
            $categoryFolders = $data->categoryFolders;
            return response()->json(["view"=>view('categoryFolder.list.listCategoryFolder', compact('categoryFolders'))->render(), "resp"=>$resp]);
        } catch (Exception $e) {
            Log::error("Error en CategoryFolderController: " . $e->getMessage());
            return redirect()->route('home')->with('error', 'No se pudieron cargar las categorías de folder.');
        }
        // $name = $request->name;
        // $title = 'Error';
        // $mensaje = 'Error desconocido';
        // $status = 'error';

        // try {
        //     $categoryFolder = new CategoryFolder();
        //     $categoryFolder->name = $name;
        //     $categoryFolder->status = true;
        //     if ($categoryFolder->save()) {
        //         $title = "Correcto";
        //         $mensaje = "Categoría de folder creado correctamente";
        //         $status = "success";
        //     } else {
        //         $title = 'Error';
        //         $mensaje = 'Error desconocido';
        //         $status = 'error';
        //     }
        // } catch (Exception $e) {
        //     $title = 'Error';
        //     $mensaje = 'Ocurrió un error: '.$e->getMessage();
        //     $status = 'error';
        // }
        // return response()->json(["title" => $title, "text" => $mensaje, "status" => $status]);
    }

}
