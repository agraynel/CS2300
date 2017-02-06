<?php include 'header.php' ?>
<!--
  This is Yi Chen(yc2329)'s work for CS 2300 project 1.
  This is mainly a personal website.
  CREDITS: web template credits to:
      the free template on website-templates website.
      www.website-templates.info
      I mainly refer to: http://www.website-templates.info/homepage/free-templates/03/1/page2.html#
      and http://www.website-templates.info/homepage/free-templates/04/1/index.html
--> 

  <?php

  // CREDITS: all the rabbit images are taken by myself.
  
  print "<div id='wow'>
      <div class='wow_container'>";
      //array of images and words, this is same format like about.php
        $wow_items = array(
          "Yaoyao likes eating vegetables and flowers in my garden.<br>She almost ruined everything she can reach in my garden.<br>My parents were mad about her:( <br>" =>'images/wow1.jpg',
          "Yaoyao has a sweet tooth. She eats one carrot and one cob of sweetcorn every day.<br> She is fond of watermelons and bananas.<br> Once she smelled the fragrance of banana peel, then she kicked down the rubbish bin to find the banana peel." =>'images/wow2.jpg',
          "Yaoyao can stand up! That is amazing! <br>Yaoyao can hop over 1 meter high." =>'images/wow3.jpg',
          "Yaoyao once digged a big hole on my mattress. <br>She likes jumping onto the bed or sofa. This makes her feel like a hostess." =>'images/wow4.jpg',
      );

        foreach ( $wow_items as $wow_description => $wow_image ) { ?>
              <div class='wow_item'>
                <?php echo '<img src="' . $wow_image . '">';?>
                <div class='wow_content'>
                  <p><?php echo $wow_description; ?></p>
              </div>
            </div>
          <div class="wow_divide"></div>
        <?php } ?>
<?php include 'footer.php' ?>