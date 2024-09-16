<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Evaluation;
use Illuminate\Http\Request;

class EvaluationResourceController extends Controller
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($reservation_id)
    {
        $evaluation = Evaluation::where('reservation_id', $reservation_id)->first();

        if (!$evaluation) {
            return response()->json(['error' => 'Evaluation not found'], 404);
        }

        return response()->json($evaluation);
    }

    /**
     * show evaluations of a guest
     * @param $user_id
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function userEvaluation($user_id)
    {
        $evaluations = Evaluation::where('reviewee_id', $user_id)->get();

        if (!$evaluations) {
            return response()->json(['error' => 'Evaluation not found'], 404);
        }

        return response()->json($evaluations);
    }

    /**
     * show evaluations of a host
     * @param $host_id
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function hostEvaluation($host_id)
    {
        $evaluations = Evaluation::where('reviewer_id', $host_id)->get();

        if (!$evaluations) {
            return response()->json(['error' => 'Evaluation not found'], 404);
        }

        return response()->json($evaluations);
    }


}
