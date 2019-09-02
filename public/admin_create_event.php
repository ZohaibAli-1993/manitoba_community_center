<?php

//title and page variables
$title = 'Manitoba Community Center';
$page = 'Events Registration';
 
// Include required files
include __DIR__ . '/../inc/functions.php';
include __DIR__ . '/../classes/Validator.php';
include __DIR__ . '/../config/config.php';
// security feature only admin can access
if (empty($_SESSION['user_id'])||!$_SESSION['admin']) {
    setFlash('errorS', 'Not Authorized!');
    header('Location: login.php');
    die;
}
//create new object
$v = new Validator();

// if POST SERVER REQUEST METHOD
if ('POST' == $_SERVER['REQUEST_METHOD']) {
//Required array for empty arrays
    $required=array('event_name','description','type_of_event','event_time','rating','image','category');
    foreach ($required as $key => $value) {
        $v->required($value);
    }

    // validate required on both fields
    $v->stringFunc('event_name');
    $v->stringFunc('description');
    $v->stringFunc('rating');
    $v->stringFunc('category');
    $v->testTime('event_time');
    //$v->postal('postal_code');
    $v->stringFunc('type_of_event');
    $v->stringFunc('image');
        
// if no errors
    if (!$v->errors()) {
        $dbh->beginTransaction();
//query
       
        $query ='INSERT  INTO  
                event
                (event_name,description,type_of_event,event_time,rating,image,category)
                VALUES 
                (:event_name,:description,:type_of_event,:event_time,:rating,:image,:category)';
//parameters
        $params = array(
                  ':event_name' => e_attr($_POST['event_name']),
                  ':description'=> e_attr($_POST['description']),
                  ':type_of_event'=> e_attr($_POST['type_of_event']),
                  ':event_time'=> e_attr($_POST['event_time']),
                  ':rating'=> e_attr($_POST['rating']),
                  ':image'=> e_attr($_POST['image']),
                  ':category'=> e_attr($_POST['category'])

                  );
// try and catch for errors
        try {
            $stmt = $dbh->prepare($query);
            
            if ($stmt->execute($params)) {
                 $user_id = $dbh->lastInsertId();
                 $dbh->commit();
                 //session event id
                 $_SESSION['event_id']=$event_id;
                 //Flash Message
                 setFlash('success', 'Successfully Updated!');
                  //redirect
                 header('Location: admin_events_list.php');
                 die;
            } else {
              //flash message
                $errorS['INSERT'] = 'There was a problem updating that event!';
            }  // if execute
        } catch (Exception $e) {
            $dbh->rollBack();
            echo $e->getMessage();
        }//close catch
    }//close mo error condition
}// close post request method
    
$errors = $v->errors();
include __DIR__ . '/../inc/admin_header.inc.php';

?> 
<main>   
    <!-- Events-->  
         
    <div class="sidenav">
        <a href="admin_home_page.php">Home</a>
        <a href="admin_log.php">Log File</a>
        <a href="show_registration.php">Profile</a>
        
        <button class="dropdown-btn">Events 
          <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-container">
          <a href="admin_create_event.php">Create Events</a>
          <a href="admin_events_list.php">Events Lists</a>
          
        </div> 
        <button class="dropdown-btn">Orders
          <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-container">
          <a href="admin_order_create.php">Create Orders</a>
          <a href="admin_orders.php">Orders Lists</a>
          
        </div> 
        <button class="dropdown-btn">Sponser 
          <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-container">
          <a href="admin_create_sponser.php">Create Sponser</a>
          <a href="admin_sponser_list.php">Sponser Lists</a>
          
        </div> 
         <button class="dropdown-btn">Participants 
          <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-container">
          <a href="admin_create_user.php">Create Participant</a>
          <a href="admin_participant_list.php">Participants Lists</a>
          
        </div>
          <a href="#contact">Search</a>
    </div> 
    <script>
    /* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
    var dropdown = document.getElementsByClassName("dropdown-btn");
    var i;

    for (i = 0; i < dropdown.length; i++)  
    {
    dropdown[i].addEventListener("click", function()  
        {
            this.classList.toggle("active");
            var dropdownContent = this.nextElementSibling;
            if (dropdownContent.style.display === "block")  
            {
                dropdownContent.style.display = "none";
            }  
            else  
            {
                dropdownContent.style.display = "block";
            }
        } 
    );
    }
    </script>   
    <div class='main'>
        
        <div class="container">

          <!-- basename trims a file path to the base filename.  Without
              basename, $_SERVER['PHP_SELF'] is the full path to the file --> 
              <!--Event Registration Form -->
          <form action="<?=basename($_SERVER['PHP_SELF'])?>" method="post" novalidate>
            <fieldset>
              <legend>Event Creation</legend> 
              <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token']?>" />
              <p> 
              <!-- Event Name -->
                  <label for="event_name">Event Name</label><br />
                  <input type="text" name="event_name" id="event_name" placeholder="Event name"
                  value="<?=clean('event_name')?>" />
                    <?=(isset($errors['event_name'])) ? "<span class='error'>{$errors['event_name']}</span>" : '' ?>
              </p>  
              <!-- Type of Event -->
              <p>
                  <label for="type_of_event">Event Type</label><br />
                  <input type="text" name="type_of_event" id="type_of_event" placeholder="type_of_event"
                  value="<?=clean('type_of_event')?>" />
                    <?=(isset($errors['type_of_event'])) ? "<span class='error'>{$errors['type_of_event']}</span>" : '' ?>
              </p>   
              <!-- Category-->
              <p>
                  <label for="category">Category</label><br />
                  <input type="text" name="category" id="category"  placeholder="Category"
                  value="<?=clean('category')?>" />
                    <?=(isset($errors['category'])) ? "<span class='error'>{$errors['category']}</span>" : '' ?>
              </p> 
              <!-- Rating -->
              <p>
                  <label for="rating">Rating</label><br />
                  <input type="text" name="rating" id="rating" placeholder="Rating"
                  value="<?=clean('rating')?>" />
                    <?=(isset($errors['rating'])) ? "<span class='error'>{$errors['rating']}</span>" : '' ?>
              </p> 
              <!-- Event -->
              <p>
                  <label for="event_time">Event Time</label><br />
                  <input type="text" name="event_time" id="event_time" placeholder="Event Time"
                  value="<?=clean('event_time')?>" />
                    <?=(isset($errors['event_time'])) ? "<span class='error'>{$errors['event_time']}</span>" : '' ?>
              </p>    
              <!-- Descriotion -->
              <p>
                  <label for="description">Description</label><br />
                  <input type="text" name="description" id="description" placeholder="Description"
                  value="<?=clean('description')?>" />
                    <?=(isset($errors['description'])) ? "<span class='error'>{$errors['description']}</span>" : '' ?>
              </p>   
              <!-- Image -->
              <p>
                  <label for="image">Image</label><br />
                  <input type="file" name="image" id="image" 
                  />
                    <?=(isset($errors['image'])) ? "<span class='error'>{$errors['image']}</span>" : '' ?>
              </p>   
              <!-- Country -->
              
              <p><input type="submit" value="submit" /></p>
            </fieldset>
          </form>
        </div> 
    </div>
</main>  
<!--php include footer -->
<?php include __DIR__ . '/../inc/admin_footer.inc.php'; ?>  
