<?php
//title and page variables
$title = 'Manitoba Community Center';
$page = 'Registering Information';
//include files
include __DIR__ . '/../config/config.php';
include __DIR__ . '/../classes/Validator.php';
include __DIR__ . '/../inc/functions.php';
//only user_id can access
if (empty($_SESSION['user_id'])||empty($_SESSION['event_id'])) {
    setFlash('errorS', 'Not Authorized OR Event Not selected!');
    header('Location: login.php');
    die;
}
//empty array
$errors=[];
//vlaidation object creation
$v = new Validator();
//userid session to store into respective variables
$event_id = intval($_SESSION['event_id']);
$user_id = intval($_SESSION['user_id']);
$query = 'SELECT  
          *  
          FROM  
          event
          WHERE
          event_id= :event_id';
// create your param array
$params = [
':event_id' => $event_id
];
// prepare query
$stmt = $dbh->prepare($query);
// execute query with params
$stmt->execute($params);
// fetch your result
$event = $stmt->fetch(PDO::FETCH_ASSOC);
// get dbh connect (include connect)
// create query (remeber it will have a parameter)
$query ='SELECT  
         *  
         FROM  
         participant
         WHERE
         user_id= :user_id';
// create your param array
$params = [
':user_id' => $user_id
];
// prepare query
$stmt = $dbh->prepare($query);
// execute query with params
$stmt->execute($params);
// fetch your result
$result = $stmt->fetch(PDO::FETCH_ASSOC);
//post reques method
if ('POST' == $_SERVER['REQUEST_METHOD']) {
    // array to store require field
    $required=array('donation','owner','cvv','cardNumber');
    //foreach array to check validation
    foreach ($required as $key => $value) {
        $v->required($value);
    }
    //validation function to check field datatype
    $v->stringFunc('owner');
    $v->integerFunc('donation');
    $v->cvv('cvv');
    $v->card_num('cardNumber');
   
    //condition to check error
    if (!$v->errors()) {
        $query ='INSERT  
                 INTO  
                 Orders
                 (user_id,name , phone , street , postal_code ,province,  event_name , event_time, donation)
                 VALUES 
                 (:user_id,:name ,:phone ,:street ,:postal_code ,:province,  :event_name , :event_time, :donation)';
        //parameters
        $params =array(
                    ':user_id'=>$result['user_id'] ,
                    ':name'=> $_POST['owner'] ,
                    ':phone'=>$result['phone'] ,
                    ':street'=>$result['street'],
                    ':postal_code'=>$result['postal_code'] ,
                    ':province'=>$result['province'],
                    'event_name'=>$event['event_name'] ,
                    ':event_time'=>$event['event_time'],
                    ':donation'=>intval($_POST['donation'])
        );
        try {
            //prepare query with with params
            $stmt = $dbh->prepare($query);
            //conditon to check wether query executes or not
            if ($stmt->execute($params)) {
                $order_id = $dbh->lastInsertId();
                 
                 
                 
                 $_SESSION['order_id']=$order_id;
                setFlash('success', "You've successfully Registered");
                //next page path
                header('Location: event_register.php');
                die;
            } else {
                //message to diaplay
                $errors['INSERT'] = 'Registartion is incomplete!';
            } // if execute
        } catch (Exception $e) {
            //display message
            echo $e->getMessage();
        }
    }
}
$errors=$v->errors();
//include files
include __DIR__ . '/../inc/header.inc.php';
include __DIR__ . '/../inc/main_nav.inc.php';
include __DIR__ . '/../inc/slider.inc.php';
?>  
<main>    
    <?php require '../inc/flash.inc.php';?>
  <!-- Display Information in Table-->   
  <form method="post"  action="<?=basename($_SERVER['PHP_SELF'])?>"  novalidate>
    <div class="container emp-profile">
      <div class="col-md-6">
        <div class="profile-head">
          <h2> User Information
          </h2>
        </div>
      </div> 
      <table id="prof">
        <tr>
          <th>Fields
          </th>
          <th>Values
          </th>
        </tr>
        <tr>
          <td>First Name
          </td>
          <td>
            <?=e_attr($result['first_name'])?>
          </td>
        </tr>
        <tr>
          <td>Last Name
          </td>
          <td>
            <?=e_attr($result['last_name'])?>
          </td>
        </tr>
        <tr>
          <td>Age
          </td>
          <td>
            <?=e_attr($result['age'])?>
          </td>
        </tr>
        <tr>
          <td>Street
          </td>
          <td>
            <?=e_attr($result['street'])?>
          </td>
        </tr>
        <tr>
          <td>Postal Code
          </td>
          <td>
            <?=e_attr($result['postal_code'])?>
          </td>
        </tr>
        <tr>
          <td>Province
          </td>
          <td>
            <?=e_attr($result['province'])?>
          </td>
        </tr>
        <tr>
          <td>Country
          </td>
          <td>
            <?=e_attr($result['country'])?>
          </td>
        </tr>
        <tr>
          <td>Phone
          </td>
          <td>
            <?=e_attr($result['phone'])?>
          </td>
        </tr>
        <tr>
          <td>Email
          </td>
          <td>
            <?=e_attr($result['email'])?>
          </td>
        </tr>
        <tr>
          <td>Created At
          </td>
          <td>
            <?=e_attr($result['created_at'])?>
          </td>
        </tr> 
        <tr>
          <td>Updated At
          </td>
          <td>
            <?=e_attr($result['updated_at'])?>
          </td>
        </tr> 
      </table>
      <hr>  
      <h2> Event information 
      </h2>   
      <br/> 
      <table id="prof" >
        <tr>
          <th>Fields
          </th>
          <th>Values
          </th>
        </tr>
        <tr>
          <td>Event Name
          </td>
          <td>
            <?=e_attr($event['event_name'])?>
          </td>
        </tr>
        <tr>
          <td>Event Type
          </td>
          <td>
            <?=e_attr($event['type_of_event'])?>
          </td>
        </tr> 
        <tr>
          <td>Event Time
          </td>
          <td>
            <?=e_attr($event['event_time'])?>
          </td>
        </tr>
        <tr>
          <td>Created At
          </td>
          <td>
            <?=e_attr($event['created_at'])?>
          </td>
        </tr>
        <tr>
          <td>Updated At
          </td>
          <td>
            <?=e_attr($event['updated_at'])?>
          </td>
        </tr> 
        <tr>
          <td>Description
          </td>
          <td>
            <?=e_attr($event['description'])?>
          </td>
        </tr>
      </table>  
      <hr> 
      <h2> Donation is option 
      </h2>  
      <br/>  
      <div class="form-group amount">
        <label for="owner">Amount
        </label>
        <input type="text" class="form-control" id="donation"  name="donation" placeholder="Amount"  value="<?=clean('donation')?>"> 
        <?=(isset($errors['donation'])) ? "<span class='error'>{$errors['donation']}</span>" : '' ?>
      </div>
      <div class="form-group owner">
        <label for="owner">Owner
        </label>
        <input type="text" class="form-control" id="owner" name="owner" placeholder="Owner"   value="<?=clean('owner')?>"> 
      </div > 
      <div class="form-group owner">  
        <?=(isset($errors['owner'])) ? "<span class='error'>{$errors['owner']}</span>" : '' ?>
      </div>
      <div class="form-group CVV">
        <label>CVV
        </label>
        <input type="text" class="form-control" name="cvv" placeholder="CVV(000)" id="CVV"  value="<?=clean('cvv')?>"> 
        <?=(isset($errors['cvv'])) ? "<span class='error'>{$errors['cvv']}</span>" : '' ?>
      </div>
      <div class="form-group" id="card-number-field">
        <label >Card Number
        </label>
        <input type="text" class="form-control" name="cardNumber" placeholder="Nubmer" id="cardNumber(10 digit number)"  value="<?=clean('cardNumber')?>"> 
        <?=(isset($errors['cardNumber'])) ? "<span class='error'>{$errors['cardNumber']}</span>" : '' ?>
      </div>
      <div class="form-group" id="expiration-date">
        <label>Expiration Date
        </label>
        <select>
          <option value="01">January
          </option>
          <option value="02">February 
          </option>
          <option value="03">March
          </option>
          <option value="04">April
          </option>
          <option value="05">May
          </option>
          <option value="06">June
          </option>
          <option value="07">July
          </option>
          <option value="08">August
          </option>
          <option value="09">September
          </option>
          <option value="10">October
          </option>
          <option value="11">November
          </option>
          <option value="12">December
          </option>
        </select>
        <select>
          <option value="16"> 2016
          </option>
          <option value="17"> 2017
          </option>
          <option value="18"> 2018
          </option>
          <option value="19"> 2019
          </option>
          <option value="20"> 2020
          </option>
          <option value="21"> 2021
          </option>
        </select>
      </div>
      <div class="form-group" id="credit_cards" >
        <img src="/images/visa.jpg" id="visa" alt="visa">
        <img src="/images/mastercard.jpg" id="mastercard" alt="mastercard">
        <img src="/images/amex.jpg" id="amex" alt="amex">
      </div>
      <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token']?>" /> 
      <button >Submit this page
      </button> 
    </div>
  </form>
</main>  
<!--php include footer -->
<?php include __DIR__ . '/../inc/footer.inc.php'; ?> 
