<?php
//title and page variables
$title = 'Manitoba Community Center';
$page= 'List View';
//include files
include __DIR__ . '/../config/config.php';
include __DIR__ . '/../inc/functions.php';
// security feature only admin can access
if (empty($_SESSION['user_id'])||!$_SESSION['admin']) {
    setFlash('errorS', 'Not Authorized!');
    header('Location: login.php');
    die;
}
// envent id  recieve through from previous form

//post server request method to get data from server
if ('POST' == $_SERVER['REQUEST_METHOD']) {
    //flag to used for html condition
    $method=true;
    //save form value into search variable
    $search=$_POST['search'];
    //create query
    $query ='SELECT  
             *  
             FROM  
             event
             WHERE
             event_name LIKE :event_name';
    //  param array
    $params = [
    ':event_name' =>"%{$search}%"
    ];
    // prepare query
    $stmt = $dbh->prepare($query);
    // execute query with params
    $stmt->execute($params);
    // fetch the data into  result
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    //Session to store event id
    $_SESSION['event_id']=$result['event_id'];
} else {
    $method=false;
     //create query
    $query ='SELECT 
             *  
             FROM 
             event';
    //prepare query
    $stmt=$dbh->query($query);
    // fetch the data into  result
    $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
}
//includes file
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
     
        <h2>Events List View
        </h2> 
        <?php require '../inc/flash.inc.php';?>

        <form class="example" action="<?=$_SERVER['PHP_SELF']?>" method="post" novalidate> 
          <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token']?>" />
          <input type="text" placeholder="search by Event Name" name="search">
          <button type="submit">
            <i class="fa fa-search">
            </i>
          </button>
        </form> 
        <br/> 

        <!-- tables to display data -->
        <table id="prof"> 
          <!--if condition to check the flag to display all the result -->
            <?php if ($method==false) :?> 
          <tr> 
            <th>Image
            </th>
            <th>Event Name
            </th>
            <th>Event Type
            </th>
            <th>Timing
            </th>
            <th>Rating
            </th>
            <th>View
            </th> 
            <th>Delete
            </th>
          </tr> 
          <!-- for each to display data -->
                <?php foreach ($result as $event) : ?>
          <tr>  
            <td>
              <img style="width: 110px; height: 110px" alt="image"
                   src="/images/<?=e_attr($event['image'])?>" />
            </td>
            <td>
                    <?=$event['event_name']?>
            </td>
            <td>
                    <?=$event['type_of_event']?>
            </td>  
            <td>
                    <?=$event['event_time']?>
            </td> 
            <td>
                    <?=$event['rating']?>
            </td>   
            <td>
              <button><a href="/admin_edit_events.php?id=<?=$event['event_id']?>">Edit
              </a></button>
            </td>  
            <td>
              <button> <a href="/admin_delete_event.php?id=<?=$event['event_id']?>">Delete
              </a></button>
            </td>
          </tr>
                <?php endforeach; ?>   
          <!--if condition to check the flag to display specific result -->
            <?php elseif ($method==true) :?> 
          <tr> 
            <th>Image
            </th>
            <th>Event Name
            </th>
            <th>Event Type
            </th>
            <th>Timing
            </th>
            <th>Rating
            </th>
            <th>View
            </th> 
            <th>Delete
            </th> 
          </tr>
          <tr>  
            <td>
              <img style="width: 110px; height: 110px" alt="image"
                   src="/images/<?=e_attr($result['image'])?>" />
            </td>
            <td>
                <?=$result['event_name']?>
            </td>
            <td>
                <?=$result['type_of_event']?>
            </td>  
            <td>
                <?=$result['event_time']?>
            </td> 
            <td>
                <?=$result['rating']?>
            </td>  
            <td>
              <button><a href="/admin_edit_events.php?id=<?=$result['event_id']?>">Edit
              </a></button>
            </td>  
            <td>
              <button> <a href="/admin_delete_event.php?id=<?=$result['event_id']?>">Delete
              </a></button>
            </td> 
          </tr>
            <?php elseif ($method==' ') :?> 
              <!--not found -->
              <p> NOT FUND
              </p>
            <?php endif;?>
        </table>  
    </div> 
</main>
  <!--php include footer --> 
<?php include __DIR__ . '/../inc/admin_footer.inc.php'; ?>  
