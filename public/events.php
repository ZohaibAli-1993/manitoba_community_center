<?php
//title and page variables
$title = 'Manitoba Community Center';
$page = 'Events';
//include files
include __DIR__ . '/../config/config.php';
include __DIR__ . '/../inc/header.inc.php';
include __DIR__ . '/../inc/main_nav.inc.php';
include __DIR__ . '/../inc/slider.inc.php';
?>  

    <!-- Subscribe grid-->
      <div id="grad1"> 

          <form method="post"
                action="#"
                autocomplete="on" accept-charset="utf-8" id="subscribe-blog"> 

            <p>Subscribe to our newsletter.
                <input type="text" placeholder="Email address" name="mail" required>
                <input type="submit" id="submit" name="Subscribe" value="Subscribe"> 
            </p>
          </form>
      </div>

      <main>   
    <!-- Events-->  
        <h1><?=$page ?></h1>
        <div id="container-gallery"> 
        <div id="gallery1">
        <div class="gallery">
          <a target="_blank" href="../images/event-image1.jpg">
            <img src="images/event-image1.jpg" alt="training">
          </a>
          <div class="desc">Training Sesssion <button onclick="document.getElementById('id01').style.display='none'" class="cancelbtn"  ><a href="user_registration.php" >Registration</a></button></div>
        </div>
        </div> 
        <div id="gallery2">
        <div class="gallery">
          <a target="_blank" href="../images/event-image2.jpg">
            <img src="images/event-image2.jpg" alt="Northern Lights">
          </a>
            <div class="desc">Sports Event <button id="reg7" ><a href="../public/user_registration.php" >Registration</a></button></div>
        </div> 
        </div>

        <div id="gallery3">
        <div class="gallery"> 

          <a target="_blank" href="../images/event-image3.jpg">
            <img src="images/event-image3.jpg" alt="Information">
          </a>
          <div class="desc">Information Session and Social gathering <button ><a href="../public/user_registration.php" >Registration</a></button></div>
        </div> 
        </div> 
        <div id="gallery4">
        <div class="gallery"> 

          <a target="_blank" href="../images/event-meeting.jpg">
            <img src="images/event-meeting.jpg" alt="Meetings">
          </a>
          <div class="desc">Community Meetings <button id="reg6" ><a href="../public/user_registration.php" >Registration</a></button></div>
        </div> 
        </div>

        <div id="fitness">
        <div class="gallery">
          <a target="_blank" href="../images/event-fitness.jpg">
            <img src="images/event-fitness.jpg" alt="fitness" >
          </a>
            <div class="desc">Fitness Session <button id="reg2" ><a href="../public/user_registration.php" >Registration</a></button></div>
        </div>  
        </div> 
        <div id="music">
        <div class="gallery">
          <a target="_blank" href="../images/event-music.jpg">
            <img src="images/event-music.jpg" alt="Music" >
          </a>
          <div class="desc">Music Charity Event <button id="reg5" ><a href="../public/user_registration.php" >Registration</a></button></div>
        </div>  
        </div>
        <div class="gallery">
          <a target="_blank" href="/images/charity-marathon.jpg">
            <img src="images/charity-marathon.jpg" alt="Marathon">
          </a>
          <div class="desc">Community Marathon <button id="reg3" ><a href="../public/user_registration.php" >Registration</a></button></div>
        </div> 
        <div id="children">
        <div class="gallery">
          <a target="_blank" href="/images/children.jpg">
            <img src="images/children.jpg" alt="charity" >
          </a>
          <div class="desc">Children Charity  <button id="reg4" ><a href="../public/user_registration.php" >Registration</a></button></div>
        </div> 
        </div>
        </div>
        
      </main> 
     <!--php include footer -->
    <?php include __DIR__ . '/../inc/footer.inc.php'; ?>  
