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
//  aggregate query
$query="SELECT  
        count(order_id) as count, 
        max(donation) as max_don, 
        min(donation) as min_don, 
        avg(donation) as avg_don
        FROM  
        Orders";
//execute the query
$stmt=$dbh->query($query);
//fetch the  all the result from database
$result = $stmt->fetch(\PDO::FETCH_ASSOC);
$count=$result['count'];
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
        <?php require '../inc/flash.inc.php';?> 
      <br/> 
      <h1>Welcome to Admin Page</h1>  
       <br/> 
      <h2>Aggregate Functions</h2> 
      <br/> 
         <table id="prof">
              <tr>
                <th>Attributes</th>
                <th>Aggregate</th>
              </tr>   
              <tr>
                <td>Number of people</td>
                <td><?=$result['count']?></td>
              </tr> 
              <tr>
                <td>Maximum Donation</td>
                <td><?=$result['max_don']?></td>
              </tr> 
              <tr>
                <td>Minimum Donation</td>
                <td><?=$result['min_don']?></td>
              </tr> 
              <tr>
                <td>Average Donation</td>
                <td><?=number_format(intval($result['avg_don']), 2)?></td>
              </tr>
            </table>  
            <div id="piechart"></div>

            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

            <script type="text/javascript">
            // Load google charts
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            // Draw the chart and set the chart values
            function drawChart() {
              var data = google.visualization.arrayToDataTable([
              ['Task', 'Hours per Day'],
              ['Number of people',<?=$result['count']?> ],
              ['Maximum Donation',<?=$result['max_don']?>],
              ['Minimum Donation',<?=$result['min_don']?>],
              ['Average Donation', <?=number_format(intval($result['avg_don']), 2)?>],
              
            ]);

              // Optional; add a title and set the width and height of the chart
              var options = {'title':'Aggregate', 'width':550, 'height':400};

              // Display the chart inside the <div> element with id="piechart"
              var chart = new google.visualization.PieChart(document.getElementById('piechart'));
              chart.draw(data, options);
            }
            </script>
    </div> 
</main> 
<!-- include files --> 
<?php include __DIR__ . '/../inc/admin_footer.inc.php'; ?> 
