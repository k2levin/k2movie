@extends('master.user')

@section('title')

	<title>k2movie - Profile</title>

@stop

@section('content')

	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">

			<h2 align="center"><strong>Profile</strong></h2>

			<hr />

			<table class="table table-hover">
				<tr>
					<td align="right">Name: </td>
					<td>{{{ $name }}}</td>
				</tr>
				<tr>
					<td align="right">Email: </td>
					<td>{{{ $email }}}</td>
				</tr>
			</table>

		</div>
		<div class="col-md-3"></div>
	</div>

@stop