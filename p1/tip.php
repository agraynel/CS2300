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
    <!--
      CREDITS: this code comes from lecture2 in class CS2300
      Flexbox and php comes from
      http://tutorialzine.com/2016/04/5-flexbox-techniques-you-need-to-know-about  
      Some of the content about tips are from: https://www.saveafluff.co.uk/
      Others are written by myself, since I have fed my rabbit for 2 years.
    -->
    <?php 
      $titles = array(
        //tip array use flex display
          "Water " => "<br>Rumor has it that rabbits will die if they drink water. That is not true. The salers prevent them from drinking water so as to prevent them from growing, making them look cute and tiny.<br> Rabbits need water. We should provide unlimited fresh water to our rabbits, like purified water, distilled water or cold boiled water.",
          "Food: " => "<br>Rabbits need unlimited fresh hay and grass all day, as well as some vegetables. Pellets should be limited, because rabbits will get fat if they eat much(just lime mine)! They have sweet tooth, but those sweet food like carrots and fruits should be used as treats.",
          "Neutering: " => "<br>We should spay a female rabbit or neuter a male rabbit, which can prevent accidental pregnacies. <br> Unneutered rabbits become aggressive and fight with each other. And unneutered female rabbits are much more likely to develop uterine cancer.",
      );
    ?>
      <div class="tip_container">
        <?php foreach ($titles as $title => $description) { ?>
          <div class="tipflex">
              <h1><?php echo $title; ?></h1>
              <p><?php echo $description; ?></p>
          </div>
          <?php } ?>
      </div>
<?php include 'footer.php' ?>