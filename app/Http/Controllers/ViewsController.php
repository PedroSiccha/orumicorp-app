<?php

namespace App\Http\Controllers;

use App\Models\Views;
use App\Http\Controllers\Controller;
use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Exception;
use Svg\Tag\Rect;

class ViewsController extends Controller
{

    public function saveViews(Request $request)
    {
        $user_id = Auth::user()->id;
        $agent = Agent::where('user_id', $user_id)->first();
        $agent_id = $agent->id;
        $client_id = $request->id;

        try {
            $views = new Views();
            $views->agent_id = $agent_id;
            $views->customer_id = $client_id;
            $views->viewed_at = Carbon::now();
            if ($views->save()) {
                echo('Vista Ok');
            }
        } catch (Exception $e) {
            echo($e->getMessage());
        }
    }

    public function getViews(Request $request)
    {
        $client_id = $request->client_id;
        $vistas = Views::with('agent')
                        ->where('customer_id', $client_id)
                        ->get();

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
     * @param  \App\Models\Views  $views
     * @return \Illuminate\Http\Response
     */
    public function show(Views $views)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Views  $views
     * @return \Illuminate\Http\Response
     */
    public function edit(Views $views)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Views  $views
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Views $views)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Views  $views
     * @return \Illuminate\Http\Response
     */
    public function destroy(Views $views)
    {
        //
    }
}
