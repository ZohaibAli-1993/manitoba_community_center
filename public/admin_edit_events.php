<?php
//title and page variables
$title = 'Manitoba Community Center';
$page = 'Events Registration';
//include files
include __DIR__ . '/../config/config.php';
include __DIR__ . '/../classes/Validator.php';
include __DIR__ . '/../inc/functions.php';
//empty array
$errors=[]; 
//create new  validator object 
$v = new Validator();
// security feature only admin can access
if (empty($_SESSION['user_id'])||!$_SESSION['admin']) {
    setFlash('errorS', 'Not Authorized!');
    header('Location: login.php');
    die;
}
if (empty($_SESSION['event_id'])) {
    $_SESSION['event_id'] = $_GET['id'];
}
//if condition for get
if (!empty($_GET['id'])||!empty($_SESSION['event_id'])) {
    $event_id = $_GET['id'] ;
     // create query
    $query ='SELECT  
             *  
             FROM  
             event
             WHERE
             event_id= :event_id'; 
    //  param array
    $params = [
    ':event_id' => $event_id
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
    $required=array('event_name','description','type','event_time','rating','category');
    foreach ($required as $key => $value) {
        $v->required($value);
    }
    // validate required on both fields
    $v->stringFunc('event_name');
    $v->stringFunc('description');
    $v->stringFunc('rating');
    $v->stringFunc('category');
    $v->stringFunc('type');
    
    
    if (!$v->errors()) {
        //update query
        $query ="UPDATE  
                 event  
                 SET event_name=:event_name, description=:description,type_of_event=:type_of_event,event_time=:event_time,rating=:rating   
                 WHERE event_id=:event_id";
        //params
        $params = array(
                      ':event_name' => e_attr($_POST['event_name']),
                      ':description' => e_attr($_POST['description']),
                      ':type_of_event' => e_attr($_POST['type']),
                      ':event_time' => e_attr($_POST['event_time']),
                      ':event_id' => e_attr($_POST['event_id']),
                      ':rating' => e_attr($_POST['rating']),
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
                header('Location: admin_events_list.php');
                die;
            } else {   //error messageing
                $errors['INSERT'] = 'There was a problem updating that book!';
            }
        } catch (Exception $e) {
            //message display error
            echo $e->getMessage();
        }
    }//closing error condition
}//closing request method 
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
                <legend><strong><b>Update Event</b></strong></legend> 
                <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token']?>" />
                <p><label for="event_name">Event Name</label><br />
                    <input type="text" name="event_name"  id="event_name"
                    value="<?=e_attr($result['event_name'])?>" />   
                     <?=(isset($errors['event_name'])) ? "<span class='error'>{$errors['event_name']}</span>" : '' ?>
                   
                </p>

                <p><label for="type">Type of Event</label><br />
                    <input type="text" name="type" id="type"
                    value="<?=e_attr($result['type_of_event'])?>"/>  
                     <?=(isset($errors['type_of_event'])) ? "<span class='error'>{$errors['type_of_event']}</span>" : '' ?>
                </p>

                <p><label for="event_time">Event Time</label><br />
                    <input type="text" name="event_time" id="event_time"
                    value="<?=e_attr($result['event_time'])?>"/> 
                    <?=(isset($errors['event_time'])) ? "<span class='error'>{$errors['event_time']}</span>" : '' ?> 
                </p>

                <p><label for="rating">Rating</label><br />
                    <input type="text" name="rating" id="rating"
                    value="<?=e_attr($result['rating'])?>"/> 
                    <?=(isset($errors['rating'])) ? "<span class='error'>{$errors['rating']}</span>" : '' ?> 
                </p>  

                <p><label for="category">Category</label><br />
                    <input type="text" name="category" id="category"
                    value="<?=e_attr($result['category'])?>"/>  
                    <?=(isset($errors['category'])) ? "<span class='error'>{$errors['category']}</span>" : '' ?>
                </p>

                <p><label for="image">Image</label><br />
                    <input type="file" name="image" id="image" /><br />
                    <img style="width: 75px; height: auto" alt="image"
                        src="/images/<?=e_attr($result['image'])?>" /></p>


                <p><label for="description">Description</label><br />
                    <textarea style="width: 50%; height: 100px;" name="description" id="description"><?=$result['description']?></textarea>  
                    <?=(isset($errors['description'])) ? "<span class='error'>{$errors['description']}</span>" : '' ?>
                </p>

                <input name="event_id" type="hidden"
                    value="<?=e_attr($result['event_id'])?>" />

                <p><button>Update Record</button></p>
                
               </fieldset>
           </form>  
            
        </div>  
    </div>

</main> 
<!--php include footer -->
<?php include __DIR__ . '/../inc/admin_footer.inc.php'; ?>  
