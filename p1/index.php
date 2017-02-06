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


<div id="featured-area"> 
  <div class="index">
  <ul> 
    <li><img src="images/roundabout1.jpg"/></li>
    <li><img src="images/roundabout2.jpg"/></li>
    <li><img src="images/roundabout3.jpg"/></li>
    <li><img src="images/roundabout4.jpg"/></li>
    <li><img src="images/roundabout5.jpg"/></li>
    <li><img src="images/roundabout6.jpg"/></li>
  </ul>

<!--
    CREDITS: the jscript round-about code comes from B5 website:
    http://www.bcty365.com/;
-->

  <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
  <script type="text/javascript" src="js/jquery.roundabout-1.0.min.js"></script> 
  <script type="text/javascript" src="js/jquery.easing.1.3.js"></script> 
  <a href="javascript:void(0)" class="ban_l_btn"></a>
  <a href="javascript:void(0)" class="ban_r_btn"></a>
  <script type="text/javascript">     
  $(document).ready(function(){ 
    $('#featured-area ul').roundabout({
        easing: 'easeOutInCirc',
        duration: 1000,
         minScale: 0.3,
        btnPrev: ".ban_r_btn", // 右按钮
        btnNext: ".ban_l_btn" // 左按钮
    });
  });
  </script> 
  </div>
</div>

<hr noshade size="5">
<h4>Buttons are from B5website</h4>

<?php include 'footer.php' ?>