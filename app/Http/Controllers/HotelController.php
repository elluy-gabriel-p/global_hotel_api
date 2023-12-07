<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $hotel = hotel::all();
            return response()->json([
                "status" => true,
                "message" => 'Berhasil Ambil Data',
                "data" => $hotel
            ], 200); //status code 200 = success
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ], 400); //status code 400 = bad request
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => '',
            'rating' => 'required|numeric',
            'harga' => 'required|numeric',
            'fasilitas' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'data' => $validator->errors(),
            ], 400);
        }

        try {
            $hotel = Hotel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Berhasil Insert Data',
                'data' => $hotel,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => [],
            ], 400);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $hotel = hotel::find($id);

            if (!$hotel) throw new \Exception("Hotel Tidak Ditemukan");

            return response()->json([
                "status" => true,
                "message" => "Berhasil Ambil Data",
                "data" => $hotel
            ], 200);
        } 
        catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $hotel = hotel::find($id);
            if (!$hotel) throw new \Exception("Hotel Tidak Ditemukan!");

            $hotel->update($request->all());

            return response()->json([
                "status" => true,
                "message" => "Berhasil Update Data",
                "data" => $hotel
            ], 200);
        } 
        catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $hotel = hotel::find($id);

            if (!$hotel) throw new \Exception("Hotel Tidak Ditemukan!");

                $hotel->delete();

                return response()->json([
                    "status" => true,
                    "message" => "Berhasil Delete Data",
                    "data" => $hotel
                ],200);
        }
        catch(\Exception $e){
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ],400);
        }
    }
}
