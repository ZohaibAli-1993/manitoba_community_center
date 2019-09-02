<?php

//title and page variables
$title = 'Manitoba Community Center';
$page = 'Registering Information';
//include files
include __DIR__ . '/../config/config.php';
include __DIR__ . '/../inc/functions.php';

$user_id = intval($_SESSION['user_id']);

//  query (remeber it will have a parameter)

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

// fetch your result
$result = $stmt->fetch(PDO::FETCH_ASSOC);
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
        <a href="#">Create Orders</a>
        <a href="admin_orders.php">Orders Lists</a>
        
      </div> 
      <button class="dropdown-btn">Sponser 
        <i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-container">
        <a href="#">Create Sponser</a>
        <a href="#">Sponser Lists</a>
        
      </div> 
       <button class="dropdown-btn">Participants 
        <i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-container">
        <a href="#">Create Participant</a>
        <a href="#">Participants Lists</a>
        
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
<?php require '../inc/flash.inc.php';?>
    <!-- Display Information in Table-->  
  <div class="container emp-profile"> 
    <div class="position">
   <img style="width: 110px; height: 110px"
    src="/images/images.png" />
    <div class="col-md-6">
        <div class="profile-head">
          <h2>Registration Profile </h2>
          
        </div>
    </div>  
  </div>
   <!--Table to diaplay all the information from queries -->
    <table id="prof"> 
      <!-- Tables Heading -->
      <tr>
        <th>Fields</th>
        <th>Values</th>
        
      </tr>
      <tr>
        <td>First Name</td>
        <td><?=$result['first_name']?></td>
        
      </tr> 
      <!-- Tables values -->
      <tr>
        <td>Last Name</td>
        <td><?=$result['last_name']?></td>
      </tr>
      <tr>
        <td>Age</td>
        <td><?=$result['age']?></td>
      </tr>
      <tr>
        <td>Street</td>
        <td><?=$result['street']?></td>
      </tr>
      <tr>
        <td>Postal Code</td>
        <td><?=$result['postal_code']?></td>
      </tr>
      <tr>
        <td>Province</td>
        <td><?=$result['province']?></td>
      </tr>
       <tr>
        <td>Country</td>
        <td><?=$result['country']?></td>
      </tr>
      <tr>
      
        <td>Phone</td>
        <td><?=$result['phone']?></td>
      
      </tr>
      <tr>
      
        <td>Email</td>
        <td><?=$result['email']?></td>
      
      </tr>
      <tr>
      
        <td>Created At</td>
        <td><?=$result['created_at']?></td>
      
      </tr> 
      <tr>
      
        <td>Updated At</td>
        <td><?=$result['updated_at']?></td>
      
      </tr> 

    </table>
  </div>
      </div> 
</main> 
     <!--php include footer -->
<?php include __DIR__ . '/../inc/admin_footer.inc.php'; ?>  
