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
  print " <div class='about_container'>";
      //array of images and words, this is same format like wow.php
        $about_items = array(
          "The day she came to my home was 03/28/2015. Her name was Yaoyao.<br><br>" =>'images/about1.jpg',
          "And she grew bigger, but still adorable.<br><br><br>" =>'images/about2.jpg',
          "Yaoyao and me <3 <br><br><br>" =>'images/about3.jpg',
          "She became a giant and fat rabbit.<br><br><br>" =>'images/about4.jpg',
          "This her husband, a lionhead mix named Teddy. He is only 6 months old and currently in Canada.<br>CREDITS: image from my friend, Jenny.<br>" =>'images/about5.jpg',
          "Yaoyao is 2 years old, 1 meter long, and weights more than 6kg!<br><br>" =>'images/about6.jpg', 
      );

        foreach ( $about_items as $about_description => $about_image ) { ?>
            <div class='about'>
              <div class='about_image'>
                <?php echo '<img src="' . $about_image . '">';?>
              </div>
              <div class='about_description'>
                <h4><?php echo $about_description; ?></h4>
              </div>
            </div>
        <?php } ?>
    </div>
<?php include 'footer.php' ?>