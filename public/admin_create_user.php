<?php
//title and page variables
$title = 'Manitoba Community Center';
$page = 'Events Registration';
// Include required files
include __DIR__ . '/../inc/functions.php';
include __DIR__ . '/../classes/Validator.php';
include __DIR__ . '/../config/config.php';
//create new object
if (empty($_SESSION['user_id'])||!$_SESSION['admin']) {
    setFlash('errorS', 'Not Authorized!');
    header('Location: login.php');
    die;
}
//Validtor new object
$v = new Validator();

// if POST SERVER REQUEST METHOD
if ('POST' == $_SERVER['REQUEST_METHOD']) {
//Required array for empty arrays
    $required=array('f_name','email','l_name','age','street','city','postal_code','province','country','password','confirm_password','created_at','updated_at');
    foreach ($required as $key => $value) {
        $v->required($value);
    }
    // validate required fields
    $v->stringFunc('f_name');
    $v->stringFunc('l_name');
    $v->integerFunc('age');
     $v->integerFunc('phone');
    $v->stringFunc('street');
    $v->stringFunc('city');
    $v->stringFunc('province');
    $v->stringFunc('country');
    $v->passfunc('password');
    $v->passfunc('confirm_password');
    $v->matchPassword('password', 'confirm_password');
    $v->email('email');
    $v->testTime('created_at');
    $v->testTime('updated_at');
// if no errors
    if (!$v->errors()) {
        $dbh->beginTransaction();
//query
        $query = 'INSERT  INTO  
                    participant
                    (first_name,last_name,age,street,city,postal_code,province,country,phone,email,password,confirm_password,created_at,updated_at)
                    VALUES 
                    (:first_name,:last_name,:age,:street,:city,:postal_code,:province,:country,:phone,:email,:password,:confirm_password,:created_at,:updated_at)';
//parameters
        $params = array(
                  ':first_name' => e_attr($_POST['f_name']),
                  ':last_name' => e_attr($_POST['l_name']),
                  ':age' => e_attr($_POST['age']),
                  ':street'=> e_attr($_POST['street']),
                  ':city' => e_attr($_POST['city']),
                  ':postal_code' =>e_attr($_POST['postal_code']),
                  ':province' => e_attr($_POST['province']),
                  ':country' =>e_attr($_POST['country']),
                  ':phone' => e_attr($_POST['phone']),
                  ':email' => e_attr($_POST['email']),
                  //hash function used  on password
                  ':password' => password_hash(e_attr($_POST['password']), PASSWORD_DEFAULT),
                  ':confirm_password' => e_attr($_POST['confirm_password']),
                  ':created_at' => e_attr($_POST['created_at']),
                  ':updated_at' => e_attr($_POST['updated_at'])
                  );
// try and catch for errors
        try {
            $stmt = $dbh->prepare($query);
            //check execute statement
            if ($stmt->execute($params)) {
                //last user us from table
                 $user_id = $dbh->lastInsertId();
                 $dbh->commit();
                 //Session of user id
                 $_SESSION['user_id']=$user_id;
                  setFlash('success', 'Successfully Updated!');
                  //redirect
                  header('Location: admin_participant_list.php');
                  die;
            } else {
              //flash message
                $errors['INSERT'] = 'There was a problem updating that event!';
            }  // if execute
        } catch (Exception $e) {
            $dbh->rollBack();
            echo $e->getMessage();
        }//closing catch statement
    }//closing error condition
}// closing post request method
include __DIR__ . '/../inc/admin_header.inc.php';
?> 
<main>   
    <!-- Events-->  
    <h1><?=$page ?></h1>
    <div class="container">

      <!-- basename trims a file path to the base filename.  Without
          basename, $_SERVER['PHP_SELF'] is the full path to the file --> 
          <!--Event Registration Form -->
      <form action="<?=basename($_SERVER['PHP_SELF'])?>" method="post" novalidate>
      <fieldset>
          <legend>Event Registering</legend> 
          <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token']?>" />
          <p> 
          <!-- First Name -->
              <label for="f_name">First Name</label><br />
              <input type="text" name="f_name" id="f_name" placeholder="First name"
              value="<?=clean('f_name')?>" />
                <?=(isset($errors['f_name'])) ? "<span class='error'>{$errors['f_name']}</span>" : '' ?>
          </p>  
          <!-- Last Name -->
          <p>
              <label for="l_name">Last Name</label><br />
              <input type="text" name="l_name" id="l_name" placeholder="Last name"
              value="<?=clean('l_name')?>" />
                <?=(isset($errors['l_name'])) ? "<span class='error'>{$errors['l_name']}</span>" : '' ?>
          </p>   
          <!-- Age -->
          <p>
              <label for="age">Age</label><br />
              <input type="text" name="age" id="age"  placeholder="Age must be in number"
              value="<?=clean('age')?>" />
                <?=(isset($errors['age'])) ? "<span class='error'>{$errors['age']}</span>" : '' ?>
          </p> 
          <!-- Street -->
          <p>
              <label for="street">Street</label><br />
              <input type="text" name="street" id="street" placeholder="Street"
              value="<?=clean('street')?>" />
                <?=(isset($errors['street'])) ? "<span class='error'>{$errors['street']}</span>" : '' ?>
          </p> 
          <!-- City -->
          <p>
              <label for="city">City</label><br />
              <input type="text" name="city" id="city" placeholder="City Name"
              value="<?=clean('city')?>" />
                <?=(isset($errors['city'])) ? "<span class='error'>{$errors['city']}</span>" : '' ?>
          </p>    
          <!-- Postal Code -->
          <p>
              <label for="postal_code">Postal Code</label><br />
              <input type="text" name="postal_code" id="postal_code" placeholder="Postal Code"
              value="<?=clean('postal_code')?>" />
                <?=(isset($errors['postal_code'])) ? "<span class='error'>{$errors['postal_code']}</span>" : '' ?>
          </p>   
          <!-- Province -->
          <p>
              <label for="province">Province</label><br />
              <input type="text" name="province" id="province"  placeholder="Province"
              value="<?=clean('province')?>" />
                <?=(isset($errors['province'])) ? "<span class='error'>{$errors['province']}</span>" : '' ?>
          </p>   
          <!-- Country -->
            <p>
              <label for="country">Country</label><br />
              <input type="text" name="country" id="country" placeholder="Country Name"
              value="<?=clean('country')?>" />
                <?=(isset($errors['country'])) ? "<span class='error'>{$errors['country']}</span>" : '' ?>
          </p>  
          <!-- Phone -->
          <p>
              <label for="phone">Phone</label><br />
              <input type="text" name="phone" id="phone" placeholder="Phone"
              value="<?=clean('phone')?>" />
                <?=(isset($errors['phone'])) ? "<span class='error'>{$errors['phone']}</span>" : '' ?>
          </p> 
          <!-- Email -->
          <p>
              <label for="email">Email</label><br />
              <input type="text" name="email" id="email" placeholder="email"
              value="<?=clean('email')?>" />
                <?=(isset($errors['email'])) ? "<span class='error'>{$errors['email']}</span>" : '' ?>
          </p>  
          <!-- Password -->
            <p>
              <label for="password">Password</label><br />
              <input type="password" name="password" id="password"  placeholder="Password"
              value="<?=clean('password')?>" />
                <?=(isset($errors['password'])) ? "<span class='error'>{$errors['password']}</span>" : '' ?>
          </p>  
          <!-- Confirm Password -->
          <p>
              <label for="confirm_password">Confirm Password</label><br />
              <input type="password" name="confirm_password" id="confirm_password" placeholder="Conform Password"
              value="<?=clean('confirm_password')?>" />
               
                <?=(isset($errors['match'])) ? "<span class='error'>{$errors['match']}</span>" : '' ?>
          </p>  
          <!-- Cretaed at -->
          <p>
              <label for="created_at">Created at</label><br />
              <input type="text" name="created_at" id="created_at" placeholder="yyyy-mm-dd"
              value="<?=clean('created_at')?>" />
                <?=(isset($errors['created_at'])) ? "<span class='error'>{$errors['created_at']}</span>" : '' ?>
          </p>  
          <!-- Updated at -->
          <p>
              <label for="updated_at">Updated at</label><br />
              <input type="text" name="updated_at" id="updated_at" placeholder="yyyy-mm-dd"
              value="<?=clean('updated_at')?>" />
                <?=(isset($errors['updated_at'])) ? "<span class='error'>{$errors['updated_at']}</span>" : '' ?>
          </p>
          <p><input type="submit" value="submit" /></p>
      </fieldset>
      </form>
    </div>
</main>  
<!--php include footer -->
<?php include __DIR__ . '/../inc/admin_footer.inc.php'; ?>   
