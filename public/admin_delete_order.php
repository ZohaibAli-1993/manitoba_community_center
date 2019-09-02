<?php
//title and page variables
$title = 'Manitoba Community Center';
$page = 'Events Registration';
//include files
include __DIR__ . '/../config/config.php';
include __DIR__ . '/../classes/Validator.php';
include __DIR__ . '/../inc/functions.php';
// security feature only admin can access
if (empty($_SESSION['user_id'])||!$_SESSION['admin']) {
    setFlash('errorS', 'Not Authorized!');
    header('Location: login.php');
    die;
}
//create new  validator object
$v = new Validator();

if (empty($_SESSION['order_id'])) {
    $_SESSION['order_id'] = $_GET['id'];
}
//if condition for get
if (!empty($_GET['id'])||!empty($_SESSION['order_id'])) {
    $order_id=$_SESSION['order_id'];
     // create query
    $query ='SELECT  
             *  
             FROM  
             Orders
             WHERE
             order_id= :order_id';
    //  param array
    $params = [
    ':order_id' => $order_id
    ];
    // prepare query
    $stmt = $dbh->prepare($query);
    // execute query with params
    $stmt->execute($params);
    // fetch  result
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
}
//request method if condition
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
    var_dump($v->errors());
    if (!$v->errors()) {
        //update query
        $query ="DELETE  
                 FROM
                 Orders   
                 WHERE order_id=:order_id";
        //params
        $params = array(
                
                  ':order_id'=> e_attr($_POST['order_id'])

                  );
        
        //try and catch to catch the error
        try {
            //prepare query
            $stmt = $dbh->prepare($query);
            //if condotion to excute the query
            if ($stmt->execute($params)) {
               //redirect
                setFlash('success', 'Successfully Delete!');
                //header
                header('Location: admin_orders.php');
                die;
            } else {   //error messageing
                $errorS['INSERT'] = 'There was a problem updating that orders!';
            }
        } catch (Exception $e) {
            //message display error
            echo $e->getMessage();
        }
    }//closing error statement
} //closeing Request method if condition
//include files
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
        <!--flash message -->
        <?php require '../inc/flash.inc.php';?> 
        <div class="container">
          <!-- form  -->
          <form action="<?=basename($_SERVER['PHP_SELF'])?>" method="post" enctype="multipart/form-data">  
              <fieldset> 
                <legend><strong><b>Delete Order</b></strong></legend> 
                <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token']?>" />
                <p><label for="name">Name</label><br />
                    <input type="text" name="name" id="name" 
                    value="<?=e_attr($result['name'])?>" />  
                    <?=(isset($errors['name'])) ? "<span class='error'>{$errors['name']}</span>" : '' ?>
                </p>

                <p><label for="phone">Phone</label><br />
                    <input type="text" name="phone" id="phone"
                    value="<?=e_attr($result['phone'])?>"/>
                    <?=(isset($errors['phone'])) ? "<span class='error'>{$errors['phone']}</span>" : '' ?>
                </p>
                <p><label for="street">Street</label><br />
                    <input type="text" name="street" id="street"
                    value="<?=e_attr($result['street'])?>"/> 
                    <?=(isset($errors['street'])) ? "<span class='error'>{$errors['street']}</span>" : '' ?>
                </p>
                <p><label for="postal_code">Postal Code</label><br />
                    <input type="text" name="postal_code" id="postal_code"
                    value="<?=e_attr($result['postal_code'])?>"/>  
                    <?=(isset($errors['postal_code'])) ? "<span class='error'>{$errors['postal_code']}</span>" : '' ?>
                </p>
                <p><label for="province">Province</label><br />
                    <input type="text" name="province" id="province"
                    value="<?=e_attr($result['province'])?>"/>  
                    <?=(isset($errors['province'])) ? "<span class='error'>{$errors['province']}</span>" : '' ?>
                </p> 
                <p><label for="event_name">Event Name </label><br />
                    <input type="text" name="event_name" id="event_name"
                    value="<?=e_attr($result['event_name'])?>"/>  
                    <?=(isset($errors['event_name'])) ? "<span class='error'>{$errors['event_name']}</span>" : '' ?>
                </p>  
                <p><label for="event_time">Event Time </label><br />
                    <input type="text" name="event_time" id="event_time"
                    value="<?=e_attr($result['event_time'])?>"/>  
                    <?=(isset($errors['event_time'])) ? "<span class='error'>{$errors['event_time']}</span>" : '' ?>
                </p> 
                <p><label for="donation">Donation </label><br />
                    <input type="text" name="donation" id="donation"
                    value="<?=e_attr($result['donation'])?>"/>  
                    <?=(isset($errors['donation'])) ? "<span class='error'>{$errors['donation']}</span>" : '' ?>
                </p> 
                

                <input name="order_id" type="hidden"
                    value="<?=e_attr($result['order_id'])?>" />

                <p><button>Delete Record</button></p>

               </fieldset>
           </form>  
            
        </div>  
    </div>

</main> 
<!--php include footer -->
<?php include __DIR__ . '/../inc/admin_footer.inc.php'; ?>  
