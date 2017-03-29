<?php 
  include("header.php"); 
  include("query.php"); 
?>	
	<!--
	CREDITS: All of the photos and background are from my roommate, Chuan Huang
      I downloaded from his loft: http://akimotoyasushi.lofter.com/
      Others were sent to me from him by e-mail
    -->

<!-- Search Form -->
<div class="add_body">

	<!-- search albums -->
	<div class="form_container">
	<h1>Search Albums</h1>
	<form id="search_album_form" name="search_album_form" class="form" method="POST" action="search.php">
		<!-- Search and name fields -->
		<div class="form_item">
		 	<h6>Album name: </h6>
			<input id="search_album_name" type="text" placeholder="Search name" name="search_album_name" maxlength="20">
		</div>
		<div class="form_item">
		 	<h6>Album introduction: </h6>
			<input id="search_album_intro" type="text" placeholder="Search introduction" name="search_album_intro" maxlength="100">
		</div>
		<div class="form_item">
            <input id = "search_album" class="button" type = "submit" name = "search_album" value = "SEARCH"/> 
        </div>
	</form>
	</div>

	<!-- search photos -->
	<div class="form_container">
	<h1>Search Photos</h1>
	<form id="search_photo_form" name="search_photo_form" class="form" method="POST" action="search.php">
		<!-- Search and name fields -->
		<div class="form_item">
			 <h6>Photo name: </h6>
			<input id="search_photo_name" type="text" placeholder="Search name" name="search_photo_name" maxlength="20">
		</div>
		<div class="form_item">
		 	<h6>Photo introduction: </h6>
			<input id="search_photo_intro" type="text" placeholder="Search introduction" name="search_photo_intro" maxlength="100">
		</div>
		<div class="form_item">
		 	<h6>Albums: </h6>
		 	<?php 
		 		//display all albums here excepts default album(all photos)!
		 	 	$query3 = new Query();  
                $all_albums = $query3->get_all_albums(); 
                foreach ($all_albums as $album){
                	$album_id = $album->get_id();
                	//this is the default album, will not displayed here. All photos will go into this album
                	if ($album_id == 1) continue;
                	echo "<input type = 'checkbox' name = 'photos_in_albums[]' value =".$album_id.">". $album->get_name() ."<br>";  
                } 
			?>
		</div>
		<div class="form_item">
            <input id = "search_photo" class="button" type = "submit" name = "search_photo" value = "SEARCH"/> 
        </div>
	</form>
	</div>


<!-- display the gallery 
  CREDITS:  modified from gellery.php in my project 3
  CREDITS:  album diaplay in tranbox
            https://www.w3schools.com/css/tryit.asp?filename=trycss_transparency
-->

<!-- Albums Section: display albums -->
<a id="albums"></a>
<section class = "albums">
  	<h2>ALBUMS</h2>
  	<div class = "album_display">
 	<?php
 	//this is the search album response
	// Search Functionality modified from my project 2

 	  //display all albums
      $query0 = new Query(); 
      //get all the albums and display them on the gallery.php
      $albums = $query0->get_all_albums(); 

		//if search album submit
		if (isset($_POST['search_album'])) {
			//filter the input to prevent html interruption
			$searchName = isset($_POST['search_album_name']) ? htmlentities($_POST['search_album_name']) : false;
			$searchIntro = isset($_POST['search_album_intro']) ? htmlentities($_POST['search_album_intro']) : false;
			
			//if search name and search intro both have been set
			if (!empty($searchName) && !empty($searchIntro)) {
				$albums = $query0->get_all_albums_by_nameintro($searchName, $searchIntro); 
			} else if (!empty($searchName)) {
			//search name set and search intro empty
				$albums = $query0->get_all_albums_by_name($searchName);
			} else if (!empty($searchIntro)) {
			//search intro set and search name empty
				$albums = $query0->get_all_albums_by_intro($searchIntro);
			} else {
			//both empty
				$albums = $query0->get_all_albums(); 
			}

		}

      foreach ($albums as $album){ 
        $aID = $album->get_id();
        $aName = $album->get_name(); 
        $aDateCreate = $album->get_date();
        $aDateModified = $album->get_dateModified();  
        $aIntro = $album->get_intro(); 
    ?>

      <div class="transbox">
      <?php echo '<a>'. $aName.'</a>'; ?>
        <h3><br>Create on: <?php echo $aDateCreate ?></h3>
        <h3>Modified on: <?php echo $aDateModified ?></h3>
        <h4><?php echo $aIntro ?></h4>
      </div>
    <?php } ?>
  </div>
</section>

<!--divide albums and photos -->
<div id='divider1'></div>

<a id="photos"></a>
  <section id= "gallery">
  <h2>Photos</h2>
  <div class = "gallery_display">
  <?php 

      $query2 = new Query();
      //get photos in this album
      $photos = $query2->get_all_photos();  
      //$jsons = array(); //creates a json object to pass the image_list array to javascript
      //if there are photos in the album, display them

      //if search photos submit
		if (isset($_POST['search_photo'])) {
			//filter
			$searchName = isset($_POST['search_photo_name']) ? htmlentities($_POST['search_photo_name']) : false;
			$searchIntro = isset($_POST['search_photo_intro']) ? htmlentities($_POST['search_photo_intro']) : false;
			$album_id_array = array();
			//by default, search album is false
			$searchAlbum = false;
			if (isset($_POST['photos_in_albums'])) {
				//if search album, it is true
				$searchAlbum = true;
          foreach($_POST['photos_in_albums'] as $album_id){
            $album_id_array[] = $album_id;
          }
      }
      $photos = $query2->get_photos_by_search($searchName, $searchIntro, $album_id_array); 
    }


      if (!empty($photos)){
        echo "<div class = 'search_display'>";
        //iterate photos
        foreach ($photos as $photo){
          //use for debug: echo '<pre>'.print_r($photo, true).'</pre>';
          $pName = $photo->get_name(); 
          $pURL = $photo->get_url();  
          $pIntro = $photo->get_intro();
          $pDate = $photo->get_date();
          //other information to be implemented in miletone 2
          //json initialize
          //$json = array($pName, $pURL, $pIntro);
          //$jsons = $json;  
    ?>
        <!-- display photos and the content -->
        <div class='gallery_thumbnail1'>
          <div class='photo_item1'>
          <!-- for display photos-->
          <div class='display'>
          <div class='photo_description'>
            <div class='show_description'>
              <h3 class='name'><?php echo $pName ?></h3>
            </div>
            <div class='hide_description'>
              <h5 class='description'><?php echo "Date taken: ".$pDate ?></h5>
              <h5 class='description'><?php echo $pIntro ?></h5>
            </div>
          </div>
<?php
          echo "<img class= 'image_origin' src='../assets/" . $pURL . "' alt='" . $pName . "'>";
?>
          </div>
        </div>
      <?php } 
      echo "</div>";
      } else {
        //upload function to be implemented in milestone2.
        echo "'<h4>No match photos!</h4>'";
      }

  ?>
  </div>
  <!-- javascript: json
        CREDIT: http://www.jb51.net/article/30489.htm

  <script type="text/javascript">
    function get_album(){
      var jsons0 = <?php echo json_encode($jsons0); ?>;
    }

    function get_photos(){
      var jsons = <?php echo json_encode($jsons); ?>;
    }
  </script>
  -->
</section>
</body>
</html>