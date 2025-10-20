<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class customerController extends Controller
{
    public function index()
    {
        $data = Customer::all();

        return response()->json([
            'status' => 'view all data',
            'data' => $data,
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'cus_name' => ['string', 'required'],
            'email' => ['required', 'email'],
            'cus_psw' => ['required', 'string'],
        ]);
        $insert = customer::create($request->all());
        if ($insert) {
            return response()->json([
                'status' => 'add successfully',
                'data' => $insert,
            ], 201);
        }
    }
}
