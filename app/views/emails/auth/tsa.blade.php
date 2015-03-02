<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>k2movie - Remove Two Step Authentication</h2>
		
		<p>Greetings,</p>
		<br />
		<p>This email is sent to you because of requesting for your account's TSA removal.</p>
		<p>To remove your TSA, please click <a href="{{ URL::to('user/tsa/remove', array($tsa_token)) }}">HERE</a>.</p>
		<br/>
		<p>This link will expire in {{ Config::get('auth.tsa.expire', 60) }} minutes.</p>
		<br />
		<p>Sincerely,</p>
		<p><strong>k2movie</strong></p>
	</body>
</html>