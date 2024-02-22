<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\Premio;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customers::where('status', true)->orderBy('date_admission')->take(10)->get();
        $premios1 = Premio::where('status', true)->where('type', 1)->get();
        $premios2 = Premio::where('status', true)->where('type', 2)->get();
        $roles = Role::get();
        return view('cliente.index', compact('customers', 'premios1', 'premios2', 'roles'));
    }

    public function saveCustomer(Request $request)
    {
        $resp = 0;
        $role = Role::find($request->rol_id);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->dni);
        if ($user->save()) {
            $user->assignRole($role);
            $client = new Customers();
            $client->code = $request->code;
            $client->name = $request->name;
            $client->lastname = $request->lastname;
            $client->dni = $request->dni;
            $client->date_admission = Carbon::now();
            $client->status = true;
            $client->user_id = $user->id;
            if ($client->save()) {
                $resp = 1;
            }
        }

        $customers = Customers::where('status', true)->orderBy('date_admission')->take(10)->get();

        return response()->json(["view"=>view('cliente.list.listCustomer', compact('customers'))->render(), "resp"=>$resp]);
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
