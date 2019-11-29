<?php
	/*ACcount class containing all the validation functions reqired for the the form validation.*/
	class User {

		//Array variable containing the errors that would be generated form the validate function
		
		private $con;
		private $username;

		public function __construct($con, $username) {

			$this->con = $con;
			$this->username = $username;
			
		}

		public function getUsername() {
			return $this->username;
		}

		public function getEmail() {
			$query = mysqli_query($this->con, "SELECT email FROM users WHERE username='$this->username'");
			$row = mysqli_fetch_array($query);
			return $row['email'];
		}

		public function getFirstAndLastName() {
			$query = mysqli_query($this->con, "SELECT concat(firstName, ' ', lastName) as 'name' FROM users WHERE username='$this->username'");
			$row = mysqli_fetch_array($query);
			return $row['name'];
		}
	}
?>
