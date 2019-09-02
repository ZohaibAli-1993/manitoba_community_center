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

//if condition for get
if (!empty($_GET['id'])) {
    //Session id
    $sponser_id=$_GET['id'];

     // create query
    $query ='SELECT  
             *  
             FROM  
             sponser
             WHERE
             sponser_id= :sponser_id';
    //  param array
    $params = [
    ':sponser_id' => $sponser_id
    ];
    // prepare query
    $stmt = $dbh->prepare($query);
    // execute query with params
    $stmt->execute($params);
    // fetch  result
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
}
//request method condition
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
    //if no error
    if (!$v->errors()) {
        //update query
        $query ="DELETE 
                 FROM
                 sponser    
                 WHERE sponser_id=:sponser_id";
        //params
        $params = array(
                      ':sponser_id' => e_attr($_POST['sponser_id'])
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
                header('Location: admin_sponser_list.php');
                die;
            } else {   //error messageing
                $errorS['INSERT'] = 'There was a problem updating that sponser!';
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
                <legend><strong><b>Update Sonser</b></strong></legend> 
                <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token']?>" />
                <p><label for="sponser_name">Sponser Name</label><br />
                    <input type="text" name="sponser_name"  id="sponser_name"
                    value="<?=e_attr($result['sponser_name'])?>" />  
                    <?=(isset($errors['sponser_name'])) ? "<span class='error'>{$errors['sponser_name']}</span>" : '' ?>
                </p>

                <p><label for="address">Address</label><br />
                    <input type="text" name="address" id="address"
                    value="<?=e_attr($result['address'])?>"/>
                    <?=(isset($errors['address'])) ? "<span class='error'>{$errors['address']}</span>" : '' ?>
                </p>
                <p><label for="city">City</label><br />
                    <input type="text" name="city" id="city"
                    value="<?=e_attr($result['city'])?>"/> 
                    <?=(isset($errors['city'])) ? "<span class='error'>{$errors['city']}</span>" : '' ?>
                </p>
                <p><label for="postal_code">Postal Code</label><br />
                    <input type="text" name="postal_code" id="postal_code"
                    value="<?=e_attr($result['postal_code'])?>"/>  
                    <?=(isset($errors['postal_code'])) ? "<span class='error'>{$errors['postal_code']}</span>" : '' ?>
                </p>

                <p><label for="agreement">Agreement</label><br />
                    <textarea style="width: 50%; height: 100px;" name="agreement" id="agreement"><?=$result['agreement']?></textarea>  
                    <?=(isset($errors['agreement'])) ? "<span class='error'>{$errors['agreement']}</span>" : '' ?>
                </p>

                <input name="sponser_id" type="hidden"
                    value="<?=e_attr($result['sponser_id'])?>" />

                <p><button>Delete Record</button></p>

               </fieldset>
           </form>  
            
        </div>  
    </div>

</main> 
<!--php include footer -->
<?php include __DIR__ . '/../inc/admin_footer.inc.php'; ?>  
