<?php

namespace App\Http\Controllers;

use App\OrderModel;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class AkunController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $data = User::find($id);

        return view('admin.profile.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = User::find($id);

        // Update Profil (Jika field ada di request)
        if ($request->has('name')) {
            $data->name = $request->name;
        }
        if ($request->has('email')) {
            $data->email = $request->email;
        }

        // Update Foto Profil
        if ($request->has('foto')) {
            $request->file('foto')->move('foto_akun/', $request->file('foto')->getClientOriginalName());
            $data->foto = $request->file('foto')->getClientOriginalName();
            Alert::success('Sukses', 'Foto Berhasil Di Ubah');
        }

        // Update Password (Jika field password diisi)
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|min:8|max:12|confirmed',
            ], [
                'password.required' => 'Password wajib diisi!',
                'password.min' => 'Password minimal 8 karakter!',
                'password.max' => 'Password maksimal 12 karakter!',
                'password.confirmed' => 'Konfirmasi password tidak cocok!',
            ]);
            $data->password = bcrypt($request->password);
            Alert::success('Sukses', 'Password Berhasil Di Ubah');
        }

        $data->save();

        if (!$request->filled('password') && !$request->has('foto')) {
             Alert::success('Sukses', 'Akun Berhasil Di Edit');
        }
        
        return redirect()->back();
    }


    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
