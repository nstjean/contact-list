<?php
	// messages
	$msg = '';
	$msgClass = '';

	// check if submitted
	if(filter_has_var(INPUT_POST, 'submit')) {
		// get all form data
		$name = strip_tags($_POST['name']);
		$email = strip_tags($_POST['email']);
		$message = htmlspecialchars($_POST['message']);

		if(!empty($email) && !empty($name) && !empty($message)) {
			// all fields are present
			if(filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
				$msg = 'Email must be a valid email address';
				$msgClass = "alert-danger";
			} else {
				// passed validation, send email
				$toEmail = 'natalie.stjean@gmail.com';
				$subject = 'PHP Contact Form From ' . $name;
				
				$body = '<h2>Contact Form</h2><br>'."\r\n";
				$body .= 'Name: '.$name.'<br>'."\r\n";
				$body .= 'Email: '.$email.'<br>'."\r\n";
				$body .= 'Message: '.$message;

				$headers = [];
				$headers[] = 'MIME-Version: 1.0';
				$headers[] = 'Content-Type: text/html; charset=ISO-8859-1';
				$headers[] = 'From: ' . $name . '<'.$email.'>';

				if(mail($toEmail, $subject, $body, $headers)) {
					$msg = 'Email has been sent';
					$msgClass = 'alert-success';
					$name = '';
					$email = '';
					$message = '';
				} else {
					$msg = 'Error sending email';
					$msgClass = 'alert-danger';
				}
			}

		} else {
			// something is missing
			$msg = 'All fields are required';
			$msgClass = "alert-danger";
		}
	}

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>PHP Contact Form</title>
	<link href="bootstrap.min.css" rel="stylesheet">
</head>
<body>

	<nav class="nav navbar-dark bg-primary">
		<div class="m-1 mx-3">
			<a class="navbar-brand" href="#">Contact Form</a>
		</div>
	</nav>

	<div class="container my-3">

		<?php if($msg != ''): ?>
			<div class="alert <?php echo $msgClass; ?>">
				<?php echo $msg; ?>
			</div>
		<?php endif ?>

		<div class="row">
			<div class="col-lg-4 col-sm-2 col-xs-0">
			</div>
			<div class="col-lg-4 col-sm-8 col-xs-12">
				<form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" name="name" class="form-control" value="<?php echo isset($_POST['name']) ? $name : '' ?>">
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<input type="text" name="email" class="form-control" value="<?php echo isset($_POST['email']) ? $email : '' ?>">
					</div>
					<div class="form-group">
						<label for="message">Message</label>
						<textarea name="message" class="form-control"><?php echo isset($_POST['message']) ? $message : '' ?></textarea>
					</div>
					<input type="submit" name="submit" class="btn btn-primary">
				</form>
			</div>
			<div class="col-lg-4 col-sm-2 col-xs-0">
			</div>
		</div>
	</div>
</html>