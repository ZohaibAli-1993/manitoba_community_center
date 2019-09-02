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
//empty array
$errors=[];
//create new  validator object
$v = new Validator();
//session userid condition
if (empty($_SESSION['user_id'])) {
    $_SESSION['user_id'] = $_GET['id'];
}
//if condition for get
if (!empty($_GET['id'])||!empty($_SESSION['user_id'])) {
    $user_id=$_SESSION['user_id'];
     // create query
    $query ='SELECT  
             *  
             FROM  
             participant
             WHERE
             user_id= :user_id';
    //  param array
    $params = [
    ':user_id' => $user_id
    ];
    // prepare query
    $stmt = $dbh->prepare($query);
    // execute query with params
    $stmt->execute($params);
    // fetch  result
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ('POST' == $_SERVER['REQUEST_METHOD']) {
   //Required array for empty arrays
    $required=array('first_name','email','last_name','age','street','city','postal_code','province','country','created_at','updated_at');
    foreach ($required as $key => $value) {
        $v->required($value);
    }

    // validate required on both fields
    $v->stringFunc('first_name');
    $v->stringFunc('last_name');
    $v->integerFunc('age');
     $v->integerFunc('phone');
    $v->stringFunc('street');
    $v->stringFunc('city');
    //$v->postal('postal_code');
    $v->stringFunc('province');
    $v->stringFunc('country');
    $v->email('email');
  
    if (!$v->errors()) {
        //update query
        $query ="UPDATE  
                 participant
                 SET first_name=:first_name,last_name=:last_name ,age=:age,street=:street,city=:city,postal_code=:postal_code,province=:province,country=:country,phone=:phone,email=:email,created_at=:created_at,updated_at=:updated_at   
                 WHERE user_id=:user_id";
        //parameters
        $params = array(
                  ':first_name' => e_attr($_POST['first_name']),
                  ':last_name' => e_attr($_POST['last_name']),
                  ':age' => e_attr($_POST['age']),
                  ':street'=> e_attr($_POST['street']),
                  ':city' => e_attr($_POST['city']),
                  ':postal_code' =>e_attr($_POST['postal_code']),
                  ':province' => e_attr($_POST['province']),
                  ':country' =>e_attr($_POST['country']),
                  ':phone' => e_attr($_POST['phone']),
                  ':email' => e_attr($_POST['email']),
                  ':created_at' => e_attr($_POST['created_at']),
                  ':updated_at' => e_attr($_POST['updated_at']),
                  ':user_id' => e_attr($_POST['user_id'])
                  );
        //try and catch to catch the error
        try {
            //prepare query
            $stmt = $dbh->prepare($query);
            //if condotion to excute the query
            if ($stmt->execute($params)) {
               //redirect
                setFlash('success', 'Successfully Update!');
                //header
                header('Location: admin_participant_list.php');
                die;
            } else {   //error messageing
                $errorS['INSERT'] = 'There was a problem updating that Participant!';
            }
        } catch (Exception $e) {
            //message display error
            echo $e->getMessage();
        }
    }//closing error statement
} //closeing Request method if condition
$errors=$v->errors();
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
                <legend><strong><b>Update Participant</b></strong></legend> 
                <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token']?>" />
                <p><label for="first_name">First Name</label><br />
                    <input type="text" name="first_name"  id="first_name"
                    value="<?=e_attr($result['first_name'])?>" />  
                    <?=(isset($errors['first_name'])) ? "<span class='error'>{$errors['first_name']}</span>" : '' ?>
                </p>

                <p><label for="last_name">Last Name</label><br />
                    <input type="text" name="last_name" id="last_name"
                    value="<?=e_attr($result['last_name'])?>"/>
                    <?=(isset($errors['last_name'])) ? "<span class='error'>{$errors['last_name']}</span>" : '' ?>
                </p>
                <p><label for="age">Age</label><br />
                    <input type="text" name="age" id="age"
                    value="<?=e_attr($result['age'])?>"/> 
                    <?=(isset($errors['age'])) ? "<span class='error'>{$errors['age']}</span>" : '' ?>
                </p> 
                <p><label for="street">Street</label><br />
                    <input type="text" name="street" id="street"
                    value="<?=e_attr($result['street'])?>"/> 
                    <?=(isset($errors['street'])) ? "<span class='error'>{$errors['street']}</span>" : '' ?>
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
                <p><label for="province">Province</label><br />
                    <input type="text" name="province" id="province"
                    value="<?=e_attr($result['province'])?>"/>  
                    <?=(isset($errors['province'])) ? "<span class='error'>{$errors['province']}</span>" : '' ?>
                </p> 
                <p><label for="country">Country </label><br />
                    <input type="text" name="country" id="country"
                    value="<?=e_attr($result['country'])?>"/>  
                    <?=(isset($errors['country'])) ? "<span class='error'>{$errors['country']}</span>" : '' ?>
                </p>   
                <p><label for="phone">Phone </label><br />
                    <input type="text" name="phone" id="phone"
                    value="<?=e_attr($result['phone'])?>"/>  
                    <?=(isset($errors['phone'])) ? "<span class='error'>{$errors['phone']}</span>" : '' ?>
                </p>   
                <p><label for="email">Email</label><br />
                    <input type="text" name="email" id="email"
                    value="<?=e_attr($result['email'])?>"/>  
                    <?=(isset($errors['email'])) ? "<span class='error'>{$errors['email']}</span>" : '' ?>
                </p>
                <p><label for="created_at">Created At</label><br />
                    <input type="text" name="created_at" id="created_at"
                    value="<?=e_attr($result['created_at'])?>"/>  
                    <?=(isset($errors['created_at'])) ? "<span class='errors'>{$errors['created_at']}</span>" : '' ?>
                </p> 
                <p><label for="updated_at">Updated At </label><br />
                    <input type="text" name="updated_at" id="updated_at"
                    value="<?=e_attr($result['updated_at'])?>"/>  
                    <?=(isset($errorS['updated_at'])) ? "<span class='errors'>{$errors['updated_at']}</span>" : '' ?>
                </p> 
                <input name="user_id" type="hidden"
                    value="<?=e_attr($result['user_id'])?>" />

                <p><button>Update Record</button></p>
                
               </fieldset>
           </form>  
            
        </div>  
    </div>

</main> 
<!--php include footer -->
<?php include __DIR__ . '/../inc/admin_footer.inc.php'; ?>  
