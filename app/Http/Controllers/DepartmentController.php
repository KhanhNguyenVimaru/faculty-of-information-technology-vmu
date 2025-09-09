<?php

namespace App\Http\Controllers;

use App\Models\department;
use App\Http\Requests\StoredepartmentRequest;
use App\Http\Requests\UpdatedepartmentRequest;
use Throwable;
use App\Http\Requests\SearchRequest;
use Illuminate\Http\JsonResponse;


class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SearchRequest $request) : JsonResponse
    {
        try {
            $query = department::query();
            if ($request->filled('search')) {
                $query->scopeSearch($request->string('search')->value());
            }
            $query->with('headUser:id,name,email');
            $query->orderBy('id', 'asc');
            $departments = $query->paginate($request->integer('perpage', 10));

            return response()->json([
                'status' => 'success',
                'message' => 'Departments retrieved successfully',
                'data' => $departments,
            ], 200);

        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve departments',
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
    public function store(StoredepartmentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatedepartmentRequest $request, department $department)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(department $department)
    {
        //
    }
}
