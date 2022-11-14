<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\UserModel;
use App\KaryawanModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\LogModel;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class Usercontroller extends Controller
{

    public function error(){
        return view('error');
    }

   public function load (){
       $user = DB::table('tb_user')->get();
       dd($user->all());
   }

   public function listuser (){
       $user = DB::table('tb_user')->get();
       return view ('userlist',['tb_user' => $user]);
   }

    public function edit($id)
    {
        $user = DB::table('tb_user')->where('id',$id)->get();
        $dept = DB::connection('sqlsrv_pga')->table('T_DEPARTEMEN')->select('DEPT_SECTION')->groupBy('DEPT_SECTION')->get();
        $level = DB::connection('sqlsrv_pga')->table('T_JABATAN')->get();
	// passing data pegawai yang didapat ke view edit.blade.php
	return view('admin.useredit',['tb_user' => $user, 'departemen'=>$dept, 'level'=>$level]);
 
    }

    public function update(Request $request)
    {
        // dd($request->all());
	DB::table('tb_user')->where('id',$request->id)->update([
        'user_name' => $request->user_name,
        'password' => $request->password = Hash::make($request['password']),
		'departemen' => $request->departemen,
		'line_process' => $request->line_process,
		'level_user' => $request->level_user
    ]);
    return redirect()->route('list-user');
    }

    public function hapus($id)
    {
	DB::table('tb_user')->where('id',$id)->delete();
    //return redirect('/list-user');
    Session::flash('alert-success','Hapus User berhasil !'); 
    return redirect()->route('list-user');
    }

    public function register(Request $request){
        $this->validate($request,[
        'nama_user' => 'required|min:4',
        'password' => 'required|min:4',
        'departemen' => 'required',
        'line_process' => 'required',
        'level_user' => 'required',
        'nik'=>'required|min:4',
    ]);

$kar = KaryawanModel::find($request['nik']);

if ($kar) {
    if ($kar->STATUS_KARYAWAN != "Off") {
   
        $user = new UserModel();
        $user->user_name = $request['nama_user'];
        $user->departemen = $request['departemen'];
        $user->line_process = $request['line_process'];
        $user->password = Hash::make($request['password']);
        $user->level_user = $request['level_user'];
        $user->nik = $request['nik'];
        $saved = $user->save();
        if (!$saved) {
            Session::flash('alert-danger','Register gagal !'); 
            return redirect()->route('register');
        }
    
        $user->rollApiKey();
      
        Session::flash('alert-success','Register berhasil !'); 
        //return redirect('/register')->with('alert-success','Register berhasil !');
        return redirect()->route('register');
    }else{
        Session::flash('alert-danger','Register gagal NIK tidak ditemukan !'); 
        //return redirect('/register')->with('alert-success','Register berhasil !');
        return redirect()->route('register');
    }
}else{
    Session::flash('alert-danger','Register gagal !'); 
    //return redirect('/register')->with('alert-success','Register berhasil !');
    return redirect()->route('register');
}

    
   }

   public function postlogin(Request $request){
        $this->validate($request, [
            'username' => 'required|min:4',
            'password' => 'required|min:4',
        ]);

        $data = Usermodel::where('user_name',$request['username'])->first();
       //dd($data);
        if ($data) {
           if (Hash::check($request['password'],$data->password)) {
            Session::put('name',$data->user_name);
            Session::put('id',$data->id);
            Session::put('dept',$data->departemen);
            Session::put('level',$data->level_user);
            Session::put('nik',$data->nik);
            Session::put('level_user',$data->level_user);
            Session::put('login',1);
            $request->session()->save();

           // return redirect()->route('home');

                $data->rollApiKey(); //Model Function

                return array(
                    'user' => $data,
                    'token'=>base64_encode($data->api_token),
                    'message' => 'Authorization Successful!',
                    'success'=>true
                );

           }else{
            
            Session::flash('alert','Password atau email salah !'); 
            //return redirect('/login')->with('alert','Password atau email salah !');
            //return redirect()->route('login');
            return array(
                //'user' => $data,
                //'token'=>base64_encode($data->api_token),
                'message' => 'Authorization failed!',
                'success'=>false
            );
           
           }
        }else{
            Session::flash('alert','Password atau email salah !'); 
           // return redirect('/login')->with('alert','Password atau email salah !');
           //return redirect()->route('login');
           return array(
            //'user' => $data,
            //'token'=>base64_encode($data->api_token),
            'message' => 'Authorization failed!',
            'success'=>false
        );
        }
        
   }

   public function apilogin(Request $request){
    //dd($request->all());
    $data = Usermodel::where('user_name',$request['username'])->first();
    if ($data) {
       if (Hash::check($request['password'],$data->password)) {
        return array(
                    'user' => $data,
                    'message' => 'Authorization Successful!',
                    'success'=>true
                );
       }else{
        return array(
       
            'message' => 'Authorization failed !',
            'success'=>false
        );
       }
    }
    return array(
       
        'message' => 'User tidak ditemukan !',
        'success'=>false
    );
   }

   public function logout(Request $request){
   
    $request->session()->invalidate();
   
    return array(
        
        'message' => 'Logout Successful!',
        'success'=>true
    );
  //return redirect()->route('home');
    
   }

   public function get_user(){
       return UserModel::all();
   }

   public function get_proc(){
       $proc = DB::connection('oracle')->table('NPR_WIPNMMS')->get();
       return $proc;
   }

   public function hapususer(Request $request){
    $token = apache_request_headers();
            $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
            $dept = $user->departemen;
            $id = $request->input('id');
            $req = UserModel::find($id);
   
            
            if ($dept == "Admin") {
                $req->delete();
              $status = true;
              $mess = "Delete berhasil";
                //Session::flash('alert-success','Hapus Request berhasil !'); 
            }else{
                $mess = "Delete gagal";
                $status = false;
                //Session::flash('alert-danger','Hapus Request gagal !');
            }
            $details = [
                'id' => $id,
                'status'=>"delete",
    
            ];
            $data = [
                'record_no' => Str::uuid(),
                'user_id' => $user->id,
                'activity' =>"delete",
                'message' => $details,
            ];
    
            LogModel::create($data);
    
            return array(
                'message' => $mess,
                'success'=>$status
            );
   }


   public function gantipassword (Request $request){
       
       $token = apache_request_headers();
      
       $user = UserModel::where('api_token',base64_decode($token['token_req']))->first();
      
            
       if ($user){
        if (Hash::check($request['edit-passlama'],$user->password)) {
          if( strlen($request['edit-passbaru'])>= 4){

              $user->password = Hash::make($request['edit-passbaru']);
              $user->save();
              return array(
               'message' => "Ganti Password berhasil.",
               'success'=>true
           );
          }else{
            return array(
                'message' => "Password Minimal 4 karakter",
                'success'=>false
            );
          }
        }else{
            return array(
                'message' => "Password Lama Salah!",
                'success'=>false
            );
        }
       } else {
        return array(
            'message' => "Password Lama Salah!",
            'success'=>false
        );
       }

   }
   public function tokenMTC(Request $request){
    $nama = $request->input('idname');
    $data = Usermodel::where('user_name',$nama)->first();
    return array(
        'token'=>base64_encode($data->api_token),
        'message' => 'Authorization Successful!',
        'success'=>true
    );
   }
   public function token(Request $request){

    $nama = $request->input('idname');
    $data = Usermodel::where('user_name',$nama)->first();

    $line = $request->input('line');

    try {
        //$q = Crypt::decrypt($line);
        $q1 = base64_decode($line);

        $q2 = explode(',',$q1);
        $q = $q2[0];

        if (is_numeric($q)){
            $cek = DB::table('tb_line')->where('kode_line','=',$q)->count();
        }else {
            $cek = 0;
        }

        if ($cek > 0){
            return array(
                'token'=>base64_encode($data->api_token),
                'message' => 'Authorization Successful!',
                'qline'=>$q,
                'success'=>true
            );
        }else {
            return array(
                'message' => 'QR Tidak terdaftar .',
                'success'=>false
            );
        }
    }
    catch (DecryptException $e) {
        return array(
            'message' => 'QR Tidak terdaftar .',
            'success'=>false
        );
    }
   }
}
