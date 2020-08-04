@extends('admin.master')

@section('title', 'Agregar producto')

@section('breadcrumb')
<li class="breadcrumb-item">
	<a href="{{ url('/admin/products') }}"><i class="fas fa-boxes"></i> Productos</a>
</li>
<li class="breadcrumb-item">
	<a href="{{ url('/admin/products/add') }}"><i class="fas fa-plus"></i> Agregar productos</a>
</li>
@endsection

@section('content')
<div class="container-fluid">
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-plus"></i> Usuarios</h2>
		</div>

		<div class="inside">
			{{ !! Form::open(['url' => 'admin/products/add']) !! }}
		</div>
	</div>
</div>
@endsection