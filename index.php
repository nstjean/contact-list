<?php
	// messages
	$msg = '';
	$msgClass = '';

	// check if submitted
	if(filter_has_var(INPUT_POST, 'submit')) {
		// get all form data
		$name = htmlspecialchars($_POST['name']);
		$email = htmlspecialchars($_POST['email']);
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
				$body = 'Contact Form<br>'.
					'Name: '.$name.'<br>'.
					'Email: '.$email.'<br>'.
					'Message: '.$message;
				$headers = 'MIME-Version: 1.0\r\n';
				$headers .= 'Content-Type:text/html;charset=UTF-8\r\n';
				$headers .= 'From: ' . $name . '<'.$email.'>\r\n';

				if(mail($toEmail, $subject, $body, $headers)) {
					$msg = 'Email has been sent';
					$msgClass = 'alert-success';
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