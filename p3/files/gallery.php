<?php 
  include("header.php"); 
  include("query.php"); 
  
  //following are edit and delete pop up in gallery
  //CREDIT: https://www.w3schools.com/howto/howto_js_popup.asp
?>

<!--
CREDITS: All of the photos and background are from my roommate, Chuan Huang
    I downloaded from his loft: http://akimotoyasushi.lofter.com/
    Others were sent to me from him by e-mail
    Gallery page CREDITS: LECTURE NOTES
-->
<!-- display the gallery 
  CREDITS:  modified from search.php in my project 2
  CREDITS:  album diaplay in tranbox
            https://www.w3schools.com/css/tryit.asp?filename=trycss_transparency
-->

<!-- Albums Section: display albums -->
<a id="albums"></a>
<section class = "albums">
  <h2>ALBUMS</h2>
  <div class = "album_display">
    <?php
      $query0 = new Query(); 
      //get all the albums and display them on the gallery.php
      $albums = $query0->get_all_albums(); 
      foreach ($albums as $album){ 
        $aID = $album->get_id();
        $aName = $album->get_name(); 
        $aDateCreate = $album->get_date();
        $aDateModified = $album->get_dateModified();  
        $aIntro = $album->get_intro(); 
    ?>

      <div class="transbox">
<?php   
        echo '<a href = "gallery.php?id='.$aID.'#photos">'. $aName.'</a>'; 
        // if log in
        if (isset($_SESSION['logged_user'])) { 
          //no one can edit default album
          if ($aID != 1) {
?>
            <div class='edit_container'>
              <div class='edit_item'>
                 <?php echo " <button class = 'button' onclick = 'showEditAlbumPopup(" . $aID . ")'><h7 id='edit-album-" . $aID . "' data-album-title='" . $aName . "'>Edit Album</h7></button>" ?>
                <?php echo " <button class = 'button' onclick = 'showDeleteAlbumPopup(" . $aID . ")'><h7 id = '#$aID'>Delete Album</h7></button>" ?>
              </div>
            </div>

<?php
            }
          } else { // If no user is logged in
            print "<h7><a href='login.php'>Log in </a>to edit this album.</h7>";
          }
?>
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
    //if one of the albums is chosen
    if (isset($_GET['id'])) {
    //filter from lecture notes
    $id = preg_replace("/[^A-Za-z0-9 ]/", '', $_GET['id']); 
    if (!empty($id)){
      //display this album information:
      $query1 = new Query();
      //get this specific album
      //user function will be implemented in next miledstones
      $album = $query1-> get_album_by_aid($id); 
      $aName = $album->get_name(); 
      //json initialize
      $json0 = array($aName); 
      $jsons0 = $json0; 
      //debug: echo '<pre>'.print_r($aName, true).'</pre>';
  ?>
      <h3>Photos from album: <?php echo $aName ?></h3>
  <?php 
      $query2 = new Query();
      //get photos in this album
      $photos = $query2->get_photos($id);  
      $jsons = array(); //creates a json object to pass the image_list array to javascript
      //if there are photos in the album, display them


      if (!empty($photos)){
        echo "<div class = 'photo_display'>";
        //iterate all of the photos and create json to display them
        foreach ($photos as $photo){
          //use for debug: echo '<pre>'.print_r($photo, true).'</pre>';
          $pID = $photo->get_id(); 
          $pName = $photo->get_name(); 
          $pURL = $photo->get_url();  
          $pDate = $photo->get_date();  
          $pIntro = $photo->get_intro();
          //other information to be implemented in miletone 2
          //json initialize
          $json = array($pName, $pURL, $pDate, $pIntro);
          $jsons = $json; 
    ?>
        <!-- display photos and the content -->
        <div class='gallery_thumbnail'>
          <div class='photo_item'>
 
<?php 
            echo "<a href = 'gallery.php?photo_id= ".$pID."'><img class= 'image_container' id ='".$pID."' src = '../assets/".$pURL."' alt='".$pName."'></a>"; 
 ?>
          </div>
<?php 
            if (isset($_SESSION['logged_user']) && $id > 1) {

 ?> 
            <div class='edit_delete_button'>
              <?php echo "<button onclick='showDeletePhotoInAlbumPopup(" . $pID . ", ".$id.")'><h7 id='#".$pID."'>Remove</h7></button>" ; ?>
            </div>
            <?php } ?>
        </div>
<?php       
      }
 ?>    
      </div>
<?php
      } else {
        //upload function to be implemented in milestone2.
        echo "'<h4>No photos in the albums. Please <a href='add.php'>upload photos.</a></h4>'";
      }
    }
  } else if (isset($_GET['photo_id'])) {
          //echo '<pre>'.print_r($_GET['photo_id'], true).'</pre>';
          $jsons = array();
          $query2 = new Query();
          $pID = $_GET['photo_id'];
          $photo = $query2->get_photo_by_pid($pID);
          $pName = $photo->get_name(); 
          $pURL = $photo->get_url();  
          $pDate = $photo->get_date();  
          $pIntro = $photo->get_intro();

          $json = array($pName, $pURL, $pDate, $pIntro);
          $jsons = $json; 
?>

          <!-- for display descriptions-->
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

          if (isset($_SESSION['logged_user'])) { 
?>
            <div class='edit_container'>
              <div class='edit_item'>
                <?php echo "<button class='button' onclick='showEditPhotoPopup(" . $pID.")'><h7 id='edit_photo_".$pID."'>Edit Photo</h7></button>" ?>

                <?php echo "<button class='button' onclick='showDeletePhotoPopup(".$pID.")'><h7 id='##".$pID."'>Delete Photo</h7></button>" ?>
              </div>
            </div>
          </div>
<?php           
          }
  } else {
    echo "<h4>No album has been selected yet. Please select an album above.</h4>";
  }
?>
</div>


<!-- Edit and delete modal area -->
<?php
  // Delete album with id when Delete Album Form submitted
  if (isset($_POST['deleteAlbum'])) {
    $deleted_album_id = $_POST['deleteAlbumIdField'];
    if ($deleted_album_id != 1) {
      $query = new Query();
      //get photos in this album
      $query->delete_album($deleted_album_id); 
    }
  }

  if (isset($_POST['edit_album'])) {
    echo '<pre>'.print_r($pID, true).'</pre>';
    $aID = $_POST['edit_album_id'];
    $aName = htmlentities($_POST['edit_album_name']);
    $aIntro = htmlentities($_POST['edit_album_intro']);
    $query = new Query();
    $query->edit_album($aID, $aName, $aIntro);
  }

  // Edit photo when Edit Photo Form submitted
  if (isset($_POST['edit_photo'])) {
    $pID = $_POST['edit_photo_id'];
    $pName = htmlentities($_POST['edit_photo_name']);
    $pIntro = htmlentities($_POST['edit_photo_intro']);
    $query = new Query();
    $query->edit_photo($pID, $pName, $pIntro);
  }

  // Delete photo
  if (isset($_POST['delete_photo'])) {
    $pID = $_POST['delete_photo_id'];
    $query = new Query();
    $query->delete_photo($pID); 
  }


  // Delete photo from album when Delete Photo In Album Form submitted
  if (isset($_POST['remove_photo'])) {
    $pID = $_POST['remove_photo_pid'];
    $aID = $_POST['remove_photo_aid'];
    $query = new Query();
    $query->delete_photo_in_album($pID, $aID);
  }
?>

<!-- 
MODAL PART
    CREDIT:https://www.w3schools.com/tags/tryit.asp?filename=tryhtml5_input_type_hidden 
-->
<!-- delete album part -->
<div id='delete_album_popup' class='modal'>
  <div id='delete_album_content' class='modal-content'>
      <button class='close' onclick='closeDeleteAlbumPopup()'>×</button>
      <div class='popup-message-container'>
        <h7><b>WARNING:</b> YOU ARE GOING TO DELETE THIS ALBUM!</h7>
        <form class='form' name='delete_album_form' action='gallery.php' method='POST'>
          <input type='hidden' id='delete_album_id' name='delete_album_id' value='0'><br>
          <input type='submit' name='delete_album' value='delete'>
        </form>
      </div>
  </div>
</div>

<!-- Edit album part -->
<div id='edit_album_popup' class='modal'>
  <div id='edit_album_content' class='modal-content'>
      <button class='close' onclick='closeEditAlbumPopup()'>×</button>
      <div class='popup-message-container'>
        <h7>EDIT ALBUM:</h7>
          <form class='form' name='edit_album_form' action='gallery.php' onsubmit='return validEditAlbum();' method='POST'>
            <input type='hidden' id='edit_album_id' name='edit_album_id' value='0'><br>
            <h6>Input your new album name:</h6>
            <input id='edit_album_name' type='text' placeholder='Album Name' name='edit_album_name' maxlength='20'><br>
            <h6>Input your new album introduction:</h6>
            <input id='edit_album_intro' type='text' placeholder='Album introduction' name='edit_album_intro' maxlength='100'><br>
          <input type='submit' name='edit_album' value='EDIT'>
      </form>
        </div>
        <h3 id="edit_album_error" class="add_error_message"></h3>
  </div>
</div>

<!-- Remove photo from album part-->
<div id='remove_photo_popup' class='modal'>
  <div id='remove_photo_content' class='modal-content'>
      <button class='close' onclick='closeDeletePhotoInAlbumPopup()'>×</button>
      <div class='popup-message-container'>
        <h7><b>WARNING:</b> YOU ARE GOING TO REMOVE THIS PHOTO FROM THE ALBUM!</h7>
          <form class='form' name='remove_photo_form' action='gallery.php' method='POST'>
            <input type='hidden' id='remove_photo_pid' name='remove_photo_pid' value='0'><br>
            <input type='hidden' id='remove_photo_aid' name='remove_photo_aid' value='0'><br>
          <input type='submit' name='remove_photo' value='delete'>
      </form>
        </div>
  </div>
</div>

<!-- Delete photo part-->
<div id='delete_photo_popup' class='modal'>
  <div id='delete-photo-content' class='modal-content'>
      <button class='close' onclick='closeDeletePhotoPopup()'>×</button>
      <div class='popup-message-container'>
        <h7><b>WARNING:</b> YOU ARE GOING TO DELETE THIS PHOTO!</h7>
        <form class='form' name='delete_photo_form' action='gallery.php' method='POST'>
          <input type='hidden' id='delete_photo_id' name='delete_photo_id' value='0'><br>
          <input type='submit' name='delete_photo' value='delete'>
        </form>
      </div>
  </div>
</div>


<!-- Edit photo part-->
<div id='edit_photo_popup' class='modal'>
  <div id='edit_photo_content' class='modal-content'>
      <button class='close' onclick='closeEditPhotoPopup()'>×</button>
      <div class='popup-message-container'>
        <h7>Edit Photo:</h7>
          <form class='form' name='edit_photo_form' action='gallery.php' onsubmit='return validEditPhoto();' method='POST'>
            <input type='hidden' id='edit_photo_id' name='edit_photo_id' value='0'><br>
            <h6>Input your new photo name:</h6>
            <input id='edit_photo_name' type='text' placeholder='Photo Name' name='edit_photo_name' maxlength='20'><br>
            <h6>Input your new photo introduction:</h6>
            <input id='edit_photo_intro' type='text' placeholder='Photo introduction' name='edit_photo_intro' maxlength='100'><br>
          <input type='submit' name='edit_photo' value='EDIT'>
      
      </form>
        </div>
        <h3 id="edit_photo_error" class="add_error_message"></h3>
  </div>
</div>

  <!-- javascript: json
        CREDIT: http://www.jb51.net/article/30489.htm
  -->
  <script type="text/javascript">
    function get_album(){
      var jsons0 = <?php echo json_encode($jsons0); ?>;
    }

    function get_photos(){
      var jsons = <?php echo json_encode($jsons); ?>;
    }

  </script>

</section>
</body>
</html>