<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Models\Category, App\Http\Models\Product;
use Validator, Str, Config, Image;

class ProductController extends Controller
{
    public function __Construct(){
		$this->middleware('auth');
		$this->middleware('isadmin');
	}

	public function getHome(){
		$products = Product::with(['cat'])->orderby('id', 'desc')->paginate(25);
		$data = ['products' => $products];
		return view('admin.products.home', $data);
	}

	public function getProductAdd(){
		$cats = Category::where('module', '0')->pluck('name', 'id');
		$data = ['cats' => $cats];
		return view('admin.products.add', $data);
	}

	public function postProductAdd(Request $request){
		$rules = [
			'name' => 'required',
			'img' => 'required',
			'price' => 'required',
			'content' => 'required'
		];

		$messages =[
			'name.required' => 'Se necesita nombre para continuar',
			'img.required' => 'Se necesita una imagen para continuar',
			'img.image' => 'El archivo no es una imagen',
			'price.required' => 'Ingrese el preio del producto para continuar',
			'content.required' => 'Es necesario una descripción para continuar'
		];

		$validator = Validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withInput();
    	else:
    		$path ='/'.date('Y-m-d');
    		$fileExt = trim($request->file('img')->getClientOriginalExtension());
    		$upload_path = Config::get('filesystems.disks.uploads.root');
    		$name = Str::slug(str_replace($fileExt, '', $request->file('img')->getClientOriginalName()));
    		$filename = rand(1,999).'-'.$name.'.'.$fileExt;
    		$file_file = $upload_path.'/'.$path.'/'.$filename;

    		$product = new Product;
    		$product->status = '0';
    		$product->name = e($request->input('name'));
    		$product->slug = Str::slug($request->input('name'));
    		$product->category_id = $request->input('category');
    		$product->file_path = date('Y-m-d');
    		$product->image = $filename;
    		$product->price =$request->input('price');
    		$product->in_discount = $request->input('indiscount');
    		$product->discount = $request->input('discount');
    		$product->description = e($request->input('content'));

    		if($product->save()):
    			if($request->hasFile('img')):
    				$fl =$request->img->storeAs($path, $filename, 'uploads');
    				$img = Image::make($file_file);
    				$img->fit(256,256,function($constraint){
    					$constraint->upsize();
    				});
    				$img->save($upload_path.'/'.$path.'/'.'/t_'.$filename);
    			endif;
    			return redirect('/admin/products')->with('message', 'Guardado con exito')->with('typealert', 'success');
    		endif;
    	endif;
	}

	public function getProductEdit($id){
		$p = Product::find($id);
		$cats = Category::where('module', '0')->pluck('name', 'id');
		$data = ['cats' => $cats, 'p' => $p];
		return view('admin.products.edit', $data);
	}

	public function postProductEdit($id, Request $request){
		$rules = [
			'name' => 'required',
			'price' => 'required',
			'content' => 'required'
		];

		$messages =[
			'name.required' => 'Se necesita nombre para continuar',
			'img.image' => 'El archivo no es una imagen',
			'price.required' => 'Ingrese el preio del producto para continuar',
			'content.required' => 'Es necesario una descripción para continuar'
		];

		$validator = Validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withInput();
    	else:
    		$product = Product::find($id);
    		$product->status = $request->input('status');
    		$product->name = e($request->input('name'));
    		$product->category_id = $request->input('category');
    		if ($request->hasFile('img')):
    			$path ='/'.date('Y-m-d');
	    		$fileExt = trim($request->file('img')->getClientOriginalExtension());
	    		$upload_path = Config::get('filesystems.disks.uploads.root');
	    		$name = Str::slug(str_replace($fileExt, '', $request->file('img')->getClientOriginalName()));
	    		$filename = rand(1,999).'-'.$name.'.'.$fileExt;
	    		$file_file = $upload_path.'/'.$path.'/'.$filename;

    			$product->file_path = date('Y-m-d');
    			$product->image = $filename;
    		endif;

    		$product->price =$request->input('price');
    		$product->in_discount = $request->input('indiscount');
    		$product->discount = $request->input('discount');
    		$product->description = e($request->input('content'));

    		if($product->save()):
    			if($request->hasFile('img')):
    				$fl =$request->img->storeAs($path, $filename, 'uploads');
    				$img = Image::make($file_file);
    				$img->fit(256,256,function($constraint){
    					$constraint->upsize();
    				});
    				$img->save($upload_path.'/'.$path.'/'.'/t_'.$filename);
    			endif;
    			return back()->with('message', 'Actualizado con exito')->with('typealert', 'success');
    		endif;
    	endif;
	}

}
