<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title>Contact Me</title>
</head>
<body>
<h1>Contact Me</h1>
<?php # Script 10.1 - email.php

// Check for form submission:
if (isset($_POST['submitted'])) {

	// Minimal form validation:
	if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['comments']) ) {
	
		// Create the body:
		$body = "Name: {$_POST['name']}\n\nComments: {$_POST['comments']}";
		
		// Make it no longer than 70 characters long:
		$body = wordwrap($body, 70);
	
		// Send the email:
		mail('swovcs@gmail.com', 'Contact Form Submission', $body, "From: {$_POST['email']}");
		
		// Print a message:
		echo '<p><em>Thank you for contacting me. I will reply some day.</em></p>';
		
		// Clear $_POST (so that the form's not sticky):
		$_POST = array();
	
	} else {
		echo '<p style="font-weight: bold; color: #C00">Please fill out the form completely.</p>';
	}
	
} // End of main isset() IF.

// Create the HTML form:
?>
<p>Please fill out this form to contact me.</p>
<form action="email.php" method="post">
	<p>Name: <input type="text" name="name" size="30" maxlength="60" value="<?php if (isset($_POST['name'])) echo $_POST['name']; ?>" /></p>
	<p>Email Address: <input type="text" name="email" size="30" maxlength="80" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" /></p>
	<p>Comments: <textarea name="comments" rows="5" cols="30"><?php if (isset($_POST['comments'])) echo $_POST['comments']; ?></textarea></p>
	<p><input type="submit" name="submit" value="Send!" /></p>
	<input type="hidden" name="submitted" value="TRUE" />
</form>
</body>
</html>
