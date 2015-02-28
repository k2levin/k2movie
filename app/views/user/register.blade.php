@extends('master.user')

@section('title')

	<title>k2movie - Registration</title>

@stop

@section('content')

	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">

			<h2 align="center"><strong>Registration</strong></h2>

			<hr />

			@if($errors->first())
				<div class="alert alert-danger page-alert">
					{{{ $errors->first() }}}
				</div>
			@endif

			{{ Form::open(['route'=>'user.register', 'method'=>'post', 'role'=>'form']) }}
			  <div class="form-group">
			  	{{ Form::label('name', 'Name') }}
			  	{{ Form::text('name', Input::old('name'), ['class'=>'form-control', 'placeholder'=>'Enter name']) }}
			  </div>
			  <div class="form-group">
			  	{{ Form::label('email', 'Email') }}
			  	{{ Form::text('email', Input::old('email'), ['class'=>'form-control', 'placeholder'=>'Enter email']) }}
			  </div>
			  <div class="form-group">
			  	{{ Form::label('password', 'Password') }}
			  	{{ Form::password('password', ['class'=>'form-control', 'placeholder'=>'Enter password']) }}
			  </div>
			  <div class="form-group">
			  	{{ Form::label('password_confirmation', 'Confirm Password') }}
			  	{{ Form::password('password_confirmation', ['class'=>'form-control', 'placeholder'=>'Enter password again']) }}
			  </div>
			  <div class="g-recaptcha" data-sitekey="6Lc2mgITAAAAAHvgLQPofLKqN2fo0WJxS2BR_LV8"></div>
			  <br />
			  {{ Form::submit('Submit', ['class'=>'btn btn-primary']) }}
			  <a class="btn btn-primary" href="{{ route('home') }}" role="button">Cancel</a>
			{{ Form::close() }}

		</div>
		<div class="col-md-3"></div>
	</div>
	
@stop