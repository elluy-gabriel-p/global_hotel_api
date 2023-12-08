<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $registrasiData = $request->all();

        $validate = Validator::make($registrasiData, [
            'username' => 'required|max:60',
            'email' => 'required',
            'password' => 'required|min:8',
            'notelp' => 'required',
            'borndate' => 'required',
        ]);
        if ($validate->fails()) {
            return response([
                'status' => false,
                'message' => $validate->errors()
            ], 400);
        }

        $user = DB::table('users')->insert([
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
            'notelp' => $request->notelp,
            'borndate' => $request->borndate,
            'image' => 0
        ]);
        $user = DB::table('users')->latest()->first();
        return response([
            'status' => true,
            'message' => 'Register Success',
            'user' => $user
        ], 200);
    }

    public function login(Request $request)
    {
        $loginData = $request->all();
        $validate = Validator::make($loginData, [
            'username' => 'required|max:60',
            'password' => 'required'
        ]);

        if ($validate->fails()) {
            return response(['message' => $validate->errors()], 400);
        }



        $user = User::where('username', $loginData['username'])->where('password', $loginData['password'])->first();


        if (is_null($user)) {
            return response([
                'status' => false,
                'message' => 'Login Failed',
                'user' => [],
            ]);
        }
        return response([
            'status' => true,
            'message' => 'Authenticated',
            'user' => $user,
        ]);
    }
    public function index()
    {
        $user = User::all();

        if (count($user) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $user
            ], 200);
        }
        return response([
            'message' => 'empty',
            'data' => null
        ], 400);
    }

    public function show($id)
    {
        try {
            $user = User::find($id);

            if (!$user) throw new \Exception("User Tidak Ditemukan");

            return response()->json([
                "status" => true,
                "message" => "Berhasil Ambil Data",
                "data" => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ], 400);
        }
    }
    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            return response([
                'message' => 'User Not Found',
                'data' => null
            ], 400);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'username' => 'required|max:60',
            'email' => 'required',
            'password' => 'required|min:8',
            'notelp' => 'required',
            'borndate' => 'required',
        ]);

        if ($validate->fails())



            return response(['message' => $validate->errors()], 400);




        $user->username = $updateData['username'];
        $user->email = $updateData['email'];
        $user->password = $updateData['password'];
        $user->notelp = $updateData['notelp'];
        $user->borndate = $updateData['borndate'];

        if ($user->save()) {
            return response([
                'message' => 'Update User Succes',
                'data' => $user
            ], 200);
        }
        return response([
            'message' => 'Update User Fail',
            'data' => null
        ], 400);
    }

    public function updateProfile(Request $request)
    {
        $hasil = DB::table('users')->where('id', '=', $request->id)->update(['image' => $request->image]);

        if (!is_null($hasil)) {
            $res = DB::table('users')->where('id', '=', $request->id)->first();
            return response([
                'status' => 'update success',
                'hasil' => $res
            ]);
        }
    }

    public function destroy(string $id)
    {
        $user = User::find($id);
        if (is_null($user)) {
            return response([
                'message' => 'User Not Found',
                'data' => null
            ], 400);
        }
        if ($user->delete()) {
            return response([
                'message' => 'Delete User Success',
                'data' => $user
            ], 200);
        }
        return response([
            'message' => 'Delete User Failed',
            'data' => null
        ], 400);
    }

    public function updatePassword(Request $request)
    {
        try {
            $user = User::where('email', $request->input('email'))->first();

            if (!$user) {
                return response(['message' => 'User Tidak Ditemukan !'], 404);
            }

            $validator = Validator::make($request->all(), [
                'email' => 'required|email:rfc,dns',
                'new_password' => 'required|min:5',
            ]);

            if ($validator->fails()) {
                return response(['message' => $validator->errors()], 400);
            }

            $user->password = bcrypt($request->input('new_password'));
            $user->save();

            return response()->json([
                "status" => true,
                "message" => 'Berhasil Update Password',
                "data" => [
                    'user_id' => $user->id,
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => []
            ], 400);
        }
    }
}
