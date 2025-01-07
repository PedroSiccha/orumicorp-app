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

        $query = Customers::with([
            'user',
            'agent',
            'latestCampaign',
            'latestSupplier',
            'provider',
            'statusCustomer',
            'platform',
            'traiding',
            'latestComunication',
            'latestAssignamet',
            'latestDeposit'
        ]);

        if ($filterFor !== 'Filtrar Por:' || $inputName !== '') {
            if ($filterFor == 'Cod. Cliente') {
                $query->where(function($q) use ($inputName) {
                    $q->where('code', 'like', "%$inputName%");
                });
            }

            if ($filterFor == 'Asignado Por') {
                $query->whereHas('assignaments', function($q) use ($inputName) {
                    $q->whereHas('assignedBy', function($a) use ($inputName) {
                        $a->where('name', 'like', "%$inputName%")->orWhere('lastname', 'like', "%$inputName%");
                    });
                });
            }

            if ($filterFor == 'Proveedor') {
                $query->whereHas('provider', function($q) use ($inputName) {
                    $q->where('name', $inputName);
                });
            }

            if ($filterFor == 'Nombre Cliente') {
                $query->where(function($q) use ($inputName) {
                    $q->where('name', 'like', "%$inputName%")->orWhere('lastname', 'like', "%$inputName%");
                });
            }

            if ($filterFor == 'Correo') {
                $query->where(function($q) use ($inputName) {
                    $q->where('email', 'like', "%$inputName%");
                });
            }

            if ($filterFor == 'Teléfono') {
                $query->where(function($q) use ($inputName) {
                    $q->where('phone', 'like', "%$inputName%");
                });
            }

            if ($filterFor == 'Teléfono Opcional') {
                $query->where(function($q) use ($inputName) {
                    $q->where('optional_phone', 'like', "%$inputName%");
                });
            }

            if ($filterFor == 'Ciudad') {
                $query->where(function($q) use ($inputName) {
                    $q->where('city', 'like', "%$inputName%");
                });
            }

            if ($filterFor == 'País') {
                $query->where(function($q) use ($inputName) {
                    $q->where('country', 'like', "%$inputName%");
                });
            }

            if ($filterFor == 'Agente') {
                $query->whereHas('assignaments', function($q) use ($inputName) {
                    $q->whereHas('agent', function($a) use ($inputName) {
                        $a->where('name', 'like', "%$inputName%")->orWhere('lastname', 'like', "%$inputName%");
                    });
                });
            }

            if ($filterFor == 'Comentario') {
                $query->where(function($q) use ($inputName) {
                    $q->where('comment', 'like', "%$inputName%");
                });
            }

            if ($filterFor == 'Última Visita') {
                $query->whereHas('views', function($q) use ($inputName) {
                    $q->whereHas('agent', function($a) use ($inputName) {
                        $a->where('name', 'like', "%$inputName%")->orWhere('lastname', 'like', "%$inputName%");
                    });
                });
            }

            if ($filterFor == 'N° Depósito') {
                $dataSearch = 'code';
            }

            if ($filterFor == 'Total Depósito') {
                $dataSearch = 'code';
            }

        }

        if ($statusId !== "Seleccione un estado") {
            $query->where('id_status', $statusId);
        }

        if ($typeRange !== "Seleccione Rango:") {

            if ($typeRange == "Última Llamada") {
                if (!empty($dateInit) && !empty($dateEnd) && $dateInit <= $dateEnd) {
                    $query->whereHas('comunications', function ($q) use ($dateInit, $dateEnd) {
                        $q->whereBetween('date', [$dateInit, $dateEnd]);
                    });
                }
            }

            if ($typeRange == "Fecha de Ingreso") {
                $query->whereBetween('date_admission', [$dateInit, $dateEnd]);
            }

            if ($typeRange == "Fecha de Última Llamada") {
                if (!empty($dateInit) && !empty($dateEnd) && $dateInit <= $dateEnd) {
                    $query->whereHas('comunications', function ($q) use ($dateInit, $dateEnd) {
                        $q->whereBetween('date', [$dateInit, $dateEnd]);
                    });
                }
            }

            if ($typeRange == "Fecha de Última Asignación") {
                if (!empty($dateInit) && !empty($dateEnd) && $dateInit <= $dateEnd) {
                    $query->whereHas('assignaments', function ($q) use ($dateInit, $dateEnd) {
                        $q->whereBetween('date', [$dateInit, $dateEnd]);
                    });

                }
            }


            // $query->where('id_status', $statusId);
        }

        $customers = $query->paginate(10);

        $agents = Agent::all();
        $campaings = Campaing::all();
        $providers = Provider::all();
        $statusCustomers = CustomerStatus::all();

        return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers', 'agents', 'campaings', 'providers', 'statusCustomers'))->render()]);

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
