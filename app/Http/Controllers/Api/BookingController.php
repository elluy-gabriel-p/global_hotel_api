<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
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
    public function create(Request $request)
    {
        $result = DB::table('booking')->insert([
            'id_kamar' => $request->id_kamar,
            'id_user' => $request->id_user,
            'jumlah_orang' => $request->jumlah_orang,
            'jumlah_kamar' => $request->jumlah_kamar,
            'tlg_check_in' => $request->tgl_check_in,
            'tlg_check_out' => $request->tgl_check_out,
            'notelp' => $request->notelp
        ]);

        $data = DB::table('booking')->latest()->get();

        if (!$request) {
            return response([
                'status' => true,
                'messege' => 'success booking',
                'data' => $data
            ]);
        }

        return response([
            'status' => false,
            'messege' => 'Failed booking',
            'data' => []
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = DB::table('booking')
            ->join('users', 'booking.id_user', '=', 'users.id')
            ->join('kamars', 'booking.id_kamar', '=', 'kamars.id')
            ->where('booking.id_user', '=', $request->id)
            ->select('booking.*', 'users.username', 'kamars.tipe', 'kamars.harga')
            ->get();

        if (is_null($data)) {
            return response([
                'status' => false,
                'messege' => 'no data found',
                'data' => []
            ], 401);
        }

        return response([
            'status' => true,
            'messege' => 'success get data',
            'data' => $data
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
