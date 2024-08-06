<?php

namespace App\Http\Controllers;

use App\Models\TransactionType;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TransactionTypeController extends Controller
{

    public function saveTransactionType(Request $request)
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";

        try {

            $transactionType = new TransactionType();
            $transactionType->name = $request->name;
            $transactionType->description = $request->description;
            $transactionType->status = 'active';
            if ($transactionType->save()) {
                $title = "Correcto";
                $mensaje = "El tipo de transacción se registró correctamente";
                $status = "success";
            }

        } catch (ValidationException $e) {
            $title = "Error";
            $mensaje = $e->getMessage();
            $status = "error";
        } catch (Exception $e) {
            $title = "Error";
            $mensaje = $e->getMessage();
            $status = "error";
        }

        $transactionsType = TransactionType::get();

        return response()->json(["view"=>view('transactionType.table.tableTransactionType', compact('transactionsType'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);

    }

    public function updateTransactionType(Request $request)
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";

        try {

            $transactionType = TransactionType::find($request->id);
            $transactionType->name = $request->name;
            $transactionType->description = $request->description;
            // $transactionType->status = $request->status;

            if ($transactionType->save()) {
                $title = "Correcto";
                $mensaje = "Se actualizó el tipo de transacción correctamente";
                $status = "success";
            } else {
                $title = "Error";
                $mensaje = "Hubo un error al actualizar el tipo de transacción";
                $status = "error";
            }

        } catch (ValidationException $e) {
            $title = "Error";
            $mensaje = $e->getMessage();
            $status = "error";
        } catch (Exception $e) {
            $title = "Error";
            $mensaje = "Verificar los datos del registro";
            $status = "error";
        }

        $transactionsType = TransactionType::get();

        return response()->json(["view"=>view('transactionType.table.tableTransactionType', compact('transactionsType'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);

    }

    public function deleteTransactionType(Request $request)
    {
        $title = "Error";
        $mensaje = "Error desconocido";
        $status = "error";
        $transactionType = TransactionType::find($request->id);
        if ($transactionType == null) {
            $title = "Error";
            $mensaje = "Hubo un error con su tipo de transacción";
            $status = "error";
        }
        try {
            if ($transactionType->delete()) {
                $title = "Correcto";
                $mensaje = "El tipo de transacción se elimninó correctamente";
                $status = "success";
            } else {
                $title = "Error";
                $mensaje = "No se pudo eliminar el tipo de transacción";
                $status = "error";
            }
        } catch (Exception $e) {
            $title = "Error";
            $mensaje = $e->getMessage();
            $status = "error";
        }

        $transactionsType = TransactionType::get();

        return response()->json(["view"=>view('transactionType.table.tableTransactionType', compact('transactionsType'))->render(), "title"=>$title, "text"=>$mensaje, "status"=>$status]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TransactionType  $transactionType
     * @return \Illuminate\Http\Response
     */
    public function show(TransactionType $transactionType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TransactionType  $transactionType
     * @return \Illuminate\Http\Response
     */
    public function edit(TransactionType $transactionType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TransactionType  $transactionType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TransactionType $transactionType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TransactionType  $transactionType
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransactionType $transactionType)
    {
        //
    }
}
