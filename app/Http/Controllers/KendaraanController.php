<?php

namespace App\Http\Controllers;

use App\Kendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
            'motor' => 'array|min:1',
            'mobil' => 'array|min:1',
        ]);

        $kendaraan = $request->all();

        if($request->has('motor') && $request->has('mobil')) {
            return response()->json(data:["error" => "Find motor and mobil in payload request"], status:201);
        }
        
        if(!$validator->fails()) {
            if($request->has('motor')) {
                for($i = 0; $i < count($kendaraan['motor']); $i++) {
                    $kendaraan['motor'][$i]['uuid'] = Str::uuid()->getHex()->toString();
                }
            }
            if($request->has('mobil')) {
                for($i = 0; $i < count($kendaraan['mobil']); $i++) {
                    $kendaraan['mobil'][$i]['uuid'] = Str::uuid()->getHex()->toString();
                }
            }

            $created = Kendaraan::create($kendaraan);

            return response()->json(data:$created, status:201);
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
        return response()->json(data:$kendaraan, status:200);
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
        $validator = Validator::make($request->all(), [
            'tahun_keluaran' => 'required',
            'harga' => 'required|numeric',
            'warna' => 'required',
            'motor' => 'array|min:1',
            'mobil' => 'array|min:1',
        ]);

        $payload = $request->all();

        if($request->has('motor') && $request->has('mobil')) {
            return response()->json(data:["error" => "Find motor and mobil in payload request"], status:201);
        }
        
        if(!$validator->fails()) {
            if($request->has('motor')) {
                for($i = 0; $i < count($payload['motor']); $i++) {
                    $payload['motor'][$i]['uuid'] = Str::uuid()->getHex()->toString();
                }
            }
            if($request->has('mobil')) {
                for($i = 0; $i < count($payload['mobil']); $i++) {
                    $payload['mobil'][$i]['uuid'] = Str::uuid()->getHex()->toString();
                }
            }

            $updated = $kendaraan->update($payload);

            return response()->json(data:$updated, status:200);
        } else {
            return response()->json(data:["error" => $validator->errors()], status:201);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kendaraan  $kendaraan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kendaraan $kendaraan)
    {
        $kendaraan->delete();

        return response()->json(data:[], status:204);
    }
}
