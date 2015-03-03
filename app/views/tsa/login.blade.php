@extends('master.user')

@section('title')

	<title>k2movie - Login Two Step Authentication</title>

@stop

@section('content')

	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">

			<h2 align="center"><strong>Login Two Step Authentication</strong></h2>

			<hr />

			@if($errors->first())
				<div class="alert alert-danger page-alert">
					{{{ $errors->first() }}}
				</div>
			@endif

			{{ Form::open(['route'=>'user.tsa.login', 'method'=>'post', 'role'=>'form', 'class'=>'form-horizontal']) }}
				<div class="form-group">
					{{ Form::label('verification_code', 'Verification_Code: ', ['class'=>'col-sm-3 control-label']) }}
					<div class="col-sm-9">
						{{ Form::text('verification_code', Input::old('verification_code'), ['class'=>'form-control', 'placeholder'=>'Enter tsa verification code']) }}
					</div>
				</div>
				{{ Form::hidden('email', Session::get('email')) }}
				{{ Form::hidden('password', Session::get('password')) }}
				{{ Form::hidden('remember_me', Session::get('remember_me')) }}
				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-9">
						{{ Form::submit('Submit', ['class'=>'btn btn-primary']) }}
						<a class="btn btn-primary" href="{{ route('user.login') }}" role="button">Cancel</a>
					</div>
				</div>
			{{ Form::close() }}

			<br />

			<p><a href="{{ route('user.tsa.remind') }}">Having problem with TSA?</a></p>

		</div>
		<div class="col-md-3"></div>
	</div>

@stop