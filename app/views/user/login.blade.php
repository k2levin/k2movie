@extends('master.user')

@section('title')

	<title>k2movie - Login</title>

@stop

@section('content')

	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">

			<h2 align="center"><strong>Login</strong></h2>

			<hr />

			@if(Session::has('flash_error'))
				<div class="alert alert-danger page-alert">
		    		{{ Session::get('flash_error') }}
			    </div>
			@endif

			{{ Form::open(['route'=>'user.login', 'method'=>'post', 'role'=>'form']) }}
			  <div class="form-group">
			  	{{ Form::label('email', 'Email') }}
			  	{{ Form::text('email', Input::old('email'), ['class'=>'form-control', 'placeholder'=>'Enter email']) }}
			  </div>
			  <div class="form-group">
			  	{{ Form::label('password', 'Password') }}
			  	{{ Form::password('password', ['class'=>'form-control', 'placeholder'=>'Enter password']) }}
			  </div>
			  <div class="form-group">
			  	{{ Form::checkbox('remember_me', 'true') }}
			  	{{ Form::label('remember_me', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Remember me') }}
			  </div>
			  {{ Form::submit('Submit', ['class'=>'btn btn-primary']) }}
			{{ Form::close() }}

			<br />

			<p><a href="{{ route('user.password.remind') }}">Forgot Password?</a></p>

		</div>
		<div class="col-md-3"></div>
	</div>

@stop
