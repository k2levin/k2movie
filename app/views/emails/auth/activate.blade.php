<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>k2movie - Account Activation</h2>
		
		<p>Greetings,</p>
		<br />
		<p>This email is sent to you because of requesting for your account activation.</p>
		<p>To activate your account, please click <a href="{{ URL::to('user/activate', array($confirmation_code)) }}">HERE</a>.</p>
		<br/>
		<p>Sincerely,</p>
		<p><strong>k2movie</strong></p>
	</body>
</html>