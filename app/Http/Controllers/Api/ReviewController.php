<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
        DB::table('review')->insert([
            'id_kamar' => $request->id_kamar,
            'komentar' => $request->komentar,
            'id_user' => $request->id_user
        ]);

        return response([
            'status' => true,
            'message' => 'success add review'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $data = DB::table('review')
            ->join('kamars', 'review.id_kamar', '=', 'kamars.id')
            ->join('users', 'review.id_user', '=', 'users.id')
            ->where('review.id_user', '=', $request->id)
            ->select('review.*', 'users.username', 'kamars.tipe', 'kamars.harga')
            ->get();

        if (is_null($data)) {
            return response([
                'status' => false,
                'message' => 'no data found',
                'data' => []
            ]);
        }

        return response([
            'status' => true,
            'message' => 'all data retrive',
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $data = DB::table('review')->where('id', '=', $request->id)->update(['komentar' => $request->komentar]);

        return response([
            'messege' => 'edit review success'
        ]);
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
    public function destroy(Request $request)
    {
        DB::table('review')->where('id', '=', $request->id)->delete();

        return response([
            'messege' => 'delete review success'
        ]);
    }
}
