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

			@if(Session::has('flash_notice'))
				<div class="alert alert-info page-alert">
		    		{{ Session::get('flash_notice') }}
			    </div>
			@endif

			@if($errors->first())
				<div class="alert alert-danger page-alert">
					{{{ $errors->first() }}}
				</div>
			@endif

			{{ Form::open(['route'=>'user.login2', 'method'=>'post', 'role'=>'form']) }}
				<fieldset disabled>
					<div class="form-group">
					{{ Form::label('email', 'Email') }}
					{{ Form::text('email', Session::get('email'), ['class'=>'form-control', 'id'=>'disabledTextInput', 'placeholder'=>'Enter email']) }}
					</div>
				</fieldset>
				{{ Form::hidden('email', $email) }}
				<div class="form-group">
					{{ Form::label('password', 'Password') }}
					{{ Form::password('password', ['class'=>'form-control', 'placeholder'=>'Enter password']) }}
				</div>
				<div class="form-group">
					{{ Form::checkbox('remember_me', 'true', true) }}
					{{ Form::label('remember_me', '&nbsp;&nbsp;Remember me') }}
				</div>
				@if(isset($login_trial_at))
					<div class="g-recaptcha" data-sitekey="6Lc2mgITAAAAAHvgLQPofLKqN2fo0WJxS2BR_LV8"></div>
					<br />
				@endif
				{{ Form::submit('Submit', ['class'=>'btn btn-primary']) }}
				<a class="btn btn-primary" href="{{ route('home') }}" role="button">Cancel</a>
			{{ Form::close() }}

			<br />

			<p><a href="{{ route('user.password.remind') }}">Forgot Password?</a></p>

		</div>
		<div class="col-md-3"></div>
	</div>

@stop
