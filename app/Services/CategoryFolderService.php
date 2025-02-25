<?php
namespace App\Services;
class CategoryFolderService
{
    public function saveCategoryFolder($request)
    {
        DB::beginTransaction();
        try {
            $categoryFolder = $this->categoryFolderRepository->saveCategoryFolder($request);
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
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
}