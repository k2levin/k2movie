@extends('master.user')

@section('title')

	<title>k2movie - Resend Account Activation Email</title>

@stop

@section('content')

	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">

			<h2 align="center"><strong>Resend Account Activation Email</strong></h2>

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

			{{ Form::open(['route'=>'user.register_remail', 'method'=>'put', 'role'=>'form']) }}
			  <div class="form-group">
			  	{{ Form::label('email', 'Email') }}
			  	{{ Form::text('email', Input::old('email'), ['class'=>'form-control', 'placeholder'=>'Enter email']) }}
			  </div>
			  {{ Form::submit('Submit', ['class'=>'btn btn-primary']) }}
			  <a class="btn btn-primary" href="{{ route('home') }}" role="button">Cancel</a>
			{{ Form::close() }}

		</div>
		<div class="col-md-3"></div>
	</div>

@stop
