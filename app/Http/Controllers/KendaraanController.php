<?php

namespace App\Http\Controllers;

use App\Kendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KendaraanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kendaraan = Kendaraan::all();

        return response()->json(data:$kendaraan, status:200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tahun_keluaran' => 'required',
            'harga' => 'required|numeric',
            'warna' => 'required',
            'motor_id' => 'required_without:mobil_id',
            'mobil_id' => 'required_without:motor_id',
        ]);

        if(!$validator->fails()) {
            $data = [
                'tahun_keluaran' => $request->tahun_keluaran,
                'harga' => $request->harga,
                'warna' => $request->warna,
            ];
    
            if($request->has('motor_id')) {
                $data['motor_id'] = $request->motor_id;
            } else if($request->has('mobil_id')) {
                $data['mobil_id'] = $request->mobil_id;
            }
    
            $kendaraan = Kendaraan::create($data);
    
            return response()->json(data:$kendaraan, status:201);
        } else {
            return response()->json(data:["error" => $validator->errors()], status:201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kendaraan  $kendaraan
     * @return \Illuminate\Http\Response
     */
    public function show(Kendaraan $kendaraan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kendaraan  $kendaraan
     * @return \Illuminate\Http\Response
     */
    public function edit(Kendaraan $kendaraan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kendaraan  $kendaraan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kendaraan $kendaraan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kendaraan  $kendaraan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kendaraan $kendaraan)
    {
        //
    }
}
