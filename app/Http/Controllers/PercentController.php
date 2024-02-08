<?php

namespace App\Http\Controllers;

use App\Models\Percent;
use App\Http\Requests\StorePercentRequest;
use App\Http\Requests\UpdatePercentRequest;

class PercentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StorePercentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePercentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Percent  $percent
     * @return \Illuminate\Http\Response
     */
    public function show(Percent $percent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Percent  $percent
     * @return \Illuminate\Http\Response
     */
    public function edit(Percent $percent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePercentRequest  $request
     * @param  \App\Models\Percent  $percent
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePercentRequest $request, Percent $percent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Percent  $percent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Percent $percent)
    {
        //
    }
}
