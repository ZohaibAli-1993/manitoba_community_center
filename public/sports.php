<?php
//title and page variables
$title = 'Manitoba Community Center';
$page= 'List View';
include __DIR__ . '/../config/config.php';
include __DIR__ . '/../inc/functions.php';
//Post server request methid
if ('POST' == $_SERVER['REQUEST_METHOD']) {   //flag to set option for search on the same page and it is for serach events
    $method=true;
    $search=$_POST['search'];
    //query
    $query = "SELECT  
              *  
              FROM  
              event
              WHERE
              event_name LIKE :event_name  
              AND  
              category='sports'";
    //  param array
    $params =[
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
     
//end post reuwst condition
} else {   //flag to get all the event list
    $method=false;
    $query = "SELECT  
              *  
              FROM  
              event  
              Where  
              category='sports'";
    //execute the query
    $stmt=$dbh->query($query);
    //fetch all the record
    $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
//close else condition
}
//include files
include __DIR__ . '/../inc/header.inc.php';
include __DIR__ . '/../inc/main_nav.inc.php';
include __DIR__ . '/../inc/slider.inc.php';
?>  
<main>    
    <?php require '../inc/flash.inc.php';?>
  <!--side navigation-->  
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
    <!--Search field--> 
    <form class="example" action="<?=$_SERVER['PHP_SELF']?>" method="post" novalidate> 
      <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token']?>" />
      <input type="text" placeholder="Search.." name="search" id="search"  value="<?=clean('search')?>">
      <button type="submit">
        <i class="fa fa-search">
        </i>
      </button>
    </form> 
    <br/> 
    <!-- Display Information in Table--> 
    <table id="prof"> 
    <!-- It is run only for earch case--> 
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
      <!-- for each as for loop used to give all the information from tables--> 
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
