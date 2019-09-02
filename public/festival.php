<?php
//title and page variables
$title = 'Manitoba Community Center';
$page= 'List View';
// include files
include __DIR__ . '/../config/config.php';
include __DIR__ . '/../inc/functions.php';

if ('POST' == $_SERVER['REQUEST_METHOD']) {
    $method=true;
    $search=$_POST['search'];
    $query = "SELECT  
              *  
              FROM  
              event
              WHERE
              event_name LIKE :event_name  
              AND  
              category='festival'";
    // create your param array
    $params =[
              ':event_name' =>"%{$search}%"
    ];
    // prepare query
    $stmt = $dbh->prepare($query);
    // execute query with params
    if (!empty($stmt->execute($params))) {
    // fetch  result
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
      //empty flag
        $method='';
    }
} else {
  // flag for query wher category where condition equal to festival
    $method=false;
  //create query
    $query = "SELECT * from event Where category='festival'";
  //prepare query
    $stmt=$dbh->query($query);
  //fetch all the result into variable
    $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
} //close else
//include files
include __DIR__ . '/../inc/header.inc.php';
include __DIR__ . '/../inc/main_nav.inc.php';
include __DIR__ . '/../inc/slider.inc.php';
?>  
<main>    
    <?php require '../inc/flash.inc.php';?>
  <!-- side navigation bar -->
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
    <!--search form -->
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
      <!--it is run to display all events related to  festival events -->
        <?php if ($method==false) :?>  
        <!--table headings -->
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
      <!--using to display infromation data related -->
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
      <!--it is run to display  specific event related to events -->
        <?php elseif ($method==true) :?>  
      <!--table headings -->
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
