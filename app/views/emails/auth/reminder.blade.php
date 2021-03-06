<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>k2movie - Password Reset</h2>
		
		<p>Greetings,</p>
		<br />
		<p>This email is sent to you because of requesting for your password reset.</p>
		<p>To reset your password, please click <a href="{{ URL::to('user/password/reset', array($token)) }}">HERE</a>.</p>
		<br/>
		<p>This link will expire in {{ Config::get('auth.reminder.expire', 60) }} minutes.</p>
		<br />
		<p>Sincerely,</p>
		<p><strong>k2movie</strong></p>
	</body>
</html>