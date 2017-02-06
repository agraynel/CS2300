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
    

    <!-- Check whether the form is valid
         CREDITS: http://www.zuimoban.com/wangye/php/php_forms.html#@f=demo_php_form_post
                  and CS2300 slides
                  and CS2300 Section2:
                  https://piazza-resources.s3.amazonaws.com/iy7lf5qn2hw6nz/iyrldu2xa8u7i4/solution.php?AWSAccessKeyId=AKIAIEDNRLJ4AZKBW6HA&Expires=1486361415&Signature=Ch%2FVp6paachmZJ0dCpM7sro6p8U%3D
    -->
    <?php      
      // Check the completeness
      if (isset($_POST["name"]) && isset($_POST["question"])) {
        $name = $_POST["name"];
        $textcontent = $_POST["question"];
        $reply = "Hello {$name}, I have received your question about rabbits. I will update soon <3";
        if ($name == "" || $textcontent == "") {
          $reply = "Please fill in the blank.";
        } else if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
          $reply = "{$name} is not a valid name.";
        } 
      } else {
        $reply = "Feel free to ask me questions about rabbits <3";
      }
    ?> 

    <div id="faq_container">
      <div class="faq">
        <!-- FAQ part -->
        <h1>FAQ</h1>
        <h3>How long can a rabbit survive?</h3>
        <h4>Rabbits can survive as long as 8 - 10 years.</h4>
        <h3>How to litter train a rabbit?</h3>
        <h4>Rabbits should be trained ASAP. </h4>
        <h3>Are rabbits smelly?</h3>
        <h4>Rabbits are clean animals. <br>If they eat healthily, they are not smelly at all!</h4>
        <h3>How to treat a rabbit bite?</h3>
        <h4>Rabbits don't bring rabies,<br>just treat it like normal wounds. </h4>
        <h3>Does a rabbit need company?</h3>
        <h4>Rabbits don't like living together,<br>they will fight if they are not neutered.<br> You are their best company!</h4>
      </div> 
      <div id="faq-divide"></div>

      <div class="question_container">
        <!-- This is the part to ask questions to me
             CREDITS: code from cs2300 slides!
        -->
        <h1>Any questions?</h1>
        <!-- CREDITS: http://www.w3schools.com/Tags/att_input_placeholder.asp-->
        <form class="question" action="faq.php" method="POST">
          <input type="text" name="name" placeholder="Your name"><br>
          <textarea name="question" placeholder="Your question"></textarea><br>
          <input type="submit" name="submit" value="Submit">
        </form>
        <h3><br><?php echo $reply ?></h3>
      </div>
    </div>

<?php include 'footer.php' ?>