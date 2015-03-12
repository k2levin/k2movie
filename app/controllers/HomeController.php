<?php

class HomeController extends BaseController {

	public function mobile()
	{
		return View::make('mobile');
	}

	public function sitemap()
	{
		$content = file_get_contents(asset('download/sitemap.xml'));

		return Response::make($content, 200, ['content-type'=>'application/xml']);
	}

}