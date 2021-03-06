<?php 
  session_start(); 
  //this is the header for session pages
?>
<!DOCTYPE html>

<html>

	<head>
		<meta charset="utf-8">
    	<link rel="stylesheet" type="text/css" href="../css/stylesheet.css">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    	<script src = "../js/validation.js"></script>
      <script src="../js/modalPopup.js"></script>
		<title>H.c photography</title>
	</head>

	<body>
<!--
  This is Yi Chen(yc2329)'s work for CS 2300 project 3 milestone3.
  This is a personal photography web[age for my roommate, Chuan Huang 
	CREDITS: All of the photos are from my roommate, Chuan Huang
      I downloaded from his loft: http://akimotoyasushi.lofter.com/
      Others were sent to me from him by e-mail
  CREDITS: this page is modified from header.php in my project 2.
-->
 
    <!-- Navigation Bar -->
    <h1>H.c Photography</h1>
    <div id='navigation'>
      <a title="home" href="../index.php"> HOME</a>
      <a title="gallery" href="gallery.php"> GALLERY</a>
      <a title="login" href="login.php"> LOGIN</a>
      <a title="add" href="add.php"> ADD</a>
      <a title="search" href="search.php"> SEARCH</a>
    </div>  
    <div id='divider'></div>
    <h5>CREDITS: All images from Chuan Huang.</h5>
    <div id='divider2'></div>
<?php 
    if ( isset( $_SESSION[ 'logged_user' ] ) ) {
      echo "<h5>Welcome, ". $_SESSION[ 'logged_user' ] . "</h5>";  
    } else {
      echo "<h5>You are not logged in!</h5>";  
    }
?>