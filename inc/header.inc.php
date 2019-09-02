<?php 
/* 
*@author Zohaib Ali 
*Instructor Steve George 
*Assignement 2 
*Object Oriented PHP 
*/
?><!doctype html>

<html lang="en">
  <head> 
  <!-- dynamiclly changning the title text--> 
    <title><?= $title ?></title>
    <meta charset="utf-8" />
    <meta name="description" content="Manitoba Community Center" />
    <link rel="icon" type="image/png" href="images/favicon.png" /> 
    <!--Tab Icon-->
    <link rel="apple-touch-icon" sizes="144x144" href="images/apple-icon-144x144.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="images/apple-icon-114x114.png" />
    <meta property="og:type" content="Website" />
    <meta property="og:title" content="Manitoba Community Center" />
    <meta property="og:description" content="This a Community Website" />
    <meta property="og:site_name" content="Manitoba Community Center" />
    <meta property="og:image:width" content="960" />
    <meta property="og:image:height" content="630" />
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">   
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <link rel="stylesheet"
          href="style/mobile.css"
          type="text/css"
          media="screen and (max-width: 767px)"
     /> 
    
    <link rel="stylesheet"
          href="style/style.css"
          type="text/css"
          media="screen and (min-width: 768px)"
     />  
     <link rel="stylesheet"
          href="style/print.css"
          type="text/css"
          media="print"
     />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">  
    <link href="https://fonts.googleapis.com/css?family=Courgette%7cPrompt" rel="stylesheet">  
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

      <!-- dynamiclly changning the text page name-->  
    <?php if ('Home' == $page) {
        include 'embedded_style.inc';
    } ?> 
    <?php if ('Contact' == $page) {
        include 'contact_embedded_style.inc';
    } ?> 
    <?php if ('Events' == $page) {
        include 'events_embedded_style.inc';
    } ?> 
    <?php if ('Volunteer' == $page) {
        include 'volunteer_embedded_style.inc';
    } ?> 
    <?php if ('News' == $page) {
        include 'news_embedded_style.inc';
    } ?>
    <?php if ('Events Registration' == $page) {
        include 'registration.inc';
    } ?> 
    <?php if ('Registering Information' == $page) {
        include 'registering_info.inc';
    } ?>   
     <?php if ('List View' == $page) {
        include 'list.inc';
    } ?>

    <?php if ('Events Profile' == $page) {
        include 'event_show_style.inc';
    } ?> 
        <?php if ('Event Register' == $page) {
        include 'event_register.inc';
    } ?>
    <!-- Conditional comments for IE browsers -->

        <!--[if LTE IE 8]>
          <link rel="stylesheet" href="old_ie.css" type="text/css" />
        <![endif]-->
    <script src="old_ie.js"></script>
  </head> 
    <body>
    <header> 
    <!--Header -->
      <div id="inner_header" >  
    <!-- Mobile Navigation-->  
         <nav id="mob-nav">
         <a href="#" id="menubutton">
          <span id="topbar"></span>
          <span id="middlebar"></span>
          <span id="bottombar"></span>
        </a>
        <ul id="navlist">
          <li><a href="index.php">Home</a></li>

          <li class="has_submenu"><a href="#">Services &amp; Such</a>
            <ul class="submenu">
              <li><a href="volunteer.php">Volunteer</a></li>
              <li><a href="events_view.php">Events</a></li>
              <li><a href="#">Trainings</a></li>
              <li><a href="#">Seminars</a></li>

            </ul>
          </li> 
          <li><a href="News.php">News</a></li>
          <li><a href="#">Careers</a></li>
          <li><a href="contact.php">Contact</a></li>
        </ul>
    <!-- Utility Navigation for Desktop-->
        </nav>
        <div id="utility-nav">
          <ul>   
          <li> <input type="text" id="topnav" placeholder="Search.."></li>
            <?php if (empty($_SESSION['user_id'])) :?> 
            <li>
              <a href="login.php">Login</a>
            </li>
           <li><a href="user_registration.php">Register</a></li> 
            <?php else :?> 
           <li id='profile'><a href="show_registration.php">Profile</a></li> 
           <li id='logout'><a href="login.php?logout=1">Logout</a></li> 
            <?php endif; ?>
           <li><a href="#language"><img src="images/canada.png" alt="Lnguages"/></a></li>
          </ul> 
        </div>  
    <!-- Desktop logo-->      
        <img src="images/logo.png" id ="logo" alt="logo"/> 
    <!-- Mobile Logo-->
        <img src="images/mob-logo.png" id ="mob-logo" alt="logo"/> 
        <div id="logo-text" >  
          <p>Manitoba Community Center</p>
        </div>  
    <!--Mobile Header -->    
        <div id="mob"> 
        
        <input type="text" id="topnav1" placeholder="Search..">  
        <button id="login1" onclick="document.getElementById('id01').style.display='block'"><img src="images/logo-2.jpg" alt="signin"/></button>
       
        </div>   
    <!--Login page-->
    
             
      </div>
    </header>
