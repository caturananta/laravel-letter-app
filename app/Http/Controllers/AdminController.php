<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Validator;

class AdminController extends Controller
{
    public function users(){
        $currentuser = Auth::user();
        $data['users'] = User::where('id','!=',$currentuser->id)->get();
        return view("page.users")->with($data);
    }

    public function user_detail($id){
        $data['user'] = User::where('id','=',$id)->first();
        return view("page.userdetail")->with($data);
    }

    public function user_update(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required',
//            'password' => 'required|min:6'
        ], [
            'name.required' => 'harus diisi',
            'email.required' => 'harus diisi',
//            'password.required' => 'harus diisi',
//            'password.min' => 'password minimal 6 digit'
        ]);
        $status = 'N';
        if ($request->input('aktif') == 'on'){
            $status = 'Y';
        }
        try {
            DB::beginTransaction();

            if($request->password == null) {
                User::where('id',$request->_id)->update(array("name"=>$request->name,"email"=>$request->email,"user_status"=>$status));
            }
            else{
                User::where('id',$request->_id)->update(array("name"=>$request->name,"email"=>$request->email,"password"=>Hash::make($request->password),"user_status"=>$status));
            }

            DB::commit();
        }
        catch (\Exception $e){
            Log::error($e);
            DB::rollBack();
            return back()->with('error', 'Gagal mengupdate user');
        }

        return back()->with('success', 'Berhasil mengupdate user');
    }

    public function new_user(){
        return view('page.useradd');
    }

    public function user_create(Request $request){
        $rules = [
            'name' => 'required|min:3|max:35',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
            'role' => 'required'
        ];

        $messages = [
            'name.required' => 'Nama Lengkap wajib diisi',
            'name.min' => 'Nama lengkap minimal 3 karakter',
            'name.max' => 'Nama lengkap maksimal 35 karakter',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.confirmed' => 'Password tidak sama dengan konfirmasi password',
            'role.required' => 'Status wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $status = 'N';
        if ($request->input('aktif') == 'on'){
            $status = 'Y';
        }

        try {
            DB::beginTransaction();
            $user = new User;
            $user->name = ucwords(strtolower($request->name));
            $user->email = strtolower($request->email);
            $user->password = Hash::make($request->password);
            $user->email_verified_at = \Carbon\Carbon::now();
            $user->user_status = $status;
            $user->user_role = $request->role;
            $user->save();
            DB::commit();
        }
        catch (\Exception $e){
            Log::error($e);
            DB::rollBack();
            return back()->with('error', 'Gagal menambah user');
        }

        return back()->with('success', 'Berhasil menambah user');
    }
}
