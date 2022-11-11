<?php

namespace App\Http\Controllers;

use App\Kendaraan;
use App\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualan = Penjualan::all();

        return response()->json(data:$penjualan, status:200);
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_kendaraan' => 'required',
            'quantity' => 'required|numeric'
        ]);

        if($validator->fails()) {
            return response()->json(data:['validation error' => $validator->errors()], status:400);
        }

        $kendaraan = Kendaraan::find($request->id_kendaraan);

        if(!$kendaraan) {
            return response()->json(data:['error' => 'kendaraan not found'], status:404);
        }

        $penjualan = [
            'id_kendaraan' => $kendaraan->id,
            'quantity' => $request->quantity
        ];

        $created = Penjualan::create($penjualan);

        return response()->json(data:$created, status:201);
    }

    public function report(Request $request)
    {
        if(!$request->has('id_kendaraan')) {
            return response()->json(data:['error' => 'insert selected kendaraan id in query params'], status:400);
        }

        $penjualan = Penjualan::all();
        $id = $request->input('id_kendaraan');
        $kendaraan = Kendaraan::find($id);

        $report = [
            'kendaraan' => $kendaraan,
            'quantity' => 0
        ];

        foreach($penjualan as $item) {
            if($item->id_kendaraan == $id) {
                $report['quantity'] += $item->quantity;
            }
        }

        return response()->json(data:$report, status:200);
    }
}
