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


		// return all photos in all the albums.
		function get_all_photos(){
			$photos = array();
			$sql = "SELECT * FROM photos;";
			$result = $this->connection->query($sql);
			while ( $row = $result->fetch_row() ){
				$photo = new Photos($row[0], $row[1], $row[2], $row[3], $row[4], $row[5]);
				$photos[] = $photo;
			}
			return $photos;
		}

		// return all photos in a specific album
		function get_photos($aID){
			$photos = array();
			$sql = "SELECT p.* FROM photos p INNER JOIN ap a ON p.pID = a.pID WHERE a.aID = ".$aID.";";
			$result = $this->connection->query($sql);
			while ( $row = $result->fetch_row() ){
				$photo = new Photos($row[0], $row[1], $row[2], $row[3], $row[4], $row[5]);
				$photos[] = $photo;
			}
			return $photos;
		}

		// return all photos with specific user id
		// to be implemented in milestone 2
		function get_photos_by_uid($uID){
			$query = "SELECT * FROM photos WHERE uID = ".$uID.";";
			$result = $this->connection->query($query);
			$row = $result->fetch_row();
			$photo = new Photos($row[0], $row[1], $row[2], $row[3], $row[4], $row[5]);
			return $photo;
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
            $stmt = $this->connection->prepare("INSERT INTO photos(pName, pDateCreate, pURL, pIntro, uID) VALUES (?,?,?,?,?)");
            $date = date('Y-m-d H:i:s');
            if ($stmt){
                $stmt->bind_param('sssss', $photo->get_name(), $date, $photo->get_url(), $photo->get_intro(), $photo->get_userid());
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

		//Close connection to DB
		function close(){
			$this->connection->close();
		}
	}
?>