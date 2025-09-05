<?php

namespace App\Http\Controllers;

use App\Models\professor;
use App\Http\Requests\StoreprofessorRequest;
use App\Http\Requests\UpdateprofessorRequest;

class ProfessorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreprofessorRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(professor $professor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(professor $professor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateprofessorRequest $request, professor $professor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(professor $professor)
    {
        //
    }
}
