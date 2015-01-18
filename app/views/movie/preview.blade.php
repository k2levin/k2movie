@extends('master')

@section('content')

	<h2 align="center"><strong>{{{ $Movies->name.' '.$movie_year }}}</strong></h2>
	
	<hr />

	<!-- k2movie top banner ads -->
	<div class="row" align="center">
		<ins class="adsbygoogle"
		     style="display:inline-block;width:728px;height:90px"
		     data-ad-client="ca-pub-8589996867980267"
		     data-ad-slot="9014040638"></ins>
		<script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
	</div>
	<!-- /k2movie top banner ads -->

	<br />

	<div class="row" style="width: 888px; height:450px" align="right">
		<iframe src="{{{ $Movies->drive_link }}}"
			style="width: 95%; height:100%" frameborder="0" allowfullscreen></iframe>
	</div>

	<br /><br />

	<!-- k2movie btm social-like-share banner -->
    <div class="row" align="center">
        <div class="col-md-4"></div>
        <div class="col-md-2">
            <div class="fb-like" data-href="{{{ route('movie.preview', [$Movies->link]) }}}" data-layout="button" data-action="like" data-show-faces="false" data-share="true"></div>
        </div>
        <div class="col-md-2">
            <div class="g-plusone" data-annotation="none" data-href="{{{ route('movie.preview', [$Movies->link]) }}}"></div>
        </div>
        <div class="col-md-4"></div>
    </div>
    <!-- /k2movie btm social-like-share banner -->

	<br />

@stop