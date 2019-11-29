<?php
	/*ACcount class containing all the validation functions reqired for the the form validation.*/
	class Album {

		//Array variable containing the errors that would be generated form the validate function
		private $id;   
		private $con;
		private $title;
		private $artistId;
		private $genre;
		private $artworkPath;

		public function __construct($con, $id) {

			$this->con = $con;
			$this->id = $id; //Error array initiated once the account class is called.

			$query = mysqli_query($this->con, "SELECT * FROM albums WHERE id='$this->id'");
			$album = mysqli_fetch_array($query);

			$this->title = $album['title'];
			$this->artistId = $album['artist'];
			$this->genre = $album['genre'];
			$this->artworkPath = $album['artworkPath'];

		}

		public function getTitle() {
			return $this->title;
		}

		public function getArtist() {
			return new Artist($this->con, $this->artistId);
		}

		public function getGenre() {
			return $this->genre;
		}

		public function getArtworkPath() {
			return $this->artworkPath;
		}

		public function getNumberOfSongs() {
			$query= mysqli_query($this->con, "SELECT id FROM songs WHERE album='$this->id'");
			return mysqli_num_rows($query);
		}

		public function getSongIds() {
			$query = mysqli_query($this->con, "SELECT id FROM songs WHERE album='$this->id' ORDER BY albumOrder ASC");

			$array = array();

			while($row = mysqli_fetch_array($query)) {
				array_push($array, $row['id']);
			}

			return $array;
		}

		
	}