<?php

//title and page variables
$title = 'Manitoba Community Center';
$page = 'Registering Information';
$page2 = 'Log Information';
//include files
include __DIR__ . '/../config/config.php';
include __DIR__ . '/../inc/functions.php';
//session event id assigned into user_id
$user_id = intval($_SESSION['user_id']);

//  query
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
//include files
include __DIR__ . '/../inc/header.inc.php';
include __DIR__ . '/../inc/main_nav.inc.php';
include __DIR__ . '/../inc/slider.inc.php';
?>  

    <div id="grad1"> 

          <form method="post"
                action="#"
                autocomplete="on" accept-charset="utf-8" id="subscribe-blog"> 

            <p>Subscribe to our newsletter.
                <input type="text" placeholder="Email address" name="mail" required>
                <input type="submit" id="submit" name="Subscribe" value="Subscribe"> 
            </p>
          </form>
      </div>
      
      <main>    
        <?php require '../inc/flash.inc.php';?>
    <!-- Display  Log Information in Table-->  
        <h1><?=$page2 ?></h1>
        <table id="users">
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
        
      </main> 
     <!--php include footer -->
    <?php include __DIR__ . '/../inc/footer.inc.php'; ?>  
