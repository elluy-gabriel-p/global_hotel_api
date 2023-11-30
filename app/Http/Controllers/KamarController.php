<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use Illuminate\Http\Request;

class KamarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $kamar = Kamar::all();
            return response()->json([
                "status" => true,
                "message" => 'Berhasil Ambil Data',
                "data" => $kamar
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
        try {
            $kamar = Kamar::create($request->all());
            return response()->json([
                "status" => true,
                "message" => 'Berhasil Insert Data',
                "data" => $kamar
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
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $kamar = Kamar::find($id);

            if (!$kamar) throw new \Exception("Kamar Tidak Ditemukan");

            return response()->json([
                "status" => true,
                "message" => "Berhasil Ambil Data",
                "data" => $kamar
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
            $kamar = Kamar::find($id);
            if (!$kamar) throw new \Exception("Kamar Tidak Ditemukan!");

            $kamar->update($request->all());

            return response()->json([
                "status" => true,
                "message" => "Berhasil Update Data",
                "data" => $kamar
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
            $kamar = Kamar::find($id);

            if (!$kamar) throw new \Exception("Kamar Tidak Ditemukan!");

                $kamar->delete();

                return response()->json([
                    "status" => true,
                    "message" => "Berhasil Delete Data",
                    "data" => $kamar
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
