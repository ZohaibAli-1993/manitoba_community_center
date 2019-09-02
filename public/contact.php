<?php
//PHP varibales
$title = 'Manitoba Community Center';
$page = 'Contact';
  //includer for header and navigation
include __DIR__ . '/../config/config.php';
include __DIR__ . '/../inc/header.inc.php';
include __DIR__ . '/../inc/main_nav.inc.php';
include __DIR__ . '/../inc/slider.inc.php'; ?> 
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
    <!-- Contact Form-->
      <main>  
       <div class="container2">
        <div style="text-align:center">
            <h1><?=$page ?></h1>

          </div>
          <div class="row">
            <div class="column">
              <img src="images/map.JPG" style="width:100%" alt="map">
            </div>
            <div class="column">
              <form method="post"
                action="http://www.scott-media.com/test/form_display.php"
                autocomplete="on">
                <label for="fname">First Name</label>
                <input type="text" id="fname" name="firstname" placeholder="Your name..">
                <label for="lname">Last Name</label>
                <input type="text" id="lname" name="lastname" placeholder="Your last name..">
                <label for="country">Country</label>
                <select id="country" name="country">
                  <option value="australia">Australia</option>
                  <option value="canada">Canada</option>
                  <option value="usa">USA</option>
                </select>
                <label for="subject">Subject</label>
                <textarea id="subject" name="subject" placeholder="Write something.." style="height:170px"></textarea>
                <input type="submit" value="Submit">
              </form>
            </div>
          </div>
        </div>

      </main> 
  <!--php include footer -->
    <?php include __DIR__ . '/../inc/footer.inc.php'; ?>  
