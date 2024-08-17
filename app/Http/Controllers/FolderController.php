<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Http\Controllers\Controller;
use App\Models\Customers;
use Exception;
use Illuminate\Http\Request;

class FolderController extends Controller
{

    public function deleteFolder(Request $request)
    {
        $title = 'Error';
        $mensaje = 'Error desconocido';
        $status = 'error';

        try {
            $folder = Folder::find($request->id);
            $folder->status = false;
            $folder->save();

            $title = "Correcto";
            $mensaje = "Actualización correcta";
            $status = "success";

        } catch (Exception $e) {
            $title = 'Error';
            $mensaje = 'Ocurrió un error: '.$e->getMessage();
            $status = 'error';
        }
        $folders = Folder::where('status', 1)->where('category_id', 1)->get();
        return response()->json(["view"=>view('shooter.components.listFolder', compact('folders'))->render(), "title" => $title, "text" => $mensaje, "status" => $status]);

    }

    public function addGroupClientFolder(Request $request)
    {

    }

    public function saveFolder(Request $request)
    {
        $title = 'Error';
        $mensaje = 'Error desconocido';
        $status = 'error';

        try {
            $folder = new Folder();
            $folder->status = true;
            $folder->name = $request->name;
            $folder->category_id = $request->categoryId;
            $folder->save();

            $title = "Correcto";
            $mensaje = "Folder creado correctamente";
            $status = "success";

        } catch (Exception $e) {
            $title = 'Error';
            $mensaje = 'Ocurrió un error: '.$e->getMessage();
            $status = 'error';
        }
        $folders = Folder::where('status', 1)->where('category_id', 1)->get();
        return response()->json(["view"=>view('shooter.components.listFolder', compact('folders'))->render(), "title" => $title, "text" => $mensaje, "status" => $status]);
    }

    public function addClientFolder(Request $request)
    {
        $title = 'Error';
        $mensaje = 'Error desconocido';
        $status = 'error';

        try {

            $customer = Customers::where('code', $request->codeClient)
                                    ->first();

            $customer->folder_id = $request->folderId;
            if ($customer->save()) {
                $title = "Correcto";
                $mensaje = "Cliente asignado correctamente";
                $status = "success";
            }

        } catch (Exception $e) {
            $title = 'Error';
            $mensaje = 'Ocurrió un error: '.$e->getMessage();
            $status = 'error';
        }

        // $folders = Folder::where('status', 1)->where('category_id', 1)->get();
        $clients = Customers::where('status', 1)->where('folder_id', $request->folderId)->get();
        // return response()->json(["view"=>view('shooter.components.listFolder', compact('folders'))->render(), "title" => $title, "text" => $mensaje, "status" => $status]);
        return response()->json(["view"=>view('shooter.components.listClient', compact('clients'))->render(), "title" => $title, "text" => $mensaje, "status" => $status]);

    }

    public function moveFolder(Request $request)
    {
        $title = 'Error';
        $mensaje = 'Error desconocido';
        $status = 'error';

        try {
            $folder = Folder::find($request->folderId);
            $folder->category_id = $request->categoryId;
            if ($folder->save()) {
                $title = "Correcto";
                $mensaje = "Folder movido correctamente";
                $status = "success";
            }
        } catch (Exception $e) {
            $title = 'Error';
            $mensaje = 'Ocurrió un error: '.$e->getMessage();
            $status = 'error';
        }

        $folders = Folder::where('status', 1)->where('category_id', 1)->get();
        return response()->json(["view"=>view('shooter.components.listFolder', compact('folders'))->render(), "title" => $title, "text" => $mensaje, "status" => $status]);
    }

    public function editFolder(Request $request)
    {
        $title = 'Error';
        $mensaje = 'Error desconocido';
        $status = 'error';
        $idCategory = 0;

        try {
            $folder = Folder::find($request->folderId);
            $idCategory = $folder->category_id;
            $folder->name = $request->name;
            if ($folder->save()) {
                $title = "Correcto";
                $mensaje = "Nombre cambiado";
                $status = "success";
            }
        } catch (Exception $e) {
            $title = 'Error';
            $mensaje = 'Ocurrió un error: '.$e->getMessage();
            $status = 'error';
        }

        $folders = Folder::where('status', 1)->where('category_id', $idCategory)->get();
        return response()->json(["view"=>view('shooter.components.listFolder', compact('folders'))->render(), "title" => $title, "text" => $mensaje, "status" => $status]);
    }

    public function destroy(Folder $folder)
    {
        //
    }
}
