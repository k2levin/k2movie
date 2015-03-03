@extends('master.user')

@section('title')

	<title>k2movie - Remind Two Step Authentication</title>

@stop

@section('content')

	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">

			<h2 align="center"><strong>Remind Two Step Authentication</strong></h2>

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

			{{ Form::open(['route'=>'user.tsa.remind', 'method'=>'post', 'role'=>'form']) }}
			  <div class="form-group">
			  	{{ Form::label('email', 'Email') }}
			  	{{ Form::text('email', Input::old('email'), ['class'=>'form-control', 'placeholder'=>'Enter email']) }}
			  </div>
			  {{ Form::submit('Submit', ['class'=>'btn btn-primary']) }}
			  <a class="btn btn-primary" href="{{ route('user.tsa.login') }}" role="button">Cancel</a>
			{{ Form::close() }}

			<br />

		</div>
		<div class="col-md-3"></div>
	</div>

@stop
