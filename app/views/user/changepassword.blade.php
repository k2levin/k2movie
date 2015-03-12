@extends('master.user')

@section('title')

	<title>k2movie - Change Password</title>

@stop

@section('content')

	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">

			<h2 align="center"><strong>Change Password</strong></h2>

			<hr />

			@if($errors->first())
				<div class="alert alert-danger page-alert">
					{{{ $errors->first() }}}
				</div>
			@endif

			{{ Form::open(['route'=>'user.profile.password.edit', 'method'=>'put', 'role'=>'form']) }}
			  <div class="form-group">
			  	{{ Form::label('old_password', 'Old Password') }}
			  	{{ Form::password('old_password', ['class'=>'form-control', 'placeholder'=>'Enter old password']) }}
			  </div>
			  <div class="form-group">
			  	{{ Form::label('new_password', 'New Password') }}
			  	{{ Form::password('new_password', ['class'=>'form-control', 'placeholder'=>'Enter new password']) }}
			  </div>
			  <div class="form-group">
			  	{{ Form::label('new_password_confirmation', 'Confirm New Password') }}
			  	{{ Form::password('new_password_confirmation', ['class'=>'form-control', 'placeholder'=>'Enter new password again']) }}
			  </div>
			  <br />
			  {{ Form::submit('Submit', ['class'=>'btn btn-primary']) }}
			  <a class="btn btn-primary" href="{{ route('home') }}" role="button">Cancel</a>
			{{ Form::close() }}

			<br />

		</div>
		<div class="col-md-3"></div>
	</div>
	
@stop