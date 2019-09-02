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
    $required=array('sponser_name','address','city','postal_code','agreement');
    foreach ($required as $key => $value) {
        $v->required($value);
    }
    // validate required on both fields
    $v->stringFunc('sponser_name');
    $v->stringFunc('address');
    $v->stringFunc('city');
    $v->stringFunc('postal_code');
    $v->stringFunc('agreement');
// if no errors
    if (!$v->errors()) {
//begin transaction
        $dbh->beginTransaction();
//query
        $query ='INSERT   INTO  
                sponser
                (sponser_name,address,city,postal_code,agreement)
                VALUES 
                (:sponser_name,:address,:city,:postal_code,:agreement)';
//parameters
        $params = array(
                  ':sponser_name' => e_attr($_POST['sponser_name']),
                  ':address'=> e_attr($_POST['address']),
                  ':city'=> e_attr($_POST['city']),
                  ':postal_code'=> e_attr($_POST['postal_code']),
                  ':agreement'=> e_attr($_POST['agreement'])
                );
// try and catch for errors
        try {
            $stmt = $dbh->prepare($query);
            //if query execute
            if ($stmt->execute($params)) {
                //Last id of the database
                 $user_id = $dbh->lastInsertId();
                 $dbh->commit();
                 //session of last user id get it from the table
                 $_SESSION['sponser_id']=e_attr($_POST['sponser_id']);
                 //Flash Message
                 setFlash('success', 'Successfully Updated!');
                  //redirect
                  header('Location: admin_sponser_list.php');
                  die;
            } else {
              //flash message
                $errorS['INSERT'] = 'There was a problem updating that spnser!';
            }  // if execute
        } catch (Exception $e) {
            $dbh->rollBack();
            echo $e->getMessage();
        }//closing catch
    }//closing rror condition
}// closing post request method
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

    for (i = 0; i < dropdown.length; i++) {
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
      });
    }
    </script>    
    <div class='main'>
    <h1><?=$page ?></h1> 
        <div class="container">

          <!-- basename trims a file path to the base filename.  Without
              basename, $_SERVER['PHP_SELF'] is the full path to the file --> 
              <!--Sponser Registration Form -->
          <form action="<?=basename($_SERVER['PHP_SELF'])?>" method="post" novalidate>
          <fieldset>
              <legend>Sponser Creation</legend> 
              <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token']?>" />
              <p> 
              <!-- Name -->
                  <label for="sponser_name"> Sponser Name</label><br />
                  <input type="text" name="sponser_name" id="sponser_name" placeholder="Sponser Name"
                  value="<?=clean('name')?>" />
                    <?=(isset($errors['sponser_name'])) ? "<span class='error'>{$errors['sponser_name']}</span>" : '' ?>
              </p>  
              <!-- Address -->
              <p>
                  <label for="address">Address</label><br />
                  <input type="text" name="address" id="address" placeholder="Address"
                  value="<?=clean('address')?>" />
                    <?=(isset($errors['address'])) ? "<span class='error'>{$errors['address']}</span>" : '' ?>
              </p>   
              <!-- City -->
              <p>
                  <label for="city">City</label><br />
                  <input type="text" name="city" id="city"  placeholder="City"
                  value="<?=clean('city')?>" />
                    <?=(isset($errors['city'])) ? "<span class='error'>{$errors['city']}</span>" : '' ?>
              </p> 
              <!-- Postal Code -->
              <p>
                  <label for="postal_code">Postal Code</label><br />
                  <input type="text" name="postal_code" id="postal_code" placeholder="Street"
                  value="<?=clean('postal_code')?>" />
                    <?=(isset($errors['postal_code'])) ? "<span class='error'>{$errors['postal_code']}</span>" : '' ?>
              </p> 
              <!-- Agreement -->
              <p>
                  <label for="agreement">Agreement</label><br />
                  <input type="text" name="agreement" id="agreement" placeholder="Agreement"
                  value="<?=clean('agreement')?>" />
                    <?=(isset($errors['agreement'])) ? "<span class='error'>{$errors['agreement']}</span>" : '' ?>
              </p>    
          
              
              <p><input type="submit" value="submit" /></p>
          </fieldset>
          </form>
        </div> 
    </div>
</main>   
<!--php include footer --> 
<?php include __DIR__ . '/../inc/admin_footer.inc.php'; ?>  
