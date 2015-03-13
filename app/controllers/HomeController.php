<?php

class HomeController extends BaseController {

	public function mobile()
	{
		return View::make('mobile');
	}

	public function sitemap()
	{
		$content = file_get_contents('http://cdn-k2movie.k2studio.net/download/sitemap-2015-03-06.xml');

		return Response::make($content, 200, ['content-type'=>'application/xml']);
	}

}
