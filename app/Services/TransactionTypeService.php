<?php
namespace App\Services;

use Illuminate\Http\Request;

class TransactionTypeService
{

    protected $transactionTypeRepository;

    public function __construct(
        TransactionTypeRepositoryInterface $transactionTypeRepository
    ) {
      $this->transactionTypeRepository = $transactionTypeRepository;  
    }

    public function saveTransactionType(Request $request)
    {
        // $title = "Error";
        // $mensaje = "Error desconocido";
        // $status = "error";

        // try {

        //     $transactionType = new TransactionType();
        //     $transactionType->name = $request->name;
        //     $transactionType->description = $request->description;
        //     $transactionType->status = 'active';
        //     if ($transactionType->save()) {
        //         $title = "Correcto";
        //         $mensaje = "El tipo de transacción se registró correctamente";
        //         $status = "success";
        //     }

        // } catch (ValidationException $e) {
        //     $title = "Error";
        //     $mensaje = $e->getMessage();
        //     $status = "error";
        // } catch (Exception $e) {
        //     $title = "Error";
        //     $mensaje = $e->getMessage();
        //     $status = "error";
        // }

        // $transactionsType = TransactionType::get();

        // return response()->json(["view"=>view('transactionType.table.tableTransactionType', compact('transactionsType'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);
    }

    public function updateTransactionType(Request $request)
    {
        // $title = "Error";
        // $mensaje = "Error desconocido";
        // $status = "error";

        // try {

        //     $transactionType = TransactionType::find($request->id);
        //     $transactionType->name = $request->name;
        //     $transactionType->description = $request->description;
        //     // $transactionType->status = $request->status;

        //     if ($transactionType->save()) {
        //         $title = "Correcto";
        //         $mensaje = "Se actualizó el tipo de transacción correctamente";
        //         $status = "success";
        //     } else {
        //         $title = "Error";
        //         $mensaje = "Hubo un error al actualizar el tipo de transacción";
        //         $status = "error";
        //     }

        // } catch (ValidationException $e) {
        //     $title = "Error";
        //     $mensaje = $e->getMessage();
        //     $status = "error";
        // } catch (Exception $e) {
        //     $title = "Error";
        //     $mensaje = "Verificar los datos del registro";
        //     $status = "error";
        // }

        // $transactionsType = TransactionType::get();

        // return response()->json(["view"=>view('transactionType.table.tableTransactionType', compact('transactionsType'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);
    }

    public function deleteTransactionType(Request $request)
    {
        // $title = "Error";
        // $mensaje = "Error desconocido";
        // $status = "error";
        // $transactionType = TransactionType::find($request->id);
        // if ($transactionType == null) {
        //     $title = "Error";
        //     $mensaje = "Hubo un error con su tipo de transacción";
        //     $status = "error";
        // }
        // try {
        //     if ($transactionType->delete()) {
        //         $title = "Correcto";
        //         $mensaje = "El tipo de transacción se elimninó correctamente";
        //         $status = "success";
        //     } else {
        //         $title = "Error";
        //         $mensaje = "No se pudo eliminar el tipo de transacción";
        //         $status = "error";
        //     }
        // } catch (Exception $e) {
        //     $title = "Error";
        //     $mensaje = $e->getMessage();
        //     $status = "error";
        // }

        // $transactionsType = TransactionType::get();

        // return response()->json(["view"=>view('transactionType.table.tableTransactionType', compact('transactionsType'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);
    }
}