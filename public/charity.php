<?php
//title and page variables
$title = 'Manitoba Community Center';
$page= 'List View';
include __DIR__ . '/../config/config.php';
include __DIR__ . '/../inc/functions.php';

if ('POST' == $_SERVER['REQUEST_METHOD']) {
    //flag to true to html form
    $method=true;
    $search=$_POST['search'];
    //Createquery
    $query ="SELECT  
             *  
             FROM  
             event
             WHERE
             event_name Like :event_name  
             AND  
             category='charity'";
    // create  param array
            $params = [
            ':event_name' =>"%{$search}%"
            ];
    // prepare query
            $stmt = $dbh->prepare($query);
    // execute query with params
            if (!empty($stmt->execute($params))) {
                // fetch your result
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $method='';
            }
} else {
    //flag to false to html form
    $method=false;
    //create query
    $query ="SELECT  
             *  
             FROM 
             event  
             Where  
             category='charity'";
    //prpare query
    $stmt=$dbh->query($query);
    //get all the data by using fetch All
    $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
}
//include files
include __DIR__ . '/../inc/header.inc.php';
include __DIR__ . '/../inc/main_nav.inc.php';
include __DIR__ . '/../inc/slider.inc.php';
?>  
<main>    
    <?php require '../inc/flash.inc.php';?>
  <!-- Display Information in Table-->   
  <!--Side Navigation -->
    <div class="sidenav">
    <a href="events_view.php">Events List
    </a>
    <a href="sports.php">Sports
    </a>
    <a href="festival.php">Festival
    </a>
    <a href="charity.php">Charity
    </a>
    </div> 


    <div class='main'>
       <h2>Sports List 
       </h2> 
       <!--Search form -->
       <form class="example" action="<?=$_SERVER['PHP_SELF']?>" method="post" novalidate> 
          <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token']?>" />
          <input type="text" placeholder="Search.." name="search" id="search"  value="<?=clean('search')?>">
          <button type="submit">
          <i class="fa fa-search">
          </i>
          </button>
       </form>
       <br/>  


       <!-- Table used to show data -->
       <table id="prof">  
       <!--if condition used to check whether to display all the charity --> 
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
          </tr> 
          <!--foreach used to display all the data from table -->
                <?php foreach ($result as $event) : ?>
          <tr>
             <td>
                <img style="width: 110px; height: 110px"
                   src="/images/<?=e_attr($event['image'])?>" />
             </td>
             <td>
                    <?=e_attr($event['event_name'])?>
             </td>
             <td>
                    <?=e_attr($event['type_of_event'])?>
             </td>
             <td>
                    <?=e_attr($event['event_time'])?>
             </td>
             <td>
                    <?=e_attr($event['rating'])?>
             </td>
             <td>
                <a href="/event_show.php?id=<?=$event['event_id']?>">View
                </a>
             </td>
          </tr>
                <?php endforeach; ?> 
          <!--if condition used to check whether to specific charity --> 
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
          </tr>
          <tr>
             <td>
                <img style="width: 110px; height: 110px"
                   src="/images/<?=e_attr($result['image'])?>" />
             </td>
             <td>
                <?=e_attr($result['event_name'])?>
             </td>
             <td>
                <?=e_attr($result['type_of_event'])?>
             </td>
             <td>
                <?=e_attr($result['event_time'])?>
             </td>
             <td>
                <?=e_attr($result['rating'])?>
             </td>
             <td>
                <a href="/event_show.php?id=<?=$result['event_id']?>">View
                </a>
             </td>
          </tr>
            <?php else :?>
          <p> NOT FOUND
          </p>
            <?php endif;?> 

       </table>
    </div>
  <!--php include footer --> 
    <?php include __DIR__ . '/../inc/footer.inc.php'; ?> 
