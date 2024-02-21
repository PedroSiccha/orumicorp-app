<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Http\Requests\StoreAgentRequest;
use App\Http\Requests\UpdateAgentRequest;
use App\Models\Area;
use App\Models\Premio;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $agents = Agent::where('status', true)->orderBy('lastname')->take(10)->get();
        $areas = Area::where('status', true)->get();
        $premios1 = Premio::where('status', true)->where('type', 1)->get();
        $premios2 = Premio::where('status', true)->where('type', 2)->get();
        return view('agent.index', compact('agents', 'areas', 'premios1', 'premios2'));
    }

    public function searchAgent(Request $request)
    {
        $agent = Agent::where('dni', $request->dni)
                  ->orWhere('code', $request->dni)
                  ->first();

        $name = $agent->name . " " . $agent->lastname;
        return response()->json(["name"=>$name]);
    }

    public function saveAgent(Request $request)
    {
        $resp = 0;

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->dni);
        $user->rol = "AGENTE";
        if ($user->save()) {
            $agent = new Agent();
            $agent->code = $request->code;
            $agent->name = $request->name;
            $agent->lastname = $request->lastname;
            $agent->dni = $request->dni;
            $agent->status = true;
            $agent->area_id = $request->area_id;
            $agent->user_id = $user->id;
            if ($agent->save()) {
                $resp = 1;
            }
        }

        $agents = Agent::where('status', true)->orderBy('lastname')->take(10)->get();

        return response()->json(["view"=>view('agent.list.listAgent', compact('agents'))->render(), "resp"=>$resp]);
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
     * @param  \App\Http\Requests\StoreAgentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAgentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function show(Agent $agent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function edit(Agent $agent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAgentRequest  $request
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAgentRequest $request, Agent $agent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Agent $agent)
    {
        //
    }
}
