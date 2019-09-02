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
//create new  validator object
$v = new Validator();
// if POST SERVER REQUEST METHOD
if ('POST' == $_SERVER['REQUEST_METHOD']) {
//Required array for empty arrays
    $required=array('name','phone','street','postal_code','province','event_name','event_time','donation');
    foreach ($required as $key => $value) {
        $v->required($value);
    }
    // validate required on both fields
    $v->stringFunc('name');
    $v->integerFunc('phone');
    $v->integerFunc('phone');
    $v->stringFunc('donation');
    $v->stringFunc('province');
    $v->stringFunc('street');
    
   
    $v->stringFunc('postal_code');
// if no errors
    if (!$v->errors()) {
        $dbh->beginTransaction();
//query
       
        $query ='INSERT   INTO  
                Orders
                (name,phone,street,postal_code,province,event_name,event_time,donation)
                VALUES 
                (:name,:phone,:street,:postal_code,:province,:event_name,:event_time,:donation)';
//parameters
        $params = array(
                  ':name' => e_attr($_POST['name']),
                  ':phone'=> e_attr($_POST['phone']),
                  ':street'=> e_attr($_POST['street']),
                  ':postal_code'=> e_attr($_POST['postal_code']),
                  ':province'=> e_attr($_POST['province']),
                  ':event_name'=> e_attr($_POST['event_name']),
                  ':event_time'=> e_attr($_POST['event_time']),
                  ':donation'=> e_attr($_POST['donation'])

                  );
// try and catch for errors
        try {
            $stmt = $dbh->prepare($query);
            
            if ($stmt->execute($params)) {
                $dbh->commit();
                $_SESSION['order_id']=$order_id;
                //Flash Message
                setFlash('success', 'Successfully Updated!');
                //redirect
                header('Location: admin_orders.php');
                die;
            } else {
              //flash message
                $errorS['INSERT'] = 'There was a problem updating that Order!';
            }  // if execute
        } catch (Exception $e) {
            $dbh->rollBack();
            echo $e->getMessage();
        }//closing catch
    }//closing  error condition
}// closing post request method
    
$errors = $v->errors();
include __DIR__ . '/../inc/admin_header.inc.php';

?> 
 <main>        
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

    for (i = 0; i < dropdown.length; i++) {
      dropdown[i].addEventListener("click", function() {
      this.classList.toggle("active");
      var dropdownContent = this.nextElementSibling;
      if (dropdownContent.style.display === "block") {
      dropdownContent.style.display = "none";
      } else {
      dropdownContent.style.display = "block";
      }
      });
    }
    </script>   


    <div class='main'>
    <h1><?=$page ?></h1> 
        <div class="container">

          <!-- basename trims a file path to the base filename.  Without
              basename, $_SERVER['PHP_SELF'] is the full path to the file --> 
              <!--Event Registration Form -->
          <form action="<?=basename($_SERVER['PHP_SELF'])?>" method="post" novalidate>
          <fieldset>
              <legend>Order Creation</legend> 
              <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token']?>" />
              <p> 
              <!-- Name -->
                  <label for="name">Name</label><br />
                  <input type="text" name="name" id="name" placeholder="Name"
                  value="<?=clean('name')?>" />
                    <?=(isset($errors['name'])) ? "<span class='error'>{$errors['name']}</span>" : '' ?>
              </p>  
              <!-- Event Type -->
              <p>
                  <label for="type_of_event">Event Type</label><br />
                  <input type="text" name="type_of_event" id="type_of_event" placeholder="type_of_event"
                  value="<?=clean('type_of_event')?>" />
                    <?=(isset($errors['type_of_event'])) ? "<span class='error'>{$errors['type_of_event']}</span>" : '' ?>
              </p>   
              <!-- Phone -->
              <p>
                  <label for="phone">Phone</label><br />
                  <input type="text" name="phone" id="phone"  placeholder="Phone"
                  value="<?=clean('phone')?>" />
                    <?=(isset($errors['phone'])) ? "<span class='error'>{$errors['phone']}</span>" : '' ?>
              </p> 
              <!-- Street -->
              <p>
                  <label for="street">Street</label><br />
                  <input type="text" name="street" id="street" placeholder="Street"
                  value="<?=clean('street')?>" />
                    <?=(isset($errors['street'])) ? "<span class='error'>{$errors['street']}</span>" : '' ?>
              </p> 
              <!-- Postal Code -->
              <p>
                  <label for="postal_code">Postal Code</label><br />
                  <input type="text" name="postal_code" id="postal_code" placeholder="Postal Code"
                  value="<?=clean('postal_code')?>" />
                    <?=(isset($errors['postal_code'])) ? "<span class='error'>{$errors['postal_code']}</span>" : '' ?>
              </p>    
              <!-- Province -->
              <p>
                  <label for="province">Province</label><br />
                  <input type="text" name="province" id="province" placeholder="Province"
                  value="<?=clean('province')?>" />
                    <?=(isset($errors['province'])) ? "<span class='error'>{$errors['province']}</span>" : '' ?>
              </p>   
              <!-- Event Name -->
               <p>
                  <label for="event_name">Event Name</label><br />
                  <input type="text" name="event_name" id="event_name" placeholder="Event Name"
                  value="<?=clean('event_name')?>" />
                    <?=(isset($errors['event_name'])) ? "<span class='error'>{$errors['event_name']}</span>" : '' ?>
              </p>  
             <!-- Event Time-->
              <p>
                  <label for="event_time">Event Time</label><br />
                  <input type="text" name="event_time" id="event_time" placeholder="Event Time"
                  value="<?=clean('event_time')?>" />
                    <?=(isset($errors['event_time'])) ? "<span class='error'>{$errors['event_time']}</span>" : '' ?>
              </p>  
              <!-- Donation -->
              <p>
                  <label for="donation">Donation</label><br />
                  <input type="text" name="donation" id="donation" placeholder="Event Time"
                  value="<?=clean('donation')?>" />
                    <?=(isset($errors['donation'])) ? "<span class='error'>{$errors}</span>" : '' ?>
              </p>
              
              <p><input type="submit" value="submit" /></p>
          </fieldset>
          </form>
    </div>    </div>
</main>
<!--php include footer -->
<?php include __DIR__ . '/../inc/admin_footer.inc.php'; ?>  
