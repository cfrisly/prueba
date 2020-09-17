@extends('admin.master')

@section('title', 'Productos')

@section('breadcrumb')
<li class="breadcrumb-item">
	<a href="{{ url('/admin/products') }}"><i class="fas fa-boxes"></i> Productos</a>
</li>
@endsection

@section('content')
<div class="container-fluid">
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-boxes"></i> Usuarios</h2>
		</div>

		<div class="inside">
			<div class="btns">
				<a href="{{ url('/admin/products/add') }}" class="btn btn-primary">
					<i class="fas fa-plus"></i> Editar producto
				</a>
			</div>
			<table class="table table-striped col-md-10 mtop16">
				<thead>
					<tr>
						<td>ID</td>
						<td>Imagen</td>
						<td>Nombre</td>
						<td>Categoria</td>
						<td>Precio</td>
						<td></td>
					</tr>
				</thead>
				<tbody>
					@foreach($products as $p)
						<tr>
							<td width="50">{{ $p->id }}</td>
							<td width="64">
								<a href=" {{ url('/uploads/'.$p->file_path.'/'.$p->image) }} " data-fancybox="gallery">
									<img src=" {{ url('/uploads/'.$p->file_path.'/t_'.$p->image) }} " width="46" alt="">
								</a>
							</td>
							<td>{{ $p->name}}</td>
							<td>{{ $p->cat->name }}</td>
							<td>{{ $p->price}}</td>
							<td>
								<div class="opts">
									<a href="{{ url('/admin/products/'.$p->id.'/edit') }}" data-toggle="tooltip" data-placement="top" title="Editar">
										<i class="fas fa-pen"></i>
									</a>
									<a href="{{ url('/admin/products/'.$p->id.'/delete') }}" data-toggle="tooltip" data-placement="top" title="Eliminar">
										<i class="fas fa-trash"></i>
									</a>
								</div>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection