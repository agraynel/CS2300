<!--
CREDITS: All of the photos and background are from my roommate, Chuan Huang
    I downloaded from his loft: http://akimotoyasushi.lofter.com/
    Others were sent to me from him by e-mail
    Gallery page CREDITS: LECTURE NOTES
-->

<!-- header and setup -->


<?php 
	include("header.php"); 
	include("query.php");		
?>

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
      <?php echo '<a href = "gallery.php?id='.$aID.'#photos">'. $aName.'</a>'; ?>
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
  <section id= "photo">
  <h2>Photos</h2>
  <div class = "photo_display">
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
      <h3 class='name'>Photos from album: <?php echo $aName ?></h3>
  <?php 
      $query2 = new Query();
      //get photos in this album
      $photos = $query2->get_photos($id);  
      $jsons = array(); //creates a json object to pass the image_list array to javascript
      //if there are photos in the album, display them
      if (!empty($photos)){
        //iterate all of the photos and create json to display them
        foreach ($photos as $photo){
          //use for debug: echo '<pre>'.print_r($photo, true).'</pre>';
          $pName = $photo->get_name(); 
          $pURL = $photo->get_url();  
          $pIntro = $photo->get_intro();
          //other information to be implemented in miletone 2
          //json initialize
          $json = array($pName, $pURL, $pIntro);
          $jsons = $json;  
    ?>
        <!-- display photos and the content -->
        <div class='photo_item'>
          <!--divide different photos -->
          <div id='divider2'></div>

          <!-- for display descriptions-->
          <!-- will implement other information in milestone 2-->          
          <div class='photo_description'>
            <div class='show_description'>
              <h3 class='name'><?php echo $pName ?></h3>
            </div>
            <div class='hide_description'>
              <h4 class='description'><?php echo $pIntro ?></h4>
            </div>
          </div>

          <!-- for display photos-->
          <?php echo '<img class="image_container" img src="../assets/' . $pURL . '" alt = $pURL>';?>
        </div>
      <?php } 
      } else {
        //upload function to be implemented in milestone2.
        echo "'<h4>No photos in the albums. Please upload photos.</h4>'";
      }
      }
      }else{
        echo "'<h4>No album has been selected yet. Please select an album above.</h4>'";
      }
  ?>
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