<?php
//title and page variables
$title = 'Manitoba Community Center';
$page = 'Volunteer';
include __DIR__ . '/../config/config.php';
//includer for header and navigation
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
    <!-- Volunteer Galler-->  
        <h1><?= $page ?></h1>
          <div id="container-gallery">
            <div class="gallery">
              <a target="_blank" href="../images/volunteer1.jpg">
                <img src="images/volunteer1.jpg" alt="Volunteer-unity" width="180" height="300">
              </a>
              <div class="desc">“Service to others is the rent you pay for your room here on Earth.” ~Muhammed Ali 
              </div>
            </div>

            <div class="gallery">
              <a target="_blank" href="../images/volunteer2.jpg">
                <img src="images/volunteer2.jpg" alt="volunteer-work" width="180" height="300">
              </a>
              <div class="desc">"The best way to really understand the process is to volunteer your time." ~McKenna 
              </div>
            </div>

            <div class="gallery">
              <a target="_blank" href="../images/volunteer5.jpg">
                <img src="images/volunteer5.jpg" alt="volunteer3" width="180" height="300">
              </a>
            <div class="desc">"Volunteers do not necessarily have the time; they just have the heart." Elizabeth Andrew 
            </div>
        </div> 
 
        </div>
          <div id="para">
            <p> Volunteering is important for numerous reasons that benefit both the community and the volunteer themselves. 
            When someone donates a handful of time, the difference made is tremendous and it shapes a community for the better  
            while the experience improves the person who donated the time.</p>

            <p>Volunteering is what makes a community because it brings people together to work on a goal. 
            Whether it is a fundraiser for the research to cure a disease that affects the whole world, or  
            to help a local family who has fallen in a time of calamity, volunteers make it happen. Community  
            life is improved by aiding others and lending a helping hand to get a job done more effectively.  
            More people working equals less work for each person and less time for the project. So when it comes  
            to getting the job done, like a community clean up, the more the merrier.</p>

            <p>When a person donates their time, they give hope to someone who needs it. If a local family's
            house burnt down and a group of people hosted a benefit for them, that family's faith would be revived  
            when they realized that people care. Although that family lost their house and their belongings, seeing how  
            their own community wants to help would bring joy and show them that money isn't everything.</p>  
          <table>
          
          <!--Table  -->
          <tr>
            <th colspan="3">Schedule</th>
          </tr>
          <tr>
            <th>Index</th>
            <th>Volunteer Events</th>
            <th>Date</th> 

          </tr>  
    
          <tr>
            <th>1</th>
            <td>Elders Care</td>
            <td>December 30, 2018</td> 

          </tr>  

          <tr>
            <th>2</th>
            <td>Volunteer March</td>
            <td>January 10,2018</td> 

          </tr> 

           <tr>
            <th>3</th>
            <td>Dinner</td>
            <td>January 30,2019</td> 

          </tr> 


     
        </table> 
      <!--End of the table--> 
          
        <button id="reg" >Registration</button>
      </div> 
          
      </main> 
  <!--php include footer -->
    <?php include __DIR__ . '/../inc/footer.inc.php'; ?>  
