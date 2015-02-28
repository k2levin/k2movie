<?php

class HomeController extends BaseController {

	public function mobile()
	{
		// Redirect to this route if device detected mobile browser
		return View::make('mobile');
	}

	public function sitemap()
	{
		$content = file_get_contents(asset('download/sitemap.xml'));

		return Response::make($content, 200, ['content-type'=>'application/xml']);
	}

}