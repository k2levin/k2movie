@extends('master.user')

@section('title')

	<title>k2movie - Setup Two Step Authentication</title>

@stop

@section('content')

	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">

			<h2 align="center"><strong>Setup Two Step Authentication</strong></h2>

			<hr />

			<p><strong>Two Step Authentication</strong>, <strong>TSA</strong> is a simple best practice that adds an extra layer of protection on top of your user name and password.</p>
			<p>Please install the <strong>TSA</strong> application for your smartphone from the application store that is specific to your smart phone type.</p>

			<br />

			<table class="table table-hover table-condensed">
				<tr>
					<td align="right">Android</td>
					<td><a href="http://support.google.com/accounts/bin/answer.py?hl=en&answer=1066447" target="_blank">Google Authenticator</a></td>
				</tr>
				<tr>
					<td align="right">iPhone</td>
					<td><a href="http://itunes.apple.com/us/app/google-authenticator/id388497605?mt=8" target="_blank">Google Authenticator</a></td>
				</tr>
				<tr>
					<td align="right">Windows Phone</td>
					<td><a href="http://www.windowsphone.com/en-us/store/app/authenticator/e7994dbc-2336-4950-91ba-ca22d653759b" target="_blank">Authenticator</a></td>
				</tr>
				<tr>
					<td align="right">Blackberry</td>
					<td><a href="http://www.google.com/support/accounts/bin/answer.py?answer=1066447" target="_blank">Google Authenticator</a></td>
				</tr>
			</table>

			<p>If your <strong>TSA</strong> application supports scanning QR codes, please scan then following QR image</p>

			<div align="center">
				<img src="{{{ $qr_link }}}" alt="QR image">
			</div>

			<br />

			<a class="btn btn-default btn-xs" data-toggle="collapse" href="#hide_key" aria-expanded="false" aria-controls="hide_key"> OR manually enter Secret Configuration Key</a>
			<div class="collapse" id="hide_key">
				<p>Type the secret configuration key below into <strong>TSA</strong> app</p>
				<div class="well">
					<p>{{{ $google2fa_key }}}</p>
				</div>
			</div>

			<br /><br />

			<p>After the application done configured, please enter the authentication code provided by the application and click <strong>Activate</strong> button</p>

			@if($errors->first())
				<div class="alert alert-danger page-alert">
					{{{ $errors->first() }}}
				</div>
			@endif

			{{ Form::open(['route'=>'user.tsa.setup', 'method'=>'post', 'role'=>'form', 'class'=>'form-horizontal']) }}
				<div class="form-group">
			  	{{ Form::label('verification_code', 'Verification_Code: ', ['class'=>'col-sm-3 control-label']) }}
			  	<div class="col-sm-9">
			  		{{ Form::text('verification_code', Input::old('verification_code'), ['class'=>'form-control', 'placeholder'=>'Enter Verification Code']) }}
			  	</div>
			  </div>
			  {{ Form::hidden('google2fa_key', $google2fa_key) }}
			  <div class="form-group">
			  	<div class="col-sm-offset-3 col-sm-9">
			  		{{ Form::submit('Submit', ['class'=>'btn btn-primary']) }}
			  		<a class="btn btn-primary" href="{{ route('user.profile') }}" role="button">Cancel</a>
			  	</div>
			  </div>
			{{ Form::close() }}

			<br />

		</div>
		<div class="col-md-3"></div>
	</div>

@stop