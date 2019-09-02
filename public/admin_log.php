<?php

//title and page variables

//include files
include __DIR__ . '/../config/config.php';
include __DIR__ . '/../inc/functions.php';
// security feature only admin can access
if (empty($_SESSION['user_id'])||!$_SESSION['admin']) {
    setFlash('errorS', 'Not Authorized!');
    header('Location: login.php');
    die;
}
//  log query
$query="SELECT   
        * FROM  
        log 
        ORDER BY  
        id  
        DESC  
        LIMIT  10";
//execute the query
$stmt=$dbh->query($query);
//fetch the  all the result from database
$result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
include __DIR__ . '/../inc/admin_header.inc.php';
//include files
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
         <h1>Log Information</h1>
            <table id="prof">
              <tr>
                <th>ID</th>
                <th>Event</th>
              </tr>  
              <!-- using for eacg to display information -->
                <?php foreach ($result as $row) : ?> 
                <tr> 
                    <?php foreach ((array)$row as $col => $value) : ?>
                    <td> 
                        <?php echo e_attr($row[$col])?> 
                    </td>
                    <?php endforeach;?>   
                </tr>
                <?php endforeach;?> 
               
            </table> 
     </div>
    
</main> 
<!-- include files-->
<?php include __DIR__ . '/../inc/admin_footer.inc.php'; ?> 
