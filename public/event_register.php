<?php
//title and page variables
$title = 'Manitoba Community Center';
$page = 'Event Register';
include __DIR__ . '/../config/config.php';
include __DIR__ . '/../inc/functions.php';
//only user_id can access
if (empty($_SESSION['user_id'])) {
    setFlash('errorS', 'Not Authorized!');
    header('Location: login.php');
    die;
}
$user_id = intval($_SESSION['order_id']);
// get dbh connect (include connect)
// create query (remeber it will have a parameter)
$query = 'SELECT  
          *  
          FROM  
          Orders
          WHERE
          order_id= :user_id';
// create your param array
$params =[
        ':user_id' => $user_id
];
// prepare query
$stmt = $dbh->prepare($query);
// execute query with params
$stmt->execute($params);
// fetch your result
$result = $stmt->fetch(PDO::FETCH_ASSOC);
//total value by minus the GST AND PST
$total=$result['donation']-number_format(getPst(intval($result['donation'])), 2)-number_format(getGst(intval($result['donation'])), 2);
//include files
include __DIR__ . '/../inc/header.inc.php';
include __DIR__ . '/../inc/main_nav.inc.php';
include __DIR__ . '/../inc/slider.inc.php';
?>  
<main>    
    <?php require '../inc/flash.inc.php';?>
  <!-- Display Information in Table-->   
  <div class="container emp-profile">
    <div class="profile-head">
      <h1> Thank you for registration
      </h1> 
      <h2> Reciept
      </h2>
    </div>
    <table>
      <tr>
        <th>Name
        </th>
        <th>Phone
        </th>
        <th>Street
        </th>
        <th>Event Name
        </th>
      </tr>
      <tr>
        <td>
            <?=$result['name']?>
        </td>
        <td>
            <?=$result['phone']?>
        </td>
        <td>
            <?=$result['street']?>
        </td> 
        <td>
            <?=$result['event_name']?>
        </td>
      </tr>
      <tr>
        <td colspan="3">
          Donation:
        </td>
        <td>
          
            <?=intval($result['donation'])?>
        </td>
      </tr>
      <tr>
        <td colspan="3">
          PST:
        </td>
        <td>
          
            <?=number_format(getPst(intval($result['donation'])), 2)?>
        </td>
      </tr>
      <tr>
        <td colspan="3">
          GST:
        </td>
        <td>
          
            <?=number_format(getGst(intval($result['donation'])), 2)?>
        </td>
      </tr> 
      <tr>
        <td colspan="3">
          Total:
        </td>
        <td>
          $
            <?=$total?>
        </td>
      </tr> 
    </table>
  </div>      
</main>  
<!--php include footer -->
<?php include __DIR__ . '/../inc/footer.inc.php'; ?> 
