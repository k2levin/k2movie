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

    <div class="row">
        <div class="col-md-4">
        	<img src="{{{ '//cdn-k2movie.k2studio.net/img/'.$Movies->link.'.jpg' }}}" alt="{{{ $Movies->name }}}" width="214" heigh="300">
        </div>

        <div class="col-md-8">

            <!-- k2movie top social-like-share banner -->
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
            <!-- /k2movie top social-like-share banner -->

            <hr />

        	<p>{{{ $Movies->description }}}</p>

        	<br />

        	<a href="{{{ route('movie.preview', [$Movies->link]) }}}" target="_blank" class="btn btn-info">Watch this</a>

            <hr />

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

        </div>
    </div>

    <br />
    
@stop