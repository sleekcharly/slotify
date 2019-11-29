<?php
	/*ACcount class containing all the validation functions reqired for the the form validation.*/
	class Account {

		//Array variable containing the errors that would be generated form the validate function
		private $errorArray;   

		private $con;

		public function __construct($con) {

			$this->con = $con;
			$this->errorArray = array(); //Error array initiated once the account class is called.

		}

		public function login($un, $pw) {
			$pw = md5($pw);

			$query = mysqli_query($this->con, "SELECT * FROM users WHERE username='$un' AND password='$pw'");

			if(mysqli_num_rows($query) == 1) {
				return true;
			}
			else {
				array_push($this->errorArray, Constants::$loginFailed);
				return false;
			}
		}

		public function register($un, $fn, $ln, $em, $em2, $pw, $pw2){

			$this->validateUsername($un);
			$this->validateFirstname($fn);
			$this->validateLastName($ln);
			$this->validateEmails($em, $em2);
			$this->validatePasswords($pw, $pw2);

			if(empty($this->errorArray)) {
				//Insert user details into database
				return $this->insertUserDetails($un, $fn, $ln, $em, $pw); 
			}
			else {
				return false;
			}
		}

		public function getError($error){

			//conditional statement that checks if the given error exists in the errorArray.
			if(!in_array($error, $this->errorArray)) {
				$error = "";
			}
			return "<span class='errorMessage'>$error</span>";
		}

		/*function responsible for inserting user details into database.*/
		private function insertUserDetails($un, $fn, $ln, $em, $pw) {
			$encryptedPw = md5($pw); // Encrypt user password
			$profilePic = "assets/images/profile-pics/profile.jpg";
			$date = date("Y-m-d");

			$result = mysqli_query($this->con, "INSERT INTO users VALUES('', '$un', '$fn', '$ln', '$em', '$encryptedPw', '$date', '$profilePic')");

			return $result;
		}

		private function validateUsername($un){
			//This checks that the characters are not less than 5or greater than 25
			if(strlen($un) > 25 || strlen($un) < 5) {
				array_push($this->errorArray, Constants::$usernameCharacters);
				return;
			}

			//This checks the database for already existing username
			$checkUsernameQuery = mysqli_query($this->con, "SELECT username FROM users WHERE username='$un'");
			if(mysqli_num_rows($checkUsernameQuery) != 0) {
				array_push($this->errorArray, Constants::$usernameTaken);
				return;
			}

		}

		private function validateFirstName($fn){

			if(strlen($fn) > 25 || strlen($fn) < 2) {
				array_push($this->errorArray, Constants::$firstNameCharacters);
				return;
			}
			
		}

		private function validateLastName($ln){

			if(strlen($ln) > 25 || strlen($ln) < 2) {
				array_push($this->errorArray, Constants::$lastNameCharacters);
				return;
			}
			
		}

		private function validateEmails($em, $em2){
			
			if($em != $em2) {
				array_push($this->errorArray, Constants::$emailsDoNotMatch);
				return;
			}

			/* This condition below checks that the email is in the correct format*/
			//FILTER_VALIDATE_EMAIL checks if the email entered is in the valid format.
			if(!filter_var($em, FILTER_VALIDATE_EMAIL)) {
				array_push($this->errorArray, Constants::$emailInvalid);
				return;
			}

			//This checks the database for already existing email
			$checkEmailQuery = mysqli_query($this->con, "SELECT email FROM users WHERE email='$em'");
			if(mysqli_num_rows($checkEmailQuery) != 0) {
				array_push($this->errorArray, Constants::$emailTaken);
				return;
			}
		}

		private function validatePasswords($pw, $pw2){
			//Check if the passwords match each other.
			if($pw != $pw2) {
				array_push($this->errorArray, Constants::$passwordsDoNotMatch);
				return;
			}

			/*The condition below checks for characters we don't want included in the password, 
			/[^A-Za-z0-9]/ means '^'not A-Z or a-z or 0-9 dont accept */
			if(preg_match('/[^A-Za-z0-9]/', $pw)) {
				array_push($this->errorArray, Constants::$passwordNotAlphanumeric);
				return;
			}

			if(strlen($pw) > 30 || strlen($pw) < 5) {
				array_push($this->errorArray, Constants::$passwordCharacters);
				return;
			}
			
		}
	}