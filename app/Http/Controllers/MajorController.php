<?php

namespace App\Http\Controllers;

use App\Models\major;
use App\Http\Requests\StoremajorRequest;
use App\Http\Requests\UpdatemajorRequest;
use Throwable;
use App\Http\Requests\SearchRequest;
use Illuminate\Http\JsonResponse;

class MajorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SearchRequest $request) : JsonResponse
    {
        try {
            $query = major::query();
            if ($request->filled('search')) {
                $query->scopeSearch($request->string('search')->value());
            }

            $majors = $query->paginate($request->integer('perpage', 10));

            return response()->json([
                'status' => 'success',
                'message' => 'Majors retrieved successfully',
                'data' => $majors,
            ], 200);

        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve majors',
                'error' => $e->getMessage(),
            ], 500);
        }
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
    public function store(StoremajorRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(major $major)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(major $major)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatemajorRequest $request, major $major)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(major $major)
    {
        //
    }
}
