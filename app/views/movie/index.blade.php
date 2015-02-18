@extends('master.movie')

@section('title')

    <title>k2movie</title>

@stop

@section('content')

	@if(Session::has('flash_notice'))
		<div class="alert alert-info page-alert">
    		{{ Session::get('flash_notice') }}
	    </div>
	@endif

	@if($errors->first())
		<div class="alert alert-danger page-alert">
			{{ $errors->first() }}
		</div>
	@endif

	<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
		<ol class="carousel-indicators">
			<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
			<li data-target="#carousel-example-generic" data-slide-to="1"></li>
			<li data-target="#carousel-example-generic" data-slide-to="2"></li>
		</ol>
		<div class="carousel-inner" role="listbox">
			<div class="item active" align="center">
				<a href="{{{ route('movie.description', [$Carousel_Movies[0]->link]) }}}">
					<img src="{{{ '//cdn-k2movie.k2studio.net/img/'.$Carousel_Movies[0]->link.'.jpg' }}}" alt="Second slide" width="214" heigh="300">
				</a>
			</div>
			<div class="item" align="center">
				<a href="{{{ route('movie.description', [$Carousel_Movies[1]->link]) }}}">
					<img src="{{{ '//cdn-k2movie.k2studio.net/img/'.$Carousel_Movies[1]->link.'.jpg' }}}" alt="Second slide" width="214" heigh="300">
				</a>
			</div>
			<div class="item" align="center">
				<a href="{{{ route('movie.description', [$Carousel_Movies[2]->link]) }}}">
					<img src="{{{ '//cdn-k2movie.k2studio.net/img/'.$Carousel_Movies[2]->link.'.jpg' }}}" alt="Second slide" width="214" heigh="300">
				</a>
			</div>
		</div>
		<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
			<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
			<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
	</div>

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
	    @foreach($Movies as $Movie)
			<div class="col-md-2" align="center">
				<a href="{{{ route('movie.description', [$Movie->link]) }}}">
					<img src="{{{ '//cdn-k2movie.k2studio.net/img/'.$Movie->link.'.jpg' }}}" alt="{{{ $Movie->name }}}" width="110" heigh="154">
					<div class="movie-title-p">
						<p class="text-center">{{{ $Movie->name }}}</p>
					</div>
				</a>
				<br />
			</div>
		@endforeach
	</div>

	<!-- pagination link -->
	<div class="row pull-right">{{ $Movies->links() }}</div>

	<br />

@stop

@section('script')

	<script type="text/javascript">
        var maxHeight = 0;
        $('div.movie-title-p')
          .each(function() { maxHeight = Math.max(maxHeight, $(this).height()); })
          .height(maxHeight);
    </script>

@stop