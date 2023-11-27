<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request) {
        $validasi = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:8'
        ]);

        if ($validasi->fails()) {
            return ApiFormatter::error($validasi->errors()->first(), 400);
        }

        try {
            $user = User::create($request->all(), Hash::make($request->password));
            return ApiFormatter::success($user, "Berhasil register, silahkan cek email untuk melakukan verifikasi");
        } catch (\Throwable $th) {
            return ApiFormatter::error('Terjadi kesalahan, silahkan kirim ulang', 500);
        }
    }

    public function login(Request $request) {
        $validasi = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|min:8'
        ]);

        if ($validasi->fails()) {
            return ApiFormatter::error($validasi->errors()->first(), 400);
        }

        try {
            if (!Auth::attempt($request->only(['email', 'password']))) {
                return ApiFormatter::error("Email atau password salah", 401);
            }
            $user = User::where('email', $request->email)->first();
            return ApiFormatter::success($user, "Selamat datang $user->name");
        } catch (\Throwable $th) {
            return ApiFormatter::error('Terjadi kesalahan, silahkan kirim ulang', 500);
        }
    }

    public function index()
    {
        $user = User::all();
        if (!$user) {
            return ApiFormatter::error("User tidak ditemukan", 400);
        }
        return ApiFormatter::success($user);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return ApiFormatter::error("User tidak ditemukan", 400);
        }
        
        try {
            $user->update($request->all());
            return ApiFormatter::success($user, "Data berhasil diperbarui");
        } catch (\Throwable $th) {
            return ApiFormatter::error('Terjadi kesalahan, silahkan kirim ulang', 500);
        }
    }

    public function destroy(string $id)
    {
        //
    }
}
