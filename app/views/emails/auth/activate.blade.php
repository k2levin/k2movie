<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>k2movie - Account Activation</h2>
		
		<p>Greetings,</p>
		<br />
		<p>This email is sent to you because of requsting for your account activation.</p>
		<p>To activate your account, please click <a href="{{ URL::to('', array($abc)) }}">HERE</a>.</p>
		<br/>
		<p>This link will expire in {{ Config::get('auth.reminder.expire', 60) }} minutes.</p>
		<br />
		<p>Sincerely,</p>
		<p><strong>k2movie</strong></p>
	</body>
</html>