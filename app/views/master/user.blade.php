<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

    @yield('title')

		<!-- using Bootswatch - Spacelab -->
		<link href="//maxcdn.bootstrapcdn.com/bootswatch/3.3.1/spacelab/bootstrap.min.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>

    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

    <!-- social plugins script -->
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=1017727724907570&version=v2.0";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <!-- /script for social plugins -->

		<div class="container">

      <!-- navbar -->
      <div class="bs-component">
        <div class="navbar navbar-default">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{{ route('home') }}}"><strong>k2movie</strong></a>
          </div>
          <div class="navbar-collapse collapse navbar-responsive-collapse">
            <ul class="nav navbar-nav">
              <li align="center"><a href="{{{ route('home') }}}">Home</a></li>
              <li align="center" class="active"><a href="{{{ route('movie.filter', ['latest', '1']) }}}">Latest</a></li>
              <li align="center"><a href="{{{ route('movie.filter', ['popular', '1']) }}}">Popular</a></li>
              <div align="center" class="navbar-form navbar-left">
                {{ Form::model(null, ['route' => ['movie.search']]) }}
                <div class="form-group">
                  {{ Form::text('query', null, ['placeholder' => 'Search', 'class' => 'form-control col-lg-8']) }}
                </div>
                {{ Form::button('<i class="fa fa-search"></i>', ['type' => 'submit', 'class' => 'btn btn-info']) }}
                {{ Form::close() }}
              </div>
              <div align="center" class="navbar-form navbar-left">
                <!-- k2movie fb follow button -->
                <div class="fb-follow" data-href="https://www.facebook.com/k2movie" data-colorscheme="light" data-layout="button" data-show-faces="false"></div>
                <!-- /k2movie fb follow button -->
              </div>
              <div align="center" class="navbar-form navbar-left">
                <!-- k2movie g+ follow button -->
                <div class="g-follow" data-annotation="none" data-height="20" data-href="//plus.google.com/u/0/111168861419019938542" data-rel="publisher"></div>
                <!-- /k2movie g+ follow button -->
              </div>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              @if(Auth::check())
                <li align="center" class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-user fa-lg"></i> User
                    <b class="caret"></b>
                  </a>
                  <ul class="dropdown-menu">
                    <li class="text-center">
                      <a href="{{{ route('user.profile') }}}"><i class="fa fa-info fa-lg"></i> Profile</a>
                    </li>
                    <li class="divider"></li>
                    <li class="text-center">
                      <a href="{{{ route('user.logout') }}}"><i class="fa fa-sign-out fa-lg"></i> Logout</a>
                    </li>
                  </ul>
                </li>
              @else
                <li align="center">
                  <a href="{{{ route('user.login') }}}"><i class="fa fa-sign-in fa-lg"></i> Login</a>
                </li>
                <li align="center">
                  <a href="{{{ route('user.register') }}}"><i class="fa fa-user-plus fa-lg"></i> Register</a>
                </li>
              @endif
            </ul>
          </div>
        </div>
      </div>
      <!-- /navbar -->

      @yield('content')

		</div>

    <br />
    <br />
    <br />

    <!-- footer -->
    <footer class="footer navbar-default navbar-fixed-bottom">
      <div class="container">
          <br />
          <ul class="list-inline">
            <li>
              <a href="{{{ route('home') }}}">
                <i class="fa fa-home fa-2x"></i>
              </a>
            </li>
            <li>
              <a href="https://www.facebook.com/k2movie" target="_blank">
                <i class="fa fa-facebook-square fa-2x"></i>
              </a>
            </li>
            <li>
              <a href="https://plus.google.com/u/0/111168861419019938542" target="_blank">
                <i class="fa fa-google-plus-square fa-2x"></i>
              </a>
            </li>
            <li class="pull-right">
              <p>Developed by <a href="http://www.k2studio.net" target="_blank">k2studio</a></p>
            </li>
          </ul>
      </div>
    </footer>
    <!-- /footer -->
		
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

    @yield('script')

	</body>
</html>
