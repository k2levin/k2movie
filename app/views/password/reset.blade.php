@extends('master.user')

@section('title')

	<title>k2movie - Password Reset</title>

@stop

@section('content')

	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">

			<h2 align="center"><strong>Password Reset</strong></h2>

			<hr />

			@if($errors->first())
				<div class="alert alert-danger page-alert">
					{{{ $errors->first() }}}
				</div>
			@endif

			{{ Form::open(['route'=>'user.password.reset', 'method'=>'post', 'role'=>'form']) }}
			  <div class="form-group">
			  	{{ Form::label('email', 'Email') }}
			  	{{ Form::text('email', Input::old('email'), ['class'=>'form-control', 'placeholder'=>'Enter email']) }}
			  </div>
			  <div class="form-group">
			  	{{ Form::label('password', 'Password') }}
			  	{{ Form::password('password', ['class'=>'form-control', 'placeholder'=>'Enter password']) }}
			  </div>
			  <div class="form-group">
			  	{{ Form::label('password_confirmation', 'Password Confirm') }}
			  	{{ Form::password('password_confirmation', ['class'=>'form-control', 'placeholder'=>'Confirm password']) }}
			  </div>
			  {{ Form::hidden('token', $token) }}
			  {{ Form::submit('Reset Password', ['class'=>'btn btn-primary']) }}
			{{ Form::close() }}

		</div>
		<div class="col-md-3"></div>
	</div>

@stop