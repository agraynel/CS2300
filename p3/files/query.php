	<!--
	CREDITS: All of the photos and background are from my roommate, Chuan Huang
      I downloaded from his loft: http://akimotoyasushi.lofter.com/
      Others were sent to me from him by e-mail

    This is the query class page
    -->

<?php 
	Include("catalog.php");

	//Initialize the databse
	require_once 'config.php';
	
	class Query{
		private $connection;

		//query class CREDIT: lecture notes
		function __construct(){
			$this->connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

			//if Various fields in the mysqli object mysqli contain errors
			if ($this->connection->errno){
				echo "SQL connection error!";
				exit();
			}
		}

		//return all users whose name is matched
		function get_user($uName) {
			//echo '<pre>'.print_r("$uName", true).'</pre>';
			$query = "SELECT * FROM users WHERE (uName LIKE '".$uName."');";
			$result = $this->connection->query($query);
			$row = $result->fetch_row();
			$user = new Users($row[0], $row[1], $row[2]);
			return $user;
        }

		// return all albums in db
		function get_all_albums(){
			$albums = array();
			$sql = "SELECT * FROM albums;";
			$result = $this->connection->query($sql);
			while ( $row = $result->fetch_row() ){
				$album = new Albums($row[0], $row[1], $row[2], $row[3], $row[4]);
				$albums[] = $album;
			}
			return $albums;
		}

		// return all albums whose name match
		function get_all_albums_by_name($aName){
			$albums = array();
			$query = "SELECT * FROM albums WHERE (aName LIKE '%".$aName."%');";
			$result = $this->connection->query($query);
			while ( $row = $result->fetch_row() ){
				$album = new Albums($row[0], $row[1], $row[2], $row[3], $row[4]);
				$albums[] = $album;
			}
			return $albums;
		}

		// return all albums whose intro match
		function get_all_albums_by_intro($aIntro){
			$albums = array();
			$query = "SELECT * FROM albums WHERE (aIntro LIKE '%".$aIntro."%');";
			$result = $this->connection->query($query);
			while ( $row = $result->fetch_row() ){
				$album = new Albums($row[0], $row[1], $row[2], $row[3], $row[4]);
				$albums[] = $album;
			}
			return $albums;
		}

		// return all albums whose name and intro match
		function get_all_albums_by_nameintro($aName, $aIntro){
			$albums = array();
			$query = "SELECT * FROM albums WHERE ((aIntro LIKE '%".$aIntro."%') && (aName LIKE '%".$aName."%'));";
			$result = $this->connection->query($query);
			while ( $row = $result->fetch_row() ){
				$album = new Albums($row[0], $row[1], $row[2], $row[3], $row[4]);
				$albums[] = $album;
			}
			return $albums;
		}


		// return all photos by search
		function get_photos_by_search($searchName, $searchIntro, $album_id_array) {
			//CREDIT: http://stackoverflow.com/questions/5295714/array-in-sql-query
			$album_id = implode(", ", $album_id_array); //makes format
			if (empty($searchName)) {
				$searchName = "%";
			}
			if (empty($searchIntro)) {
				$searchIntro = "%";
			}
			if (empty($album_id_array)) {
				$album_id = 1;
			}
			
			$pID = array();
			$photos = array();
			$sql = "SELECT DISTINCT p.pID FROM ap a LEFT OUTER JOIN photos p ON a.pID = p.pID WHERE ((p.pName LIKE '%".$searchName."%') && (p.pIntro LIKE '%".$searchIntro."%') && (a.aID in ('$album_id')));";
			//get pID
			$result = $this->connection->query($sql);
			while ( $row = $result->fetch_row() ){
				$pID[] = $row[0];
			}
			$newpID = implode(", ", $pID); //makes format

			$sql1 = "SELECT * FROM photos WHERE pID IN ($newpID);";

			$result = $this->connection->query($sql1);
			while ( $row = $result->fetch_row() ){
				$photo = new Photos($row[0], $row[1], $row[2], $row[3], $row[4]);
				$photos[] = $photo;
			}
			//echo '<pre>'.print_r($photos, true).'</pre>';
			return $photos;
		}

		// return all photos.
		function get_all_photos(){
			$photos = array();
			$sql = "SELECT * FROM photos;";
			$result = $this->connection->query($sql);
			while ( $row = $result->fetch_row() ){
				$photo = new Photos($row[0], $row[1], $row[2], $row[3], $row[4]);
				$photos[] = $photo;
			}
			return $photos;
		}

		// return photo by photo id
		function get_photo_by_pid($pID){
			$sql = "SELECT * FROM photos WHERE pID = ".$pID.";";
			$result = $this->connection->query($sql);
			$row = $result->fetch_row();
			$photo = new Photos($row[0], $row[1], $row[2], $row[3], $row[4]);
			return $photo;
		}


		// return all photos in a specific album
		function get_photos($aID){
			$photos = array();
			$sql = "SELECT p.* FROM photos p INNER JOIN ap a ON p.pID = a.pID WHERE a.aID = ".$aID.";";
			$result = $this->connection->query($sql);
			while ( $row = $result->fetch_row() ){
				$photo = new Photos($row[0], $row[1], $row[2], $row[3], $row[4]);
				$photos[] = $photo;
			}
			return $photos;
		}

		// return the album with specific album id
		function get_album_by_aid($aID){
			$query = "SELECT * FROM albums WHERE aID = ".$aID.";";
			$result = $this->connection->query($query);
			$row = $result->fetch_row();
			$album = new Albums($row[0], $row[1], $row[2], $row[3], $row[4]);
			return $album;
		}

        // Milestone2: stmt
        // CREDIT: http://php.net/manual/en/class.mysqli-stmt.php

        function insert_album($album){
            $stmt = $this->connection->prepare("INSERT INTO albums(aName, aDateCreate, aDateModified, aIntro) VALUES (?,?,?,?)");
            //CREDIT: get today's date
            //http://stackoverflow.com/questions/470617/how-to-get-the-current-date-and-time-in-php
            $date = date('Y-m-d H:i:s');
            if ($stmt){
                //insert the album in its table
                $stmt->bind_param('ssss', $album->get_name(), $date, $date, $album->get_intro());
                $stmt->execute();
                $aID = $stmt->insert_id;
                $stmt->close();
                $this->connection->close();
                return true;
            }else{
                return false;
            }
        }
        
        //Milestone 2 does not use user
		function upload($photo, $albums){
            $stmt = $this->connection->prepare("INSERT INTO photos(pName, pDateCreate, pURL, pIntro) VALUES (?,?,?,?)");
            $date = date('Y-m-d H:i:s');
            if ($stmt){
                $stmt->bind_param('ssss', $photo->get_name(), $date, $photo->get_url(), $photo->get_intro());
                $stmt->execute();
                //echo '<pre>'.print_r("$stmt", true).'</pre>';
                $pID = $stmt->insert_id;
                //add all the pictures in the default album.
                array_push($albums, "1");
                //add photos to albums
                foreach ($albums as $aID){
                	$stmt1 = $this->connection->prepare("INSERT INTO ap(aID, pID) VALUES (?,?)");
                	$stmt1->bind_param('ii', $aID, $pID);
               		$stmt1->execute();
               		//echo '<pre>'.print_r("relation upload", true).'</pre>';
               		$stmt1->close();
            	}
                $stmt->close();
                $this->connection->close();
                return true;
            }else{
                return false;
            }
        }

        //delete album
		function delete_album($aID){
			echo '<pre>'.print_r("NOW DELETE!!!", true).'</pre>';
    		$query = new Query();
			$delete_connection = "DELETE FROM ap WHERE aID = ".$aID.";";
			$delete_album = "DELETE FROM albums WHERE aID = ".$aID.";";
			$result1 = $this->connection->query($delete_connection);
			$result2 = $this->connection->query($delete_album);
			return true;
		}

		//delete photo
		function delete_photo($pID){
    		$query = new Query();
			$delete_connection = "DELETE FROM ap WHERE pID = ".$pID.";";
			$delete_photo = "DELETE FROM photos WHERE pID = ".$pID.";";
			$result1 = $this->connection->query($delete_connection);
			$result2 = $this->connection->query($delete_photo);
			return true;
		}

		//delete photo
		function delete_photo_in_album($pID, $aID){
    		$query = new Query();
			$delete_connection = "DELETE FROM ap WHERE aID = " . $aID . " AND pID = ".$pID.";";
			$result1 = $this->connection->query($delete_connection);
			return true;
		}

		//edit album
		function edit_album($aID, $aName, $aIntro){
    		$query = new Query();
			$sql = "UPDATE albums SET aName = '" . $aName . "', aIntro = '" . $aIntro . "' WHERE aID = " . $aID .";";
			$result = $this->connection->query($sql);
			return true;
		}

		//edit photo
		function edit_photo($pID, $pName, $pIntro){
    		$query = new Query();
			$sql = "UPDATE photos SET pName = '" . $pName . "', pIntro = '" . $pIntro . "' WHERE pID = " . $pID .";";
			$result = $this->connection->query($sql);
			return true;
		}

		//Close connection to DB
		function close(){
			$this->connection->close();
		}
	}
?>