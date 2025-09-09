<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Models\professor;
use App\Http\Requests\StoreprofessorRequest;
use App\Http\Requests\UpdateprofessorRequest;
use App\Http\Requests\SearchRequest;
use Illuminate\Http\JsonResponse;
use Throwable;

class ProfessorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SearchRequest $request): JsonResponse
    {
        try {
            $query = professor::query()->with('user', 'department');
            if ($request->filled('search')) {
                $query->whereSearch($request->string('search')->value());
            }

            $query->orderBy('professor_id', 'asc');
            $professors = $query->paginate($request->integer('perpage', 10));

            return response()->json([
                'status' => 'success',
                'message' => 'Professors retrieved successfully',
                'data' => $professors,
            ], 200);

        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve professors',
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
