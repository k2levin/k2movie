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

			<p>Name: {{{ $name }}}</p>
			<p>Email: {{{ $email }}}</p>

		</div>
		<div class="col-md-3"></div>
	</div>

@stop