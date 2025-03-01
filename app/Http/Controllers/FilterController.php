<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Campaing;
use App\Models\Customers;
use App\Models\CustomerStatus;
use App\Models\Provider;
use Illuminate\Http\Request;

class FilterController extends Controller
{

    public function filterAdvanced(Request $request)
    {
        $filterFor = $request->filterFor;
        $inputName = $request->inputName;
        $statusId = $request->statusId;
        $typeRange = $request->typeRange;
        $dateInit = $request->dateInit;
        $dateEnd = $request->dateEnd;

        // 🔹 Iniciar la consulta
        $query = Customers::with([
            'user', 'agent', 'latestCampaign', 'latestSupplier', 'provider', 'statusCustomer',
            'platform', 'traiding', 'latestComunication', 'latestAssignamet', 'latestDeposit', 'folder'
        ]);

        // 🔹 Aplicar filtros avanzados solo si se ha seleccionado algo
        if (!empty($inputName) && $filterFor !== 'Filtrar Por:') {
            $filterMap = [
                'Cod. Cliente'       => 'code',
                'Correo'             => 'email',
                'Teléfono'           => 'phone',
                'Teléfono Opcional'  => 'optional_phone',
                'Ciudad'             => 'city',
                'País'               => 'country',
                'Comentario'         => 'comment',
                'Folder'             => 'folder.name',
            ];

            if (isset($filterMap[$filterFor])) {
                $query->where($filterMap[$filterFor], 'like', "%$inputName%");
            } elseif ($filterFor == 'Nombre Cliente') {
                $query->where(function ($q) use ($inputName) {
                    $q->where('name', 'like', "%$inputName%")
                    ->orWhere('lastname', 'like', "%$inputName%");
                });
            } elseif ($filterFor == 'Asignado Por' || $filterFor == 'Agente') {
                $query->whereHas('assignaments', function ($q) use ($inputName, $filterFor) {
                    $q->whereHas($filterFor == 'Asignado Por' ? 'assignedBy' : 'agent', function ($a) use ($inputName) {
                        $a->where('name', 'like', "%$inputName%")
                        ->orWhere('lastname', 'like', "%$inputName%");
                    });
                });
            } elseif ($filterFor == 'Proveedor') {
                $query->whereHas('provider', function ($q) use ($inputName) {
                    $q->where('name', $inputName);
                });
            } elseif ($filterFor == 'Última Visita') {
                $query->whereHas('views.agent', function ($a) use ($inputName) {
                    $a->where('name', 'like', "%$inputName%")
                    ->orWhere('lastname', 'like', "%$inputName%");
                });
            }
        }

        // 🔹 Filtrar por estado si está seleccionado
        if (!empty($statusId) && $statusId !== "Seleccione un estado") {
            $query->where('id_status', $statusId);
        }

        // 🔹 Filtrar por rango de fechas
        if (!empty($typeRange) && $typeRange !== "Seleccione Rango:") {
            $rangeMap = [
                "Última Llamada"            => 'comunications.date',
                "Fecha de Ingreso"          => 'date_admission',
                "Fecha de Última Llamada"   => 'comunications.date',
                "Fecha de Última Asignación"=> 'assignaments.date',
            ];

            if (isset($rangeMap[$typeRange]) && !empty($dateInit) && !empty($dateEnd) && $dateInit <= $dateEnd) {
                $column = $rangeMap[$typeRange];

                if (strpos($column, '.') !== false) {
                    $relation = explode('.', $column)[0];
                    $field = explode('.', $column)[1];

                    $query->whereHas($relation, function ($q) use ($field, $dateInit, $dateEnd) {
                        $q->whereBetween($field, [$dateInit, $dateEnd]);
                    });
                } else {
                    $query->whereBetween($column, [$dateInit, $dateEnd]);
                }
            }
        }

        // 🔹 Obtener resultados paginados
        $customers = $query->paginate(10);

        // 🔹 Obtener datos auxiliares
        $agents = Agent::all();
        $campaings = Campaing::all();
        $providers = Provider::all();
        $statusCustomers = CustomerStatus::all();

        // 🔹 Devolver la vista filtrada
        return response()->json([
            "view" => view('cliente.list.listCustomer', compact('customers', 'agents', 'campaings', 'providers', 'statusCustomers'))->render()
        ]);
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
