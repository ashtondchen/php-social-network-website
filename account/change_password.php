<?php # change_password.php
// This page allows a logged-in user to change their password.

//require_once ('../includes/config.inc.php'); 
$page_title = 'change_password';
if (!isset($_GET['tp']))
	include('../includes/header.inc.html');
else
	include('../includes/ini.inc.php');

// If no first_name session variable exists, redirect the user:
if (!isset($_SESSION['first_name'])) {
	
	$url = BASE_URL . 'index.php'; // Define the URL.
	ob_end_clean(); // Delete the buffer.
	header("Location: $url");
	exit(); // Quit the script.
	
}

if (isset($_POST['submitted'])) {
	require_once (MYSQL);
			echo "yes";
	// Check for a new password and match against the confirmed password:
	$p = FALSE;
	if (preg_match ('/^(\w){4,20}$/', $_POST['password1']) ) {
		if ($_POST['password1'] == $_POST['password2']) {
			$p = mysqli_real_escape_string ($dbc, $_POST['password1']);
		} else {
			echo '<p class="error">Your password did not match the confirmed password!</p>';
		}
	} else {
		echo '<p class="error">Please enter a valid password!</p>';
	}
	
	if ($p) { // If everything's OK.

		// Make the query.
		$q = "UPDATE users SET pass=SHA1('$p') WHERE user_id={$_SESSION['user_id']} LIMIT 1";	
		$r = @mysqli_query ($dbc, $q) ;//or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
		if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.
		
			// Send an email, if desired.
			echo '<h3>Your password has been changed.</h3>';
			mysqli_close($dbc); // Close the database connection.
			include ('../includes/footer.html'); // Include the HTML footer.
			exit();
			
		} else { // If it did not run OK.
		
			echo '<p class="error">Your password was not changed. Make sure your new password is different than the current password. Contact the system administrator if you think an error occurred.</p>'; 

		}

	} else { // Failed the validation test.
		echo '<p class="error">Please try again.</p>';		
	}
	
	mysqli_close($dbc); // Close the database connection.

} // End of the main Submit conditional.

?>

<h1>Change Your Password</h1>
<form id="myform" action="../account/change_password.php" method="post">
	<fieldset>
	<p><b>New Password:</b> <input type="password" name="password1" size="20" maxlength="20" title="Use only letters, numbers, and the underscore. Must be between 4 and 20 characters long." /></p>
	<p><b>Confirm New Password:</b> <input type="password" name="password2" size="20" maxlength="20" /></p>
	</fieldset>
	<div align="center"><input class="button" type="submit" name="submit" value="Change My Password" /></div>
	<input type="hidden" name="submitted" value="TRUE" />
</form>
<!-- Form Tooltip -->
<link rel="stylesheet" type="text/css" href="../library/tooltip/ftp.css" />
<script type="text/javascript" src="../library/tooltip/tools.js"></script>
<script type="text/javascript" src="../library/tooltip/ftp.js"></script>

<?php
 if (!isset($_GET['tp']))
	include('../includes/footer.inc.html');
else
	ob_end_flush();
?>
