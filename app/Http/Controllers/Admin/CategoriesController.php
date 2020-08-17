<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator, Str;

use App\Http\Models\Category;

class CategoriesController extends Controller
{
    public function __Construct(){
		$this->middleware('auth');
		$this->middleware('isadmin');
	}

	public function getHome($module){
		$cats = Category::where('module', $module)->orderBy('name', 'Asc')->get();
		$data = ['cats' => $cats];
		return view('admin.categories.home', $data);
	}

	public function postCategoryAdd(Request $request){
		$rules = [
			'name' => 'required',
			'icon' => 'required',
		];
		$messages = [
			'name.required' => 'Debe de ingresar una categoria',
			'icon.requiered' => 'Se debe de ingresar un icono'
		];

		$validator = Validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger');
    	else:
    		$c = new Category();
    		$c->module = $request->input('module');
    		$c->name = e($request->input('name'));
    		$c->slug = Str::slug($request->input('name'));
    		$c->icono = e($request->input('icon'));
    		if($c->save()):
    			return back()->with('message', 'Guardado con exito')->with('typealert', 'success');
    		endif;
    	endif;
	}
}
