<?php

namespace App\Http\Controllers;

use App\Models\MovementType;
use App\Http\Requests\StoreMovementTypeRequest;
use App\Http\Requests\UpdateMovementTypeRequest;

class MovementTypeController extends Controller
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
     * @param  \App\Http\Requests\StoreMovementTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMovementTypeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MovementType  $movementType
     * @return \Illuminate\Http\Response
     */
    public function show(MovementType $movementType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MovementType  $movementType
     * @return \Illuminate\Http\Response
     */
    public function edit(MovementType $movementType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMovementTypeRequest  $request
     * @param  \App\Models\MovementType  $movementType
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMovementTypeRequest $request, MovementType $movementType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MovementType  $movementType
     * @return \Illuminate\Http\Response
     */
    public function destroy(MovementType $movementType)
    {
        //
    }
}
