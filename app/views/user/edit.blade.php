@extends('master.user')

@section('title')

	<title>k2movie - Profile Update</title>

@stop

@section('content')

	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">

			<h2 align="center"><strong>Profile Update</strong></h2>

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

			{{ Form::open(['route'=>'user.profile.edit', 'method'=>'put', 'role'=>'form']) }}
			  <div class="form-group">
			  	{{ Form::label('name', 'Name') }}
			  	{{ Form::text('name', $name, ['class'=>'form-control', 'placeholder'=>'Enter name']) }}
			  </div>
			  @if($tsa_key_exists)
			  <div class="form-group">
			  	{{ Form::checkbox('remove_tsa', 'true', false) }}
			  	{{ Form::label('remove_tsa', '&nbsp;&nbsp;Remove Two Step Authentication') }}
			  </div>
			  @endif

			  <br />

			  {{ Form::submit('Submit', ['class'=>'btn btn-primary']) }}
			  <a class="btn btn-primary" href="{{ route('user.profile') }}" role="button">Cancel</a>
			{{ Form::close() }}

			<br />

		</div>
		<div class="col-md-3"></div>
	</div>

@stop
