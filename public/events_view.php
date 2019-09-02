<?php
//title and page variables
$title = 'Manitoba Community Center';
$page= 'List View';
//all the files
include __DIR__ . '/../config/config.php';
include __DIR__ . '/../inc/functions.php';
//default flag set to false initially for condition to dispaly
$method=false;

// Post server request method
if ('POST' == $_SERVER['REQUEST_METHOD']) {   //flag for searh form and dispaly data related to specific query
    $method=true;
    $search=$_POST['search'];
    //query
    $query = 'SELECT  
              *  
              FROM  
              event
              WHERE
              event_name LIKE :event_name';
    // create your param array
    $params =[
              ':event_name' =>"%{$search}%"
    ];
    // prepare query
    $stmt = $dbh->prepare($query);
    // execute query with params
    $stmt->execute($params);
    // fetch your result
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    //session
    $_SESSION['event_id']=e_attr($result['event_id']);
} else {
    //query to display all the data from table
    $query = 'SELECT  
              *  
             FROM  
             event';
    //prepare yhe queries
    $stmt=$dbh->query($query);
    //fetch alll the result from query result
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

      <h2>List View</h2> 
      <!--form to display -->
      <form class="example" action="<?=$_SERVER['PHP_SELF']?>"  
        method="post" novalidate>  
        <!-- csrf token to secure  secure data -->
        <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token']?>" /> 
        <!--Search field -->
        <input type="text" placeholder="Search.." name="search" id="search"  value="<?=clean('search')?>"> 
        <!--Submit button -->
        <button type="submit">
          <i class="fa fa-search"></i>
        </button>
      </form>  

    <!--line -->
    <br/> 

    <!--table headings -->
    <table id="prof"> 
      <!--condition to diplay all the events -->
        <?php if ($method==false) :?> 
      <tr>  
       <!-- TableHeadings --> 
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
      <!-- for each to display all the evnts -->
            <?php foreach ($result as $event) : ?>
      <tr>  
        <td>
          <img style="width: 110px; height: 110px"
               src="/images/<?=e_attr($event['image'])?>" alt='image' />
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
          <a href="/event_show.php?id=<?=e_attr($event['event_id'])?>">View
          </a>
        </td> 
      </tr>
            <?php endforeach; ?>   
      <!--else if condition to check the condition for search form-->
        <?php elseif (($method==true)) :?> 
      <!-- TableHeadings -->  
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
      <!-- Data accoring to headings --> 
      <tr>  
        <td>
          <img style="width: 110px; height: 110px"
               src="/images/<?=e_attr($result['image'])?>" alt='image' />
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
          <a href="/event_show.php?id=<?=e_attr($result['event_id'])?>">View
          </a>
        </td> 
      </tr> 
      <!-- Condtion if data not found --> 
        <?php else :?>
      <p> NOT FUND
      </p>
        <?php endif;?> 
    <!-- Table End --> 
    </table> 


  </div> 
</main>
  <!--php include footer --> 
<?php include __DIR__ . '/../inc/footer.inc.php'; ?>  
