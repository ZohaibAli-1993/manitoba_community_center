  <?php
  //php variavle used to identify the page
  $active='nav_style';
  
    ?>
 <div id="wrapper">
      <!-- Main Navigation-->  
      <!-- Modify the navigation (likely in the header) to use PHP links, this will highlight the current page (breadcrumbs)-->
      <nav id="main-nav">
          <a href="#" id="menubutton1">
          <span id="topbar1"></span>
          <span id="middlebar1"></span>
          <span id="bottombar1"></span>
          </a>
          <ul id="navlist1">
          <li><a href="index.php" 
            
            class="<?php
            if ($page =='Home') {
                echo $active;
            }?>">Home</a>
            
          </li>

          <li class="has_submenu"><a href="#">Services &amp; Such</a>
          <ul class="submenu">
            <li><a href="volunteer.php" 
            
            class="<?php
            if ($page =='Volunteer') {
                echo $active;
            }?>">Volunteer</a>
            
            </li>
            <li><a href="events_view.php" 
            
            class="<?php
            if ($page =='Events') {
                echo $active;
            }?>">Events</a>
            
          </li>
            <li><a href="#">Trainings</a></li>
            <li><a href="#">Seminars</a></li>

          </ul>
          </li> 
          <li><a href="admin_events_list.php" 
            
            class="<?php
            if ($page =='News') {
                echo $active;
            }?>">News</a>
            
          </li>
          <li><a href="admin_home_page.php">Careers</a></li>
          <li><a href="contact.php" 
            
            class="<?php
            if ($page =='Contact') {
                echo $active;
            }?>">Contact</a>
            
          </li>
          </ul> 
      </nav>
