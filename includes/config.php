<?php 

	/*
	ob_start — Turn on output buffering
	This function will turn output buffering on. While output buffering is active no output is sent from the script (other than headers), instead the output is stored in an internal buffer.

	Think of ob_start() as saying "Start remembering everything that would normally be outputted, but don't quite do anything with it yet."There are two other functions you typically pair it with: ob_get_contents(), which basically gives you whatever has been "saved" to the buffer since it was turned on with ob_start(), and then ob_end_clean() or ob_flush(), which either stops saving things and discards whatever was saved, or stops saving and outputs it all at once, respectively.
	*/

	ob_start();
	session_start();

	$timezone = date_default_timezone_set("Africa/Lagos"); //Set timezone parameters.

	$con = mysqli_connect("sql2.freemysqlhosting.net","sql2324985","gW7%qR6%","sql2324985"); //Connect to database with database parameters

	//conditional to check if connection to database was successful.
	if(mysqli_connect_errno()) {
		echo "Failed to connect: ". mysqli_connect_errno();
	}
 ?>