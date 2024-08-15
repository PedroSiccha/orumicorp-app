<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\CategoryFolder;
use App\Models\Customers;
use App\Models\Folder;
use App\Models\Premio;
use App\Models\Shooter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShooterController extends Controller
{

    public function index()
    {
        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();
        $roles = $user->getRoleNames()->first();
        $agent = Agent::where('user_id', $user_id)->first();
        $dataUser = $agent;


        $agent = Agent::where('user_id', $user_id)->first();
        $premios1 = Premio::where('status', true)->where('type', 1)->get();
        $premios2 = Premio::where('status', true)->where('type', 2)->get();
        $rouletteSpin = $agent->number_turns ?: 0;
        $clients = Customers::where('id_status', 1)->with(['latestComunication', 'latestCampaign', 'latestSupplier'])->get();

        $shooter = Shooter::where('status', 1)->with('folder')->first();
        $folders = Folder::where('status', 1)->get();

        return view('shooter.index', compact('premios1', 'premios2','rouletteSpin', 'dataUser', 'clients', 'shooter', 'folders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function administrarShoter()
    {
        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();
        $roles = $user->getRoleNames()->first();
        $agent = Agent::where('user_id', $user_id)->first();
        $dataUser = $agent;


        $agent = Agent::where('user_id', $user_id)->first();
        $premios1 = Premio::where('status', true)->where('type', 1)->get();
        $premios2 = Premio::where('status', true)->where('type', 2)->get();
        $rouletteSpin = $agent->number_turns ?: 0;

        $categoryFolders = CategoryFolder::where('status', 1)->get();
        $folders = Folder::where('status', 1)->where('category_id', 1)->get();

        return view('shooter.details.index', compact('premios1', 'premios2','rouletteSpin', 'dataUser', 'categoryFolders', 'folders'));
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
