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

			<br />

			<p>
				<a class="btn btn-info btn-sm" href="{{ route('user.tsa.setup') }}" role="button">
					@if($exists_google2fa_key)
						Edit
					@else
						Enable
					@endif
				</a> Two Step Authentication
			</p>

		</div>
		<div class="col-md-3"></div>
	</div>

@stop