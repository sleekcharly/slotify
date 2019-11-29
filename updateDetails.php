<?php 
include("includes/includedFiles.php");
?>

<div class="userDetails">
	
	<div class="container borderBottom">
		<h2>EMAIL</h2>
		<input type="text" name="email" class="email" placeholder="Email address..." value="<?php echo $userLoggedIn->getEmail(); ?>">
		<span class="message"></span>
		<button class="button" onclick="updateEmail('email')">SAVE</button>
	</div>

	<div class="container">
		<h2>PASSWORD</h2>
		<input type="password" name="oldPassword" class="oldPassword" placeholder="Current password">
		<input type="password" name="newPaswword1" class="newPassword1" placeholder="New password">
		<input type="password" name="newPassword2" class="newPassword2" placeholder="Confirm password">
		<span class="message"></span>
		<button class="button" onclick="updatePassword('oldPassword', 'newPassword1', 'newPassword2')">SAVE</button>
	</div>

</div>