@extends('admin.master')

@section('title', 'Usuario')

@section('breadcrumb')
<li class="breadcrumb-item">
	<a href="{{ url('/admin/users') }}"><i class="fas fa-user-friends"></i> Usuarios</a>
</li>
@endsection

@section('content')
<div class="container-fluid">
	<div class="panel shadow">
		<div class="header">
			<h2 class="title"><i class="fas fa-user-friends"></i> Usuarios</h2>
		</div>

		<div class="inside row">
			<table class="col-md-10 table">
				<thead>
					<tr>
						<td>Id</td>
						<td>Nombre</td>
						<td>Apellido</td>
						<td>Email</td>
						<td></td>
					</tr>
				</thead>
				<tbody>
					@foreach($users as $user)
					<tr>
						<td>{{ $user->id }}</td>
						<td>{{ $user->name }}</td>
						<td>{{ $user->lastname }}</td>
						<td>{{ $user->email }}</td>
						<td>
							<div class="opts">
								<a href="{{ url('/admin/user/'.$user->id.'/edit') }}" data-toggle="tooltip" data-placement="top" title="Editar">
									<i class="fas fa-pen"></i>
								</a>
								<a href="{{ url('/admin/user/'.$user->id.'/delete') }}" data-toggle="tooltip" data-placement="top" title="Eliminar">
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