<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function __Construct(){
		$this->middleware('auth');
		$this->middleware('isadmin');
	}

	public function getHome(){
		return view('admin.categories.home');
	}
}
