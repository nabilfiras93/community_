<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\Login;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    // use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function validatorLogin(Request $request, $parameter=null) {
        $parameter['username'] = 'required';
        $parameter['password'] = 'required|string';
        $validator = Validator::make($request->all(), $parameter);
        if($validator->fails()){ throw new ValidationException($validator); }
    }

     public function validatorSignup(Request $request, $parameter=null) {
        $parameter['username'] = 'required';
        $parameter['password'] = 'required|string';
        $parameter['nama'] = 'required';
        $parameter['email'] = 'required|email:rfc,dns';
        $parameter['phone'] = 'required';
        $validator = Validator::make($request->all(), $parameter);
        if($validator->fails()){ throw new ValidationException($validator); }
    }

    public function setSession($request, $data) {
        $request->session()->put('remember_token', $data->remember_token);
        $request->session()->put('my_username', $data->email);
        $request->session()->put('my_name', $data->name);
    }

    public function auth() {
        if (request()->session()->exists('my_username')) {
            return redirect('home');
        }
        return view('layouts.login');
    }

    public function register() {
        return view('layouts.register');
    }

    public function login(Request $request) {
        ini_set('max_execution_time', -1);
        DB::beginTransaction();
        try {
            $this->validatorLogin($request);
            $username       = $request->username;
            $password       = $request->password;
            $remember       = ($request->remember && $request->remember == 'on') ? true : false;

            $findUSer = DB::table('users as u')
                ->select('u.*')
                ->where('email', $username)->first();
            if(!$findUSer){
                throw new \Exception('Username tidak ditemukan', 404);
            }
            if(!Hash::check($password, $findUSer->password)) {
                throw new \Exception('Kombinasi username dan password tidak sesuai');
            }
            
            self::setSession($request, $findUSer);

            if($remember){
                $remember_token = Str::random(40);
                $expired = 21900; // expired for 2 weeks if no click logout
                $remember  = ['remember_token' => $remember_token];
                DB::table('users')->where('id', $findUSer->id)->update($remember);
                Cookie::queue($token_remember = Cookie::make('my_remember_token_comm', $remember_token, $expired));
            }

            DB::commit();
            return $this->sendSuccess('Selamat Datang');
        } catch (ValidationException $e){
            DB::rollback();
            return $this->sendError($e->getCode(), $e->validator->errors()->all());
        } catch (\Exception $e) {
            DB::rollback();
            return $this->sendError($e->getCode(), $e->getMessage());
        }
    }

    public function loginByCookie(Request $request) {
        ini_set('max_execution_time', -1);
        DB::beginTransaction();
        try {
            $cookie = $request->myCookie;
            $findUSer = DB::table('users as u')
                ->select('u.*')
                ->where('remember_token', $cookie)->first();
            if(!$findUSer){
                throw new \Exception('User tidak ditemukan', 404);
            }
            
            self::setSession($request, $findUSer);

            DB::commit();
            return redirect(url('/'));
        } catch (ValidationException $e){
            DB::rollback();
            return redirect(url('/auth'));
        } catch (\Exception $e) {
            DB::rollback();
            return redirect(url('/auth'));
        }
    }

    public function signup(Request $request) {
        ini_set('max_execution_time', -1);
        DB::beginTransaction();
        try {
            $this->validatorSignup($request);
            $nama           = $request->nama;
            $email          = $request->email;
            $phone          = $request->phone;
            $username       = $request->username;
            $password       = $request->password;


            DB::commit();
            return $this->sendSuccess('Daftar Berhasil');
        } catch (ValidationException $e){
            DB::rollback();
            return $this->sendError($e->getCode(), $e->validator->errors()->all());
        } catch (\Exception $e) {
            DB::rollback();
            return $this->sendError($e->getCode(), $e->getMessage());
        }
    }

    public function logout(Request $request) {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        if(Cookie::get('my_remember_token_comm')){
            Cookie::queue(Cookie::forget('my_remember_token_comm'));
        }
        return redirect('/auth');
    }
}
