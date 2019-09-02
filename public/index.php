<?php
//PHP varibales
$title = 'Manitoba Community Center';
$page='Home';
  //includer for header and navigation
include __DIR__ . '/../config/config.php';
include __DIR__ . '/../inc/header.inc.php';
include __DIR__ . '/../inc/main_nav.inc.php';
include __DIR__ . '/../inc/slider.inc.php'; ?>
      <!--slider Java Script-->
  
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
    <!-- main images-->  
        <div id="images">
          <div id="Content-image1" >
            <img src="images/charitable.jpg" id ="cont-logo1" alt="social-gathering"/> 
          </div> 
          <div id="Content-image-two1" >
            <img src="images/vol.jpg" id ="cont-logo2" alt="social-gathering"/> 
          </div> 
        </div>  
        <div id="para">
          <h2><?=$page ?></h2>
          <div> 
          <p>Manitoba Community service is a non-paying job performed by one person or a group  
          of people for the benefit of the community or its institutions. Community service  
          is distinct from volunteering, since it is not always performed on a voluntary basis.
          </div>  

          <div>
          <p>Manitoba Community service also allows those participating to reflect  
          on the difference they are making in society. Some participants of 
          a community service project may find themselves gaining a greater understanding 
          of their roles in the community, as well as the impact of their contributions  
          towards those in need of service. Because community service outlets vary, those 
          who serve are exposed to many different kinds of people, environments, and situations.<p> 
          </div> 
        </div>
      </main> 
   <!--php include footer --> 
    <?php include __DIR__ . '/../inc/footer.inc.php'; ?>
