<?php

class TestController extends BaseController {

	public function test_email()
	{
		$data = array();

		Mail::send('emails.test', $data, function($message) {
		    $message->to('k2lvn@yahoo.com', 'k2lvn')->subject('Testing Mail');
		});

		return View::make('testemail');
	}

}
