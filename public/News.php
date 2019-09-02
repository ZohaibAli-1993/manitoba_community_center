<?php
//title  variable
$title = 'Manitoba Community Center';
//page name
$page = 'News';
//includes
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

      <main>   
    <!-- Events to register-->  
        <h1><?=$page?></h1>
        <div id="container-gallery"> 
        <div id="gallery1">
        <div class="gallery">
          <a target="_blank" href="../images/news1.jpg">
            <img src="images/news1.jpg" alt="Dinner">
          </a>
          <div class="desc">Community Dinner <button onclick="document.getElementById('id01').style.display='none'" class="cancelbtn"  >Read More</button></div>
        </div>
        </div> 
        <div id="news">
        <div class="gallery">
          <a target="_blank" href="../images/news2.jpg">
            <img src="images/news2.jpg" alt="Student">
          </a>
            <div class="desc">Internation Student <button id="reg7" >Read More</button></div>
        </div> 
        </div>

        <div id="gallery3">
        <div class="gallery"> 

          <a target="_blank" href="../images/news3.jpg">
            <img src="images/news3.jpg" alt="Community March">
          </a>
          <div class="desc">Community March<button id="reg1" >Read More</button></div>
        </div> 
        </div> 
        <div id="gallery4">
        <div class="gallery"> 

          <a target="_blank" href="../images/news4.jpg">
            <img src="images/news4.jpg" alt="tourist">
          </a>
          <div class="desc">Tourism News<button id="reg6" >Read More</button></div>
        </div> 
        </div>

        <div id="fitness">
        <div class="gallery">
          <a target="_blank" href="../images/News5.jpg">
            <img src="images/News5.jpg" alt="University" >
          </a>
            <div class="desc">Univeristy News <button id="reg2" >Read More</button></div>
        </div>  
        </div> 
        <div id="music">
        <div class="gallery">
          <a target="_blank" href="../images/news6.jpg">
            <img src="images/news6.jpg" alt="indegenious" >
          </a>
          <div class="desc">indegenious <button id="reg5" >Read More</button></div>
        </div>  
        </div>
        
        </div>
        
      </main>   
        <!--php include footer --> 
      
<?php include __DIR__ . '/../inc/footer.inc.php'; ?>  
     
