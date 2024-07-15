<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transaction = Transaction::all();

        return response()->json($transaction);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transaction = Transaction::findOrFail($id);

        return new TransactionResource($transaction);
    }


    /**
     * Display a refunded transactions.
     */
    public function refunded()
    {
        $transaction = Transaction::where('payment_status', 'refunded')->get();

        return response()->json($transaction);
    }

    /**
     * Display a user transactions.
     */
    public function userTransaction(string $id)
    {
        $transactions = Transaction::where('user_id', $id)->get();

        return response()->json($transactions);
    }

    /**
     * Display a host transactions.
     */

    public function hostTransaction(string $id)
    {
        $transactions = Transaction::where('host_id', $id)->get();

        return response()->json($transactions);
    }
}
