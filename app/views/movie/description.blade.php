@extends('master')

@section('content')

	<h2 align="center"><strong>{{{ $Movies->name.' '.$movie_year }}}</strong></h2>

    <hr />

    <!-- k2movie top banner ads -->
    <div class="row" align="center">
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <ins class="adsbygoogle"
             style="display:inline-block;width:728px;height:90px"
             data-ad-client="ca-pub-8589996867980267"
             data-ad-slot="9014040638"></ins>
        <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>
    <!-- /k2movie top banner ads -->

    <br />

    <div class="row">
        <div class="col-md-4">
        	<img src="{{{ asset('/img/'.$Movies->link.'.jpg') }}}" alt="{{{ $Movies->name }}}" width="214" heigh="300">
        </div>

        <div class="col-md-8">

            <!-- k2movie top banner social-like-share-box -->
            <div class="row" align="center">
                <div class="col-md-3"></div>
                <div class="col-md-2">
                    <div class="fb-like" data-href="{{{ route('movie.preview', [$Movies->link]) }}}" data-layout="button" data-action="like" data-show-faces="false" data-share="true"></div>
                </div>
                <div class="col-md-2">
                    <div class="g-plus" data-action="share" data-annotation="bubble" data-href="{{{ route('movie.preview', [$Movies->link]) }}}"></div>
                </div>
                <div class="col-md-2">
                    <div class="g-plusone" data-annotation="inline" data-width="300" data-href="{{{ route('movie.preview', [$Movies->link]) }}}"></div>
                </div>
                <div class="col-md-3"></div>
            </div>
            <!-- /k2movie top banner social-like-share-box -->

            <hr />

        	<p>{{{ $Movies->description }}}</p>

        	<br />

        	<a href="{{{ route('movie.preview', [$Movies->link]) }}}" target="_blank" class="btn btn-info">Watch this</a>

            <hr />

            <!-- k2movie btm banner social-like-share-box -->
            <div class="row" align="center">
                <div class="col-md-3"></div>
                <div class="col-md-2">
                    <div class="fb-like" data-href="{{{ route('movie.preview', [$Movies->link]) }}}" data-layout="button" data-action="like" data-show-faces="false" data-share="true"></div>
                </div>
                <div class="col-md-2">
                    <div class="g-plus" data-action="share" data-annotation="bubble" data-href="{{{ route('movie.preview', [$Movies->link]) }}}"></div>
                </div>
                <div class="col-md-2">
                    <div class="g-plusone" data-annotation="inline" data-width="300" data-href="{{{ route('movie.preview', [$Movies->link]) }}}"></div>
                </div>
                <div class="col-md-3"></div>
            </div>
            <!-- /k2movie btm banner social-like-share-box -->

        </div>
    </div>

    <br />
    
@stop