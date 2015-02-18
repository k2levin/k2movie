@extends('master.movie')

@section('title')

    <title>k2movie - {{{ $field }}}</title>

@stop

@section('content')

	<h2 align="center"><strong>{{{ $field }}}</strong></h2>

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