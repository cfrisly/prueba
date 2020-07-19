<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator, Hash, Auth;
use App\User;
use Illuminate\Support\Facades\Redirect;

class ConnectController extends Controller
{
	public function __construct(){
		$this->middleware('guest')->except(['getLogout']);
	}

    public function getLogin(){
    	return view('connect.login');
    }

    public function postLogin(Request $request){
    	$rules = [
    		'email' => 'required|email',
    		'password' => 'required|min:8'
    	];

    	$message = [
    		'email.required' => 'su correo electrónico es requerido',
    		'email.email' => 'El formato de su correo electronico es invalido',
    		'password.required' => 'Por favor escriba una contraseña',
    		'password.min' => 'La contraseña debe de tener almenos 8 caracteres.'
    	];

    	$validator = Validator::make($request->all(), $rules, $message);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger');
    	else:
    		if(Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')], true)):
    			return redirect('/');
    		else:
    			return back()->with('message', 'Correo electronico o contraseña incorrecta')->with('typealert', 'danger');
    		endif;
    	endif;
    }

    public function getRegister(){
    	return view('connect.register');
    }

    public function postRegister(Request $request){
    	$rules =[
    		'name' => 'required',
    		'lastname' => 'required',
    		'email' => 'required|email|unique:users,email',
    		'password' => 'required|min:8',
    		'cpassword' => 'required|min:same:password'
    	];

    	$message = [
    		'name.required' => 'su nombre es requerido.',
    		'lastname.required' => 'Su apellido es requerido',
    		'email.required' => 'su correo electrónico es requerido',
    		'email.email' => 'El formato de su correo electronico es invalido',
    		'email.unique' => 'Ya existe un usuario registrado con este correo electronico',
    		'password.required' => 'Por favor escriba una contraseña',
    		'password.min' => 'La contraseña debe de tener almenos 8 caracteres.',
    		'cpassword.required' => 'Es necesario confirmar la contraseña',
    		'cpassword.min' => 'La confirmacion de la contraseña debe de tener al menos 8 caracteres',
    		'cpassword.same' => 'Las contraseñas no coinciden.'
    	];

    	$validator = Validator::make($request->all(), $rules, $message);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger');
    	else:
    		$user = new User;
    		$user->name = e($request->input('name'));
    		$user->lastname = e($request->input('lastname'));
    		$user->email = e($request->input('email'));
    		$user->password = Hash::make($request->input('password'));

    		if($user->save()):
    			return redirect('/login')->with('message', 'Su usuario se creo con exito, Inicie sesión')->with('typealert', 'success');
    		endif;
    	endif;
    }

    public function getLogout(){
    	Auth::logout();
    	return redirect('/');
    }
}
