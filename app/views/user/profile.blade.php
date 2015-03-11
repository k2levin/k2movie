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
				<tr>
					<td align="right">Country: </td>
					<td>{{{ $country }}}</td>
				</tr>
			</table>

			<br />

			@if(!$exists_tsa_key)
			<p><a class="btn btn-info btn-sm" href="{{ route('user.tsa.setup') }}" role="button">Enable</a> Two Step Authentication</p>
			<br />
			@endif

			<a class="btn btn-primary" href="{{ route('user.profile.edit') }}" role="button">Edit</a>
			<a class="btn btn-primary" href="{{ route('home') }}" role="button">Cancel</a>

		</div>
		<div class="col-md-3"></div>
	</div>

@stop