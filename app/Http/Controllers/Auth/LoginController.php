<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Response as HttpResponse;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Input;
use \Validator, \Auth, \Redirect;
use Request;
use Carbon\Carbon;

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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/concentrado';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username(){
        return 'username';
    }

    public function showLogin(){
        return view('login');
    }

    public function doLogin(){
        try{
            $rules = array(
                'username'     => 'required',
                'password' => 'required|min:3'
            );
    
            $validator = Validator::make(Input::all(), $rules);
            
            if ($validator->fails()) {
                //return response()->json(['mensaje' => 'Bleh', 'validacion'=>$validator->errors()], HttpResponse::HTTP_OK);
                return Redirect::to('login')
                    ->withErrors($validator) // send back all errors to the login form
                    ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
            }else{
                $userdata = array(
                    'username'     => Input::get('username'),
                    'password'  => Input::get('password')
                );
    
                if (Auth::attempt($userdata)) {
                    $usuario = Auth::user();
                    //return response()->json(['mensaje' => 'Bleh', 'datos'=>$usuario], HttpResponse::HTTP_OK);
                    return Redirect::to('concentrado');
                } else {
                    //return response()->json(['mensaje' => 'Bleh', 'error'=>'nel pastel', 'datos'=>$userdata, 'resultado'=>Auth::attempt($userdata)], HttpResponse::HTTP_OK);
                    return Redirect::to('login')
                        ->withErrors($validator) // send back all errors to the login form
                        ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
                }
            }
        }catch(\Exception $e){
            echo $e->getMessage() . '<br>' . $e->getLine();
        }
    }

    public function logout(){
        Auth::logout(); // log the user out of our application
        return Redirect::to('login'); // redirect the user to the login screen
    }
}
