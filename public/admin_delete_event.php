<?php
//title and page variables
$title = 'Manitoba Community Center';
$page = 'Events Registration';
//include files
include __DIR__ . '/../config/config.php';
include __DIR__ . '/../inc/functions.php';
// security feature only admin can access
if (empty($_SESSION['user_id'])||!$_SESSION['admin']) {
    setFlash('errorS', 'Not Authorized!');
    header('Location: login.php');
    die;
}
//if condition for get id
if (!empty($_GET['id'])) {
    $event_id = $_GET['id'];
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
//Posr request method
if ('POST' == $_SERVER['REQUEST_METHOD']) {
    //update query
    $query ="DELETE  
             FROM
             event    
             WHERE event_id=:event_id";
    //params
    $params = array(
                   
                  ':event_id' => e_attr($_POST['event_id'])
                 
                );
    //try and catch to catch the error
    try {
        //prepare query
        $stmt = $dbh->prepare($query);
        //if condotion to excute the query
        if ($stmt->execute($params)) {
           //redirect
            setFlash('success', 'Successfully Delete!');
            header('Location: admin_events_list.php');
            die;
        } else {   //error messageing
            $errors['INSERT'] = 'There was a problem updating that book!';
        }
    } catch (Exception $e) {
        //message display error
        echo $e->getMessage();
    }
}
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
    <!-- main div-->
    <div class='main'>
        <?php require '../inc/flash.inc.php';?> 
        <div class="container">
        <!-- form  -->
        <form action="<?=basename($_SERVER['PHP_SELF'])?>" method="post" enctype="multipart/form-data">  
        <fieldset> 
        <legend><strong><b>Delete Event</b></strong></legend> 
        <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token']?>" />
        <p><label for="event_name">Event Name</label><br />
            <input type="text" name="event_name" id="event_name"  
            value="<?=e_attr($result['event_name'])?>" /></p>

        <p><label for="type">Type of Event</label><br />
            <input type="text" name="type" id="type"
            value="<?=e_attr($result['type_of_event'])?>"/></p>

        <p><label for="event_time">Event Time</label><br />
            <input type="text" name="event_time" id="event_time"
            value="<?=e_attr($result['event_time'])?>"/></p>

        <p><label for="rating">Rating</label><br />
            <input type="text" name="rating" id="rating"
            value="<?=e_attr($result['rating'])?>"/></p>  

        <p><label for="category">Category</label><br />
            <input type="text" name="category" id="category"
            value="<?=e_attr($result['category'])?>"/></p>

        <p><label for="image">Image</label><br />
            <input type="file" name="image" id="image"  /><br />
            <img style="width: 75px; height: auto"  alt="image"
                src="/images/<?=e_attr($result['image'])?>" /></p>


        <p><label for="description">Description</label><br />
            <textarea style="width: 50%; height: 100px;" id="description" name="description"><?=$result['description']?></textarea></p>

        <input name="event_id" type="hidden"
            value="<?=e_attr($result['event_id'])?>" />

        <p><button>Delete Record</button></p>

         </fieldset>
        </form>  
        
        </div>  
    </div>

</main> 
<!--php include footer -->
<?php include __DIR__ . '/../inc/admin_footer.inc.php'; ?>  
